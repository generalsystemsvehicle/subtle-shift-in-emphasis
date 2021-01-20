<?php

namespace GeneralSystemsVehicle\LearnUpon\Guzzle;

use GeneralSystemsVehicle\LearnUpon\Events\RequestExceptionWasThrown;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Backoff;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $options;

    /**
     * Initialize the instance.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
        $this->connect(Config::get('learnupon.default_portal'));
    }

    /**
     * Setup connection to a LearnUpon portal.
     *
     * @param  string $connection
     * @return void
     */
    public function connect($connection)
    {
        $stack = HandlerStack::create(Arr::get($this->options, 'mock'));

        $middlewares = Arr::get($this->options, 'middleware', [
            Middleware::retry(Backoff::decider(), Backoff::delay()),
        ]);

        foreach($middlewares as $middleware) {
            $stack->push($middleware);
        }

        // https://docs.learnupon.com/api/#get-started
        $this->client = new Client([
            'base_uri' => Config::get('learnupon.portals.'.$connection.'.base_uri'),
            'handler' => $stack,
            'auth' => [
                Config::get('learnupon.portals.'.$connection.'.username'),
                Config::get('learnupon.portals.'.$connection.'.password'),
            ],
            'headers' => [
                'User-Agent' => 'generalsystemsvehicle/subtle-shift-in-emphasis',
                'Content-Type' => 'application/json; charset=UTF-8',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Try a Guzzle request.
     * @param  callable $response
     * @return array|null
     */
    protected function try(callable $response)
    {
        try {
            return $this->handleReponse($response());
        } catch (RequestException $exception) {
            return $this->handleBadResponse($exception);
        }
    }

    /**
     * Handles a response from the Guzzle client.
     *
     * @param  ResponseInterface $response
     * @return array|null
     */
    protected function handleReponse(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();

        $isXml = false;
        if ($response->hasHeader('Content-Type')) {
            $isXml = strstr($response->getHeader('Content-Type')[0], 'application/xml');
        }

        if ($body && $isXml) {
            $xml = new SimpleXMLElement($body);
            $body = json_encode($xml);
        }

        $body = json_decode($body ?: '', true);

        if ($response->hasHeader('LU-Current-Page')) {
            Arr::set($body, 'metadata.current_page', $response->getHeader('LU-Current-Page')[0]);
        }

        if ($response->hasHeader('LU-Records-Per-Page')) {
            Arr::set($body, 'metadata.per_page', $response->getHeader('LU-Records-Per-Page')[0]);
        }

        if ($response->hasHeader('LU-Has-Next-Page')) {
            Arr::set($body, 'metadata.has_next_page', $response->getHeader('LU-Has-Next-Page')[0]);
        }

        return $body;
    }

    /**
     * Handles an exception from the Guzzle client.
     *
     * @param  RequestException $exception
     * @return null
     */
    protected function handleBadResponse(RequestException $exception)
    {
        $response = $exception->getResponse();

        // 404 Not Found
        if ($response && $response->getStatusCode() == 404) {
            return null;
        }

        // 422 Unprocessable Entity
        if ($response && $response->getStatusCode() == 422) {
            return null;
        }

        Event::dispatch(new RequestExceptionWasThrown($exception));

        throw $exception;
    }
}
