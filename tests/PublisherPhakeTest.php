<?php

namespace Akamon\ToMockOrNot\Test;

use Akamon\ToMockOrNot\Message;
use Akamon\ToMockOrNot\Publisher;
use Akamon\ToMockOrNot\SenderInterface;
use Akamon\ToMockOrNot\SerializerInterface;
use Phake;
use PHPUnit_Framework_TestCase;

class PublisherPhakeTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_publish_a_message()
    {
        $body              = 'my message';
        $message           = new Message($body);
        $serializedMessage = ['body' => $body];

        $serializer = Phake::mock(SerializerInterface::class);
        Phake::when($serializer)
            ->serialize($message)
            ->thenReturn($serializedMessage);

        $sender = Phake::mock(SenderInterface::class);
        Phake::when($sender)
            ->send($serializedMessage)
            ->thenReturn(true);

        $publisher = new Publisher($serializer, $sender);
        $this->assertTrue($publisher->send($message));
    }
}
