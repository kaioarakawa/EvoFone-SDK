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

        $endpoint = "/group/fetchAllGroups/{$instanceName}?getParticipants=" . var_export($getParticipants, true);

        // Make the POST request
        $response = $this->get($endpoint);

        // Parse the response and create a list of ContactStatus objects
        $groups = [];
        foreach ($response as $groupData) {
            $groups[] = new Group($groupData, $this);
        }

        return $groups;
    }

    public function updateSetting(string $instanceName, string $groupJid, string $action) : void
    {
        // Ensure instanceName and number are passed
        if (empty($instanceName)) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        if (empty($groupJid)) {
            throw new \InvalidArgumentException('The "groupJid" field is required.');
        }

        if (empty($action)) {
            throw new \InvalidArgumentException('The "action" field is required.');
        }

        $payload = [
            'action' => $action,
        ];

        $endpoint = "/group/updateSetting/{$instanceName}?groupJid={$groupJid}";

        // Make the POST request
        $this->post($endpoint, $payload);
    }
}
