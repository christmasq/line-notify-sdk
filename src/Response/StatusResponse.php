<?php

namespace LINENotify\Response;

class StatusResponse extends ApiResponse
{
    public $targetType;
    public $target;

    /**
     * @param string $body_str
     * @return ApiResponse|StatusResponse
     */
    public static function init(?string $body_str = '')
    {
        $status = parent::init($body_str);
        $status->setTarget();

        return $status;
    }

    /**
     * @return StatusResponse
     */
    public function setTarget(): StatusResponse
    {
        if (isset($this->response->target)) {
            $this->targetType = $this->response->targetType;
            $this->target = $this->response->target;
        }

        return $this;
    }
}