<?php

class ErrorResponse
{
    public $error;

    public function __construct($error)
    {
        $this->error = $error;
    }
}
