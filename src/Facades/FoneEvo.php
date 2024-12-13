<?php

namespace EvoFone\Facades;

use EvoFone\FoneEvoManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \EvoFone\FoneEvo setApiKey(string $apiKey, \GuzzleHttp\Client|null $guzzle = null)
 * @method static \EvoFone\FoneEvo setTimeout(int $timeout)
 * @method static int getTimeout()
 * @method static \EvoFone\Resources\Instance createInstance(array $data)
 * @method static \EvoFone\Resources\CheckWP[] getContactStatuses(string $instanceName, array $numbers)
 * @method static \EvoFone\Resources\TextMessage sendTextMessage(array $data)
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
