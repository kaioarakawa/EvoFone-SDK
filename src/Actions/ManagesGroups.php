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
}
