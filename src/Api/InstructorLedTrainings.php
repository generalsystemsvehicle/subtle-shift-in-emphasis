<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class InstructorLedTrainings extends Api
{
    /**
     * Search for instructor led trainings.
     * https://docs.learnupon.com/api/#search-for-ilt-session
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search for instructor led trainings.
     * https://docs.learnupon.com/api/#search-for-ilt-session
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/ilts/search', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create an instructor led training.
     * https://docs.learnupon.com/api/#create-an-ilt-session
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        if (! Arr::has($payload, 'component')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/components/ilt', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Get locations.
     * https://docs.learnupon.com/api/#search-for-locations
     *
     * @param  array $payload
     * @return array|null
     */
    public function locations($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/locations', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get timezones.
     * https://docs.learnupon.com/api/#search-for-timezones
     *
     * @return array|null
     */
    public function timezones()
    {
        return $this->try(function()
        {
            return $this->client->get('v1/timezones');
        });
    }

    /**
     * Get webinar connections.
     * https://docs.learnupon.com/api/#search-for-webinar-connections
     *
     * @return array|null
     */
    public function webinarConnections()
    {
        return $this->try(function()
        {
            return $this->client->get('v1/webinar_connections');
        });
    }

    /**
     * Search for webinars.
     * https://docs.learnupon.com/api/#search-for-webinars
     *
     * @param  array $payload
     * @return array|null
     */
    public function webinars($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'webinar_connection_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/webinars', [
                'query' => $payload,
            ]);
        });
    }
}
