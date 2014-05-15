<?php

namespace Akamon\ToMockOrNot\Test;

use Akamon\ToMockOrNot\Message;
use Akamon\ToMockOrNot\Publisher;
use Akamon\ToMockOrNot\SenderInterface;
use Akamon\ToMockOrNot\SerializerInterface;
use Mockery;
use PHPUnit_Framework_TestCase;

class PublisherMockeryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_publish_a_message()
    {
        $body              = 'my message';
        $message           = new Message($body);
        $serializedMessage = ['body' => $body];

        $serializer = Mockery::mock(SerializerInterface::class);
        $serializer
            ->shouldReceive('serialize')
            ->with(Mockery::mustBe($message))
            ->once()
            ->andReturn($serializedMessage);

        $sender = Mockery::mock(SenderInterface::class);
        $sender
            ->shouldReceive('send')
            ->with($serializedMessage)
            ->once()
            ->andReturn(true);

        $publisher = new Publisher($serializer, $sender);
        $this->assertTrue($publisher->send($message));
    }
}
