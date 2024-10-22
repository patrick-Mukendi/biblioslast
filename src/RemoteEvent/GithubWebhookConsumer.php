<?php

namespace App\RemoteEvent;

use Psr\Log\LoggerInterface;
use Symfony\Component\RemoteEvent\Attribute\AsRemoteEventConsumer;
use Symfony\Component\RemoteEvent\Consumer\ConsumerInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;
use TelegramBot\Api\BotApi;

#[AsRemoteEventConsumer('github')]
final readonly class GithubWebhookConsumer implements ConsumerInterface
{
    public function __construct(
        private BotApi $api,
        private LoggerInterface $logger
    ) {
    }

    public function consume(RemoteEvent $event): void
    {
        $name = $event->getName();

        try {
            match (true) {
                $name === 'push' => $this->handlePushEvent($event),
                $name === 'ping' => $this->handlePingEvent($event),
                default => null,
            };
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function handlePushEvent(RemoteEvent $event): void
    {
        $data = $event->getPayload();
        $project = $data['repository']['full_name'];
        $pusher = $data['pusher']['name'];
        $description = $data['head_commit']['message'];
        $ref = str_replace('refs/heads/', '', $data['ref']);
        $commit = substr(strval($data['after']), 0, 8);

        $message = vsprintf(
            format: $commit === '00000000' ?
                '🔥 %s deleted %s on %s' :
                '🔥 %s pushed %s on %s : %s',
            values: [$pusher, $ref, $project, $description]
        );

        $this->sendMessage($message);
    }

    private function handlePingEvent(RemoteEvent $event): void
    {
        $data = $event->getPayload();
        $message = sprintf('👉 Github ping : %s', $data['zen']);
        $this->sendMessage($message);
    }

    private function sendMessage(?string $message = null): void
    {
        if ($message !== null) {
            $this->api->sendMessage(
                chatId: '@bibliospat',
                text: $message,
                disablePreview: true,
                messageThreadId: 'your topic id if any'
            );
        }
    }
}
