<?php

namespace EvoFone;

use EvoFone\Exceptions\FailedActionException;
use EvoFone\Exceptions\ForbiddenException;
use EvoFone\Exceptions\NotFoundException;
use EvoFone\Exceptions\RateLimitExceededException;
use EvoFone\Exceptions\TimeoutException;
use EvoFone\Exceptions\ValidationException;
use Exception;
use Psr\Http\Message\ResponseInterface;

trait MakesHttpRequests
{
    /**
     * Make a GET request to FoneEvo servers and return the response.
     *
     * @param  string  $uri
     * @return mixed
     */
    public function get($uri)
    {
        return $this->request('GET', $uri);
    }

    /**
     * Make a POST request to FoneEvo servers and return the response.
     *
     * @param  string  $uri
     * @return mixed
     */
    public function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make a PUT request to FoneEvo servers and return the response.
     *
     * @param  string  $uri
     * @return mixed
     */
    public function put($uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * Make a DELETE request to FoneEvo servers and return the response.
     *
     * @param  string  $uri
     * @return mixed
     */
    public function delete($uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * Make request to FoneEvo servers and return the response.
     *
     * @param  string  $verb
     * @param  string  $uri
     * @return mixed
     */
    protected function request($verb, $uri, array $payload = [])
    {
        if (isset($payload['json'])) {
            $payload = ['json' => $payload['json']];
        } else {
            $payload = empty($payload) ? [] : ['form_params' => $payload];
        }

        $response = $this->guzzle->request($verb, $uri, $payload);

        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            return $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Handle the request error.
     *
     * @return void
     *
     * @throws \Exception
     * @throws \EvoFone\Exceptions\FailedActionException
     * @throws \EvoFone\Exceptions\ForbiddenException
     * @throws \EvoFone\Exceptions\NotFoundException
     * @throws \EvoFone\Exceptions\ValidationException
     * @throws \EvoFone\Exceptions\RateLimitExceededException
     */
    protected function handleRequestError(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 422) {
            throw new ValidationException(json_decode((string) $response->getBody(), true));
        }

        if ($response->getStatusCode() === 403) {
            throw new ForbiddenException((string) $response->getBody());
        }

        if ($response->getStatusCode() == 404) {
            throw new NotFoundException;
        }

        if ($response->getStatusCode() == 400) {
            throw new FailedActionException((string) $response->getBody());
        }

        if ($response->getStatusCode() === 429) {
            throw new RateLimitExceededException(
                $response->hasHeader('x-ratelimit-reset')
                    ? (int) $response->getHeader('x-ratelimit-reset')[0]
                    : null
            );
        }

        throw new Exception((string) $response->getBody());
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @param  int  $timeout
     * @param  callable  $callback
     * @param  int  $sleep
     * @return mixed
     *
     * @throws \EvoFone\Exceptions\TimeoutException
     */
    public function retry($timeout, $callback, $sleep = 5)
    {
        $start = time();

        beginning:

        if ($output = $callback()) {
            return $output;
        }

        if (time() - $start < $timeout) {
            sleep($sleep);

            goto beginning;
        }

        if ($output === null || $output === false) {
            $output = [];
        }

        if (! is_array($output)) {
            $output = [$output];
        }

        throw new TimeoutException($output);
    }
}
