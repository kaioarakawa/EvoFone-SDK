<?php

namespace EvoFone\Resources;

use EvoFone\FoneEvo;

class TextMessage extends Resource
{
    /**
     * The unique key of the message.
     *
     * @var array
     */
    public $key;

    /**
     * The actual message content.
     *
     * @var array
     */
    public $message;

    /**
     * The timestamp of the message.
     *
     * @var string
     */
    public $messageTimestamp;

    /**
     * The status of the message.
     *
     * @var string
     */
    public $status;

    /**
     * Create a new Message resource.
     *
     * @param array $attributes
     * @param FoneEvo $foneEvo
     */
    public function __construct(array $attributes, FoneEvo $foneEvo)
    {
        parent::__construct($attributes, $foneEvo);

        $this->key = $attributes['key'] ?? [];
        $this->message = $attributes['message'] ?? [];
        $this->messageTimestamp = $attributes['messageTimestamp'] ?? '';
        $this->status = $attributes['status'] ?? 'PENDING';
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'message' => $this->message,
            'messageTimestamp' => $this->messageTimestamp,
            'status' => $this->status,
        ];
    }
}
