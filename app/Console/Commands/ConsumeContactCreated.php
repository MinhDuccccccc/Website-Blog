<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ContactLog;

class ConsumeContactCreated extends Command
{
    protected $signature = 'kafka:consume-contact';
    protected $description = 'Consume messages from Kafka REST Proxy for contact-created events';

    protected $kafkaRestUrl = 'http://localhost:8082';
    protected $topic = 'contact-created';
    protected $groupName = 'contact-created-group';
    protected $instanceName = 'contact-consumer';

    public function handle()
    {
        $this->info("Starting Kafka REST consumer for contacts...");

        // Xóa instance cũ nếu còn
        $delete = Http::delete("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}");
        if ($delete->successful()) {
            $this->info("Old consumer instance deleted successfully.");
        }

        // Tạo instance mới
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post("{$this->kafkaRestUrl}/consumers/{$this->groupName}", [
            'name' => $this->instanceName,
            'format' => 'json',
            'auto.offset.reset' => 'earliest',
        ]);

        if ($response->failed()) {
            $this->error("Failed to create consumer instance: {$response->body()}");
            return;
        }

        $this->info("Consumer instance created successfully.");

        // Đăng ký topic
        $subscribe = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}/subscription", [
            'topics' => [$this->topic],
        ]);

        if ($subscribe->failed()) {
            $this->error("Failed to subscribe to topic: {$subscribe->body()}");
            return;
        }

        $this->info("Subscribed to topic '{$this->topic}'.");
        $this->info("Listening for contact-created messages. Press Ctrl+C to stop.");

        // Lắng nghe liên tục
        while (true) {
            try {
                $records = Http::withHeaders([
                    'Accept' => 'application/vnd.kafka.json.v2+json',
                ])->get("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}/records");

                if ($records->failed()) {
                    $this->error("Failed to fetch records: {$records->body()}");
                } else {
                    $messages = $records->json();

                    if (!empty($messages)) {
                        foreach ($messages as $msg) {
                            $rawValue = $msg['value'] ?? null;

                            if ($rawValue) {
                                $value = is_string($rawValue)
                                    ? json_decode($rawValue, true)
                                    : $rawValue;

                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    $this->warn("Invalid JSON format: " . json_last_error_msg());
                                    continue;
                                }

                                try {
                                    ContactLog::create([
                                        'contact_id' => $value['contact_id'] ?? null,
                                        'name'       => $value['name'] ?? '',
                                        'address'    => $value['address'] ?? '',
                                        'phone'      => $value['phone'] ?? '',
                                        'subject'    => $value['subject'] ?? '',
                                        'message'    => $value['message'] ?? '',
                                        'created_at' => $value['created_at'] ?? now(),
                                        'raw_data'   => $value,
                                    ]);

                                    Log::info("Saved contact to MongoDB", ['subject' => $value['subject'] ?? '(no subject)']);
                                    $this->info("Saved contact: " . ($value['subject'] ?? '(no subject)'));
                                } catch (\Exception $e) {
                                    $this->error("Failed to save contact: " . $e->getMessage());
                                }
                            }
                        }
                    } else {
                        $this->info("No new messages. Waiting...");
                    }
                }

                sleep(2);
            } catch (\Exception $e) {
                $this->error("Exception: " . $e->getMessage());
                sleep(2);
            }
        }
    }
}
