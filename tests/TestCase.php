<?php


namespace Tests\LINENotify;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function mockClient($body)
    {
        $response = new Response(200, [], $body);
        \Mockery::namedMock(Client::class, MockClientStub::class)
            ->shouldReceive('request')->andReturn($response);
    }
}

class MockClientStub
{
    public static function request()
    {
    }
}