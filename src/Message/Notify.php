<?php


namespace LINENotify\Message;


use LINENotify\Api;

/**
 * Class Notify
 * @package LINENotify
 */
class Notify
{
    /**
     * @param string $access_token
     * @param string $message
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $access_token, string $message): bool
    {
        return $api = Api::create($access_token)->notify($this->getParams($message));
    }

    /**
     * get params by message
     * @param string $message
     * @return array
     */
    protected function getParams(string $message): array
    {
        // default text message
        return ['message' => $message];
    }
}