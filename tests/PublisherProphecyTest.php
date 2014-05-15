<?php

namespace Akamon\ToMockOrNot\Test;

use Akamon\ToMockOrNot\Message;
use Akamon\ToMockOrNot\Publisher;
use Akamon\ToMockOrNot\SenderInterface;
use Akamon\ToMockOrNot\SerializerInterface;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophet;

class PublisherProphecyTest extends PHPUnit_Framework_TestCase
{
    /** @var Prophet */
    private $prophet;

    protected function setup()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    /** @test */
    public function it_should_publish_a_message()
    {
        $body              = 'my message';
        $message           = new Message($body);
        $serializedMessage = ['body' => $body];

        $serializer = $this->prophet->prophesize(SerializerInterface::class);
        $serializer
            ->serialize($message)
            ->shouldBeCalled()
            ->willReturn($serializedMessage);

        $sender = $this->prophet->prophesize(SenderInterface::class);
        $sender
            ->send($serializedMessage)
            ->shouldBeCalled()
            ->willReturn(true);

        $publisher = new Publisher($serializer->reveal(), $sender->reveal());
        $this->assertTrue($publisher->send($message));
    }
}
