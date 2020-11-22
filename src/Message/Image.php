<?php


namespace LINENotify\Message;


/**
 * Class Image
 * @package LINENotify\Message
 */
class Image extends Notify
{
    /**
     * @var string
     */
    public $image_url;
    /**
     * @var string
     */
    public $image_thumb_nail_url;

    /**
     * Create image notify object
     * @param string $image_url
     * @param string|null $image_thumb_nail_url
     */
    public function __construct(string $image_url, ?string $image_thumb_nail_url = null)
    {
        $this->image_url = $image_url;
        $this->image_thumb_nail_url = (is_null($image_thumb_nail_url)) ? $image_url : $image_thumb_nail_url;
    }

    /**
     * Get params by message and parameter
     * @param string $message
     * @return array
     */
    protected function getParams(string $message): array
    {
        return [
            'message' => $message,
            'imageThumbnail' => $this->image_thumb_nail_url,
            'imageFullsize' => $this->image_url,
        ];
    }
}