<?php


namespace LINENotify\Response;


class ApiResponse
{
    /**
     * @var object body response object
     */
    protected $response;

    public $status;
    public $message;

    /**
     * @param string $body_str
     * @return ApiResponse
     */
    public static function init(?string $body_str)
    {
        $base_response = new static();

        // set property by body string
        if (!empty($body_str)) {
            $base_response->setBaseProperty($body_str);
        }

        return $base_response;
    }

    /**
     * @param string $body_str
     * @return ApiResponse
     */
    protected function setBaseProperty(string $body_str): ApiResponse
    {
        // set body response by json string
        $this->response = json_decode($body_str);

        // set property
        $this->setStatus($this->response->status);
        $this->setMessage($this->response->message);

        return $this;
    }

    /**
     * @param int $status
     * @return ApiResponse
     */
    public function setStatus(int $status): ApiResponse
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setMessage(string $message): ApiResponse
    {
        $this->message = $message;
        return $this;
    }
}