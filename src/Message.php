<?php

namespace Akamon\ToMockOrNot;

class Message
{
    private $body;

    public function __construct($body)
    {
        $this->body = $body;
    }
}
