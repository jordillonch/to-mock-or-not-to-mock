<?php

namespace Akamon\ToMockOrNot;

interface SerializerInterface
{
    public function serialize(Message $message);
}
