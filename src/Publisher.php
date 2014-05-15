<?php

namespace Akamon\ToMockOrNot;

class Publisher
{
    private $serializer;
    private $sender;

    public function __construct(SerializerInterface $serializer, SenderInterface $sender)
    {
        $this->serializer = $serializer;
        $this->sender     = $sender;
    }

    public function send(Message $message)
    {
        $serializedMessage = $this->serializer->serialize($message);

        return $this->sender->send($serializedMessage);
    }
}
