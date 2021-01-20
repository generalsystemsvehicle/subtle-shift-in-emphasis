<?php

namespace GeneralSystemsVehicle\LearnUpon\Events;

use GuzzleHttp\Exception\RequestException;

class RequestExceptionWasThrown
{
    /**
     * @var RequestException
     */
    public $exception;

    /**
     * Initialize the instance.
     *
     * @param  \GuzzleHttp\Exception\RequestException  $exception
     * @return void
     */
    public function __construct(RequestException $exception)
    {
        $this->exception = $exception;
    }
}
