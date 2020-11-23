<?php


namespace LINENotify;


use GuzzleHttp\Client;
use LINENotify\Response\ApiResponse;
use LINENotify\Response\StatusResponse;

/**
 * Class Api
 * @package LINENotify
 */
class Api
{
    const API_URL = 'https://notify-api.line.me';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Api constructor.
     * @param string $access_token
     */
    public function __construct(string $access_token)
    {
        $this->client = new Client([
            'base_uri' => static::API_URL,
            'headers' => ['Authorization' => "Bearer " . $access_token],
        ]);
    }

    /**
     * create class
     * @param string $access_token
     * @return static
     */
    public static function create(string $access_token): Api
    {
        return new static($access_token);
    }

    /**
     * Send notify
     * @param array $params
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function notify(array $params): bool
    {
        $response = $this->client->request('POST', '/api/notify', ['form_params' => $params,]);
        $res = ApiResponse::init($response->getBody());
        if (200 == $res->status) {
            return true;
        } else {
            throw new \Exception($res->message);
        }
    }

    /**
     * Get status of access token
     * @return StatusResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function status(): StatusResponse
    {
        $response = $this->client->request('GET', '/api/status');
        $res = StatusResponse::init($response->getBody());
        if (200 == $res->status) {
            return $res;
        } else {
            throw new \Exception($res->message);
        }
    }

    /**
     * Disabling the access token
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function revoke(): bool
    {
        $response = $this->client->request('POST', '/api/revoke');
        $res = ApiResponse::init($response->getBody());
        if (200 == $res->status) {
            return true;
        } else {
            throw new \Exception($res->message);
        }
    }
}