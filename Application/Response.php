<?php

namespace Application;

class Response
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
