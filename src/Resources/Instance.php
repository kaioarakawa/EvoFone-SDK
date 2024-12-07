<?php

namespace EvoFone\Resources;

use EvoFone\FoneEvo;

class Instance extends Resource
{
    /**
     * The ID of the instance.
     *
     * @var string
     */
    public $instanceId;

    /**
     * The name of the instance.
     *
     * @var string
     */
    public $instanceName;

    /**
     * The integration type of the instance.
     *
     * @var string
     */
    public $integration;

    /**
     * The webhook for WhatsApp Business.
     *
     * @var string|null
     */
    public $webhookWaBusiness;

    /**
     * The access token for WhatsApp Business.
     *
     * @var string
     */
    public $accessTokenWaBusiness;

    /**
     * The status of the instance.
     *
     * @var string
     */
    public $status;

    /**
     * The pairing code and QR code information.
     *
     * @var array|null
     */
    public $qrcode;

    /**
     * Instance settings.
     *
     * @var array
     */
    public $settings;

    /**
     * The hash information for the instance.
     *
     * @var array
     */
    public $hash;

    /**
     * Create a new Instance resource.
     *
     * @param  array  $attributes
     * @param  FoneEvo  $foneEvo
     */
    public function __construct(array $attributes, FoneEvo $foneEvo)
    {
        parent::__construct($attributes, $foneEvo);

        $this->instanceId = $attributes['instanceId'];
        $this->instanceName = $attributes['instanceName'];
        $this->integration = $attributes['integration'];
        $this->webhookWaBusiness = $attributes['webhook_wa_business'] ?? null;
        $this->accessTokenWaBusiness = $attributes['access_token_wa_business'] ?? '';
        $this->status = $attributes['status'];
        $this->qrcode = $attributes['qrcode'] ?? null;
        $this->settings = $attributes['settings'] ?? [];
        $this->hash = $attributes['hash'] ?? [];
    }

}
