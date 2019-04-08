<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';


    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }


    /**
     * @param $method
     * @param array $params
     * @return \Illuminate\Http\Request
     */
    public function initializeRequest($method, array $params = [])
    {
        return \Illuminate\Http\Request::create($this->baseUrl, $method, $params);
    }
}
