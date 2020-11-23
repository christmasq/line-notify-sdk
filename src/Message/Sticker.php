<?php


namespace LINENotify\Message;


/**
 * Class Sticker
 * @package LINENotify\Message
 */
class Sticker extends Notify
{
    /**
     * @var string
     */
    public $package_id;
    /**
     * @var string
     */
    public $sticker_id;

    /**
     * Create Sticker notify object
     * @param int $package_id
     * @param int $sticker_id
     */
    public function __construct(int $package_id, int $sticker_id)
    {
        $this->package_id = $package_id;
        $this->sticker_id = $sticker_id;
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
            'stickerPackageId' => $this->package_id,
            'stickerId' => $this->sticker_id,
        ];
    }
}