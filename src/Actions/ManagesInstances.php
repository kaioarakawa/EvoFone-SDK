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
    public function createInstance(string $instanceName, string $number, string $webhook) : Instance
    {
        $instanceRequest = [
            'instanceName'  => $instanceName,
            'number'        => $number, // Opcional
            'qrcode'        => true, // Opcional
            'integration'   => 'WHATSAPP-BAILEYS',
            'groupsIgnore'  => false,
            'webhook' => [
                'url'    => $webhook,
                'events' => [
                    'MESSAGES_UPSERT',
                ]
            ],
        ];

        $response = $this->post('/instance/create', ['json' => $instanceRequest]);

        // Parse the "instance" data from the response
        $instanceData = $response['instance'];
        $instanceData['qrcode'] = $response['qrcode'] ?? null;
        $instanceData['settings'] = $response['settings'] ?? [];
        $instanceData['hash'] = $response['hash'] ?? [];

        return new Instance($instanceData, $this);
    }

    public function deleteInstance(string $instanceName) : bool
    {
        if (empty($instanceName)) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        $response = $this->delete('/instance/delete/' . $instanceName);

        if($response['status'] != 'SUCCESS') {
            return true;
        }

        return false;
    }
}
