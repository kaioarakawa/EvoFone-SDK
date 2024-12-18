<?php

namespace EvoFone\Actions;

use EvoFone\Resources\Group;

trait ManagesGroups
{
    /**
     * Create a new instance. API recommends a 2 minute delay between checks.
     *
     * @param string $instanceName
     * @param bool $getParticipants
     * @return array
     */
    public function getAllGroups(string $instanceName, bool $getParticipants) : array
    {
        if (empty($instanceName)) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        $endpoint = "/group/fetchAllGroups/{$instanceName}?getParticipants={$getParticipants}";

        // Make the POST request
        $response = $this->get($endpoint);

        // Parse the response and create a list of ContactStatus objects
        $groups = [];
        foreach ($response as $groupData) {
            $groups[] = new Group($groupData, $this);
        }

        return $groups;
    }

    public function updateSetting(array $data) : bool
    {
        // Ensure instanceName and number are passed
        if (empty($data['instanceName'])) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        if (empty($data['groupJid'])) {
            throw new \InvalidArgumentException('The "number" field is required.');
        }

        if (empty($data['action'])) {
            throw new \InvalidArgumentException('The "text" field is required.');
        }

        $payload = [
            'action' => $data['action'],
        ];

        $endpoint = "/group/updateSetting/{$data['instanceName']}?groupJid={$data['groupJid']}";

        // Make the POST request
        $response = $this->put($endpoint, $payload);

        dd($response);

        return true;
    }
}
