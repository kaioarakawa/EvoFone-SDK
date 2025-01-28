<?php

namespace EvoFone\Resources;

use EvoFone\FoneEvo;

class Instance extends Resource
{
    /**
     * The name of the instance.
     *
     * @var string
     */
    public $instanceName;

    /**
     * The ID of the instance.
     *
     * @var string
     */
    public $instanceId;

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
     * The hash information for the instance.
     *
     * @var array
     */
    public $hash;

    /**
     * Instance settings.
     *
     * @var array
     */
    public $settings;

    /**
     * Create a new Instance resource.
     *
     * @param  array  $attributes
     * @param  FoneEvo  $foneEvo
     */
    public function __construct(array $attributes, FoneEvo $foneEvo)
    {
        parent::__construct($attributes, $foneEvo);

        $instance = $attributes['instance'] ?? [];

        $this->instanceName = $instance['instanceName'] ?? '';
        $this->instanceId = $instance['instanceId'] ?? '';
        $this->webhookWaBusiness = $instance['webhook_wa_business'] ?? null;
        $this->accessTokenWaBusiness = $instance['access_token_wa_business'] ?? '';
        $this->status = $instance['status'] ?? '';

        $this->hash = $attributes['hash'] ?? [];
        $this->settings = $attributes['settings'] ?? [];
    }
}
