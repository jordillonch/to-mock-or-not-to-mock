<?php

namespace Akamon\ToMockOrNot\Test;

use Akamon\ToMockOrNot\Message;
use Akamon\ToMockOrNot\Publisher;
use Akamon\ToMockOrNot\SenderInterface;
use Akamon\ToMockOrNot\SerializerInterface;
use PHPUnit_Framework_TestCase;

class PublisherTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_publish_a_message()
    {
        $body              = 'my message';
        $message           = new Message($body);
        $serializedMessage = ['body' => $body];

        $serializer = $this->getMock(SerializerInterface::class, ['serialize']);
        $serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($this->identicalTo($message))
            ->will($this->returnValue($serializedMessage));

        $sender = $this->getMock(SenderInterface::class, ['send']);
        $sender
            ->expects($this->once())
            ->method('send')
            ->with($this->equalTo($serializedMessage))
            ->will($this->returnValue(true));

        $publisher = new Publisher($serializer, $sender);
        $this->assertTrue($publisher->send($message));
    }
}
