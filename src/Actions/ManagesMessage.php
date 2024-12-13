<?php

namespace EvoFone\Actions;

use EvoFone\Exceptions\InvalidWhatsAppNumberException;
use EvoFone\Resources\TextMessage;

trait ManagesMessage
{
    /**
     * Send a text message if the number is a valid WhatsApp contact.
     *
     * @param array $data
     * @return TextMessage
     * @throws \InvalidArgumentException
     * @throws InvalidWhatsAppNumberException
     */
    public function sendTextMessage(array $data): TextMessage
    {
        // Ensure instanceName and number are passed
        if (empty($data['instanceName'])) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        if (empty($data['number'])) {
            throw new \InvalidArgumentException('The "number" field is required.');
        }

        if (empty($data['text'])) {
            throw new \InvalidArgumentException('The "text" field is required.');
        }

        $instanceName = $data['instanceName'];
        $number = $data['number'];

        // Check if the number exists on WhatsApp
        $contactStatuses = $this->getContactStatuses($instanceName, [$number]);
        if (empty($contactStatuses) || !$contactStatuses[0]->exists) {
            throw new InvalidWhatsAppNumberException(["The number {$number} is not a valid WhatsApp contact."]);
        }

        // Prepare the endpoint and payload for sending the message
        $endpoint = "/message/sendText/{$instanceName}";
        $payload = [
            'number' => $number,
            'textMessage' => [
                'text' => $data['text'],
            ],
        ];

        // Send the request
        $response = $this->post($endpoint, ['json' => $payload]);

        // Parse the response into a TextMessage object
        return new TextMessage($response, $this);
    }
}
