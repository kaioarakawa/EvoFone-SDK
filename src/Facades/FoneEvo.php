<?php

namespace EvoFone\Facades;

use EvoFone\FoneEvoManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \EvoFone\FoneEvo setApiKey(string $apiKey, \GuzzleHttp\Client|null $guzzle = null)
 * @method static \EvoFone\FoneEvo setTimeout(int $timeout)
 * @method static int getTimeout()
 * @method static \EvoFone\Resources\Instance createInstance(string $instanceName, string $number, string $webhook)
 * @method static bool deleteInstance(string $instanceName)
 * @method static \EvoFone\Resources\CheckWP[] getContactStatuses(string $instanceName, array $numbers)
 * @method static \EvoFone\Resources\TextMessage sendTextMessage(string $instanceName, string $number, string $text)
 * @method static \EvoFone\Resources\Group[] getAllGroups(string $instanceName, bool $getParticipants)
 * @method static void updateSetting(string $instanceName, string $groupJid, string $action)
 * @see \EvoFone\FoneEvo
 */
class FoneEvo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return FoneEvoManager::class;
    }
}
