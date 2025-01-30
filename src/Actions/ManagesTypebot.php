<?php

namespace EvoFone\Actions;

use EvoFone\Exceptions\InvalidWhatsAppNumberException;
use EvoFone\Resources\TextMessage;

trait ManagesTypebot
{
    /**
     * Send a text message if the number is a valid WhatsApp contact.
     *
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws InvalidWhatsAppNumberException
     */
    public function setSettings(string $instanceName): bool
    {
        // Ensure instanceName and number are passed
        if (empty($instanceName)) {
            throw new \InvalidArgumentException('The "instanceName" field is required.');
        }

        // Prepare the endpoint and payload for sending the message
        $endpoint = "/typebot/settings/{$instanceName}";
        $payload = [
            "expire" => 20,
            "keywordFinish" => "#SAIR",
            "delayMessage" => 1000,
            "unknownMessage" => "Mensagem não reconhecida",
            "listeningFromMe" => false,
            "stopBotFromMe" => false,
            "keepOpen" => false,
            "debounceTime" => 10,
            "ignoreJids" => []
        ];

        // Send the request
        $response = $this->post($endpoint, ['json' => $payload]);

        // Parse the response into a TextMessage object
        return true;
    }


    public function startFlow(string $instanceName, string $url, string $typebot, string $jid, array $variables = []): bool
    {
        // Prepare the endpoint and payload for sending the message
        $endpoint = "/typebot/start/{$instanceName}";

        // Add the default "jid" variable
        $defaultVariable = [
            "name" => "jid",
            "value" => $jid
        ];

        // Combine default variables with custom variables
        $allVariables = array_merge([$defaultVariable], $variables);
        $payload = [
            "url" => $url,
            "typebot" => $typebot,
            "remoteJid" => $jid,
            "startSession" => true,
            "variables" => $allVariables
        ];

        // Send the request
        $response = $this->post($endpoint, ['json' => $payload]);

        return true;
    }
}
