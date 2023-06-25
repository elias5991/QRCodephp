<?php

class SuccessResponse
{
    public $success;

    public function __construct($success)
    {
        $this->success = $success;
    }
}