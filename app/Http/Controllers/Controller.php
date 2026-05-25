<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function internalApiRequest(string $method, string $uri, array $data = [])
    {
        $request = \Illuminate\Http\Request::create($uri, $method, $data);
        $request->headers->set('Accept', 'application/json');
        
        $response = \Illuminate\Support\Facades\Route::dispatch($request);
        
        $status = $response->getStatusCode();
        $content = json_decode($response->getContent(), true) ?? [];
        
        return new class($status, $content) {
            private $status;
            private $content;
            public function __construct($status, $content) { $this->status = $status; $this->content = $content; }
            public function successful() { return $this->status >= 200 && $this->status < 300; }
            public function json($key = null, $default = null) {
                if ($key === null) return $this->content;
                return data_get($this->content, $key, $default);
            }
        };
    }
}
