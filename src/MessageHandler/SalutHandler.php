<?php

namespace App\MessageHandler;

use App\Message\Salut;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SalutHandler{
    public function __invoke(Salut $message): void
    {
        // do something with your message
    }
}
