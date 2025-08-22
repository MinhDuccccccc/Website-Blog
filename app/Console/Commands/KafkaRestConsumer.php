<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\LoginLog;

class KafkaRestConsumer extends Command
{
    protected $signature = 'kafka:consume-rest';
    protected $description = 'Consume messages from Kafka REST Proxy';

    protected $kafkaRestUrl = 'http://localhost:8082';
    protected $topic = 'user-login';
    protected $groupName = 'user-login-group';
    protected $instanceName;

    public function handle()
    {
        $this->info("Starting Kafka REST consumer...");

        $this->instanceName = 'user-login-instance';

        // Delete old consumer instance if exists
        $delete = Http::delete("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}");
        if ($delete->successful()) {
            $this->info("Existing consumer instance deleted successfully.");
        } elseif ($delete->status() !== 404) {
            $this->warn("Could not delete existing consumer instance: {$delete->body()}");
        }

        // 1. Create consumer instance
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post("{$this->kafkaRestUrl}/consumers/{$this->groupName}", [
            'name' => $this->instanceName,
            'format' => 'json',
            'auto.offset.reset' => 'earliest'
        ]);

        if ($response->failed()) {
            $this->error("Failed to create consumer instance: {$response->body()}");
            return;
        }
        $this->info("Consumer instance created.");

        // 2. Subscribe to topic
        $subscribe = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}/subscription", [
            'topics' => [$this->topic]
        ]);

        if ($subscribe->failed()) {
            $this->error("Failed to subscribe to topic: {$subscribe->body()}");
            return;
        }
        $this->info("Subscribed to topic '{$this->topic}'.");

        // 3. Poll messages in a loop
        $this->info("Listening for messages. Press Ctrl+C to stop.");
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
                            $this->info("Received message: " . json_encode($msg['value']));

                            // Lưu vào MongoDB 
                            try {
                                LoginLog::create([
                                    'user_id'  => $msg['value']['user_id'] ?? null,
                                    'email'    => $msg['value']['email'] ?? 'unknown',
                                    'raw_data' => $msg['value'],
                                ]);
                                $this->info("Saved to MongoDB.");
                            } catch (\Exception $e) {
                                $this->error("Failed to save to MongoDB: " . $e->getMessage());
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
