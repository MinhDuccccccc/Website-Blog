<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CommentLog;

class ConsumeCommentCreated extends Command
{
    protected $signature = 'kafka:consume-comment';
    protected $description = 'Consume messages from Kafka REST Proxy for comment-created events';

    protected $kafkaRestUrl = 'http://localhost:8082'; // hoặc kafka-rest-proxy:8082 nếu chạy trong Docker container
    protected $topic = 'comment-created';
    protected $groupName = 'comment-created-group';
    protected $instanceName = 'comment-consumer';

    public function handle()
    {
        $this->info("Starting Kafka REST consumer for comments...");

        // 0. Xóa instance cũ nếu còn
        $delete = Http::delete("{$this->kafkaRestUrl}/consumers/{$this->groupName}/instances/{$this->instanceName}");
        if ($delete->successful()) {
            $this->info("Existing consumer instance deleted successfully.");
        } elseif ($delete->status() !== 404) {
            $this->warn("Could not delete existing consumer instance: {$delete->body()}");
        }

        // 1. Tạo consumer instance
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

        // 2. Đăng ký topic
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
        $this->info("Listening for comment-created messages. Press Ctrl+C to stop.");

        // 3. Lắng nghe và xử lý tin nhắn
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
                                // Giải mã JSON nếu cần
                                $value = is_string($rawValue)
                                    ? json_decode($rawValue, true)
                                    : $rawValue;

                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    $this->warn("Invalid JSON format: " . json_last_error_msg());
                                    continue;
                                }

                                try {
                                    CommentLog::create([
                                        'comment_id' => $value['comment_id'] ?? null,
                                        'post_id'    => $value['post_id'] ?? null,
                                        'user_id'    => $value['user_id'] ?? null,
                                        'user_name'  => $value['user_name'] ?? 'Anonymous',
                                        'content'    => $value['content'] ?? '',
                                        'created_at' => $value['created_at'] ?? now(),
                                        'raw_data'   => $value,
                                    ]);

                               Log::info("Saved comment to MongoDB", ['content' => $value['content'] ?? '(no content)']);
                               $this->info("Saved comment: " . ($value['content'] ?? '(no content)'));
                                } catch (\Exception $e) {
                                    $this->error("Failed to save comment: " . $e->getMessage());
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
