<?php

namespace App;

class ApiResponse
{
    private $body;
    private $status = 200;

    public function __construct($body, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function body()
    {
        return $this->body;
    }

    public function status()
    {
        return $this->status;
    }

    public function hasError()
    {
        $status = intval($this->status);
        return $status < 200 || $status >= 300;
    }

    static public function error(string $message = 'Error', int $status = 500, array $errors = []) : self
    {
        return new self([
            'code' => $status,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
