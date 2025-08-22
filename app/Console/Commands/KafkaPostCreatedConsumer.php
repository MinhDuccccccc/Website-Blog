<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class KafkaPostCreatedConsumer extends Command
{
    protected $signature = 'kafka:consume-post';
    protected $description = 'Consume post-created messages from Kafka REST Proxy';

    protected $kafkaRestUrl = 'http://localhost:8082';
    protected $topic = 'post-created';
    protected $groupName = 'post-created-group';
    protected $instanceName;

    public function handle()
    {
        $this->info("Starting Kafka consumer for post-created...");

        $this->instanceName = 'post-created-instance';

        // Xoá consumer instance cũ nếu tồn tại
        $delete = Http::delete("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}");
        if ($delete->successful()) {
            $this->info("Old consumer instance deleted.");
        } elseif ($delete->status() !== 404) {
            $this->warn("Could not delete instance: {$delete->body()}");
        }

        // Tạo consumer instance
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post("{$this->kafkaRestUrl}/consumers/{$this->groupName}", [
            'name' => $this->instanceName,
            'format' => 'json',
            'auto.offset.reset' => 'earliest'
        ]);

        if ($response->failed()) {
            $this->error("Failed to create instance: {$response->body()}");
            return;
        }

        $this->info("Consumer instance created.");

        // Subscribe vào topic post-created
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

        // Bắt đầu lắng nghe vòng lặp
        $this->info("Listening for 'post-created' messages. Press Ctrl+C to stop.");

        while (true) {
            try {
                $records = Http::withHeaders([
                    'Accept' => 'application/vnd.kafka.json.v2+json',
                ])->get("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}/records");

                if ($records->failed()) {
                    $this->error("Failed to fetch messages: {$records->body()}");
                } else {
                    $messages = $records->json();
                    if (!empty($messages)) {
                        foreach ($messages as $msg) {
                            $value = $msg['value'];
                            $this->info("Received post-created message: " . json_encode($value));

                            // Xử lý bài viết tại đây (ví dụ lưu log, ghi DB, kiểm duyệt nội dung, gửi notify...)
                        }
                    } else {
                        $this->info("No new messages. Waiting...");
                    }
                }

                sleep(2);

            } catch (\Exception $e) {
                $this->error("Exception occurred: " . $e->getMessage());
                sleep(2);
            }
        }
    }
}
