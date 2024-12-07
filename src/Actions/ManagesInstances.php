<?php

namespace EvoFone\Actions;

use EvoFone\Resources\Instance;

trait ManagesInstances
{
    /**
     * Create a new instance. API recommends a 2 minute delay between checks.
     *
     * @param  array  $data
     * @return \EvoFone\Resources\Instance
     */
    public function createInstance(array $data) : Instance
    {
        $response = $this->post('/instance/create', $data);

        // Parse the "instance" data from the response
        $instanceData = $response['instance'];
        $instanceData['qrcode'] = $response['qrcode'] ?? null;
        $instanceData['settings'] = $response['settings'] ?? [];
        $instanceData['hash'] = $response['hash'] ?? [];

        return new Instance($instanceData, $this);
    }
}
