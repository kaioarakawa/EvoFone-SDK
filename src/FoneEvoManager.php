<?php

namespace EvoFone;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin \EvoFone\FoneEvo
 */
class FoneEvoManager
{
    use ForwardsCalls;

    /**
     * The FoneEvo instance.
     *
     * @var \EvoFone\FoneEvo
     */
    protected $foneEvo;

    /**
     * Create a new FoneEvo manager instance.
     *
     * @param  string  $token
     */
    public function __construct($token, ?HttpClient $guzzle = null)
    {
        $this->foneEvo = new FoneEvo($token, $guzzle);
    }

    /**
     * Dynamically pass methods to the FoneEvo instance.
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->forwardCallTo($this->foneEvo, $method, $parameters);
    }
}
