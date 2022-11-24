<?php

namespace App\Model\Services;

use App\Model\Repository\MessageRepository;

class MessageService
{
    protected MessageRepository $messageRepository;

    public function __construct()
    {
        $messageRepository = new MessageRepository();
        $this->messageRepository = $messageRepository;
    }

    public function saveMessage($messageData): void
    {
        $this->messageRepository->create($messageData);
    }

    public function getAllMessages(): array
    {
        return $this->messageRepository->getAll();
    }
}