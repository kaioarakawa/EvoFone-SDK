<?php

namespace EvoFone\Actions;

use EvoFone\Resources\CheckWP;

trait ManagesChat
{
    /**
     * Get contact statuses for a list of numbers.
     *
     * @param string $instanceName
     * @param array $numbers
     * @return array<CheckWP>
     */
    public function getContactStatuses(string $instanceName, array $numbers): array
    {
        if (empty($instanceName)) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        if (empty($numbers)) {
            throw new \InvalidArgumentException('The "numbers" field cannot be empty.');
        }

        $endpoint = "/chat/whatsappNumbers/{$instanceName}";

        // Prepare the payload
        $payload = [
            'numbers' => $numbers,
        ];

        // Make the POST request
        $response = $this->post($endpoint, ['json' => $payload]);

        // Parse the response and create a list of ContactStatus objects
        $contactStatuses = [];
        foreach ($response as $contactData) {
            $contactStatuses[] = new CheckWP($contactData, $this);
        }

        return $contactStatuses;
    }
}
