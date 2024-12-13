<?php

namespace EvoFone\Resources;

use EvoFone\FoneEvo;

class CheckWP extends Resource
{
    /**
     * Whether the contact exists.
     *
     * @var bool
     */
    public $exists;

    /**
     * The WhatsApp JID of the contact.
     *
     * @var string
     */
    public $jid;

    /**
     * The phone number of the contact.
     *
     * @var string
     */
    public $number;

    /**
     * Create a new ContactStatus resource.
     *
     * @param array $attributes
     * @param FoneEvo $foneEvo
     */
    public function __construct(array $attributes, FoneEvo $foneEvo)
    {
        parent::__construct($attributes, $foneEvo);

        $this->exists = $attributes['exists'] ?? false;
        $this->jid = $attributes['jid'] ?? '';
        $this->number = $attributes['number'] ?? '';
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'exists' => $this->exists,
            'jid' => $this->jid,
            'number' => $this->number,
        ];
    }
}
