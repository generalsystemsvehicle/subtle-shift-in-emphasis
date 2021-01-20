<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class MarkCompletes extends Api
{
    /**
     * Get all mark completes.
     * https://docs.learnupon.com/api/#search-for-markcomplete-enrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/markcompletes', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a mark complete.
     * https://docs.learnupon.com/api/#mark-enrollments-complete
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'enrollment_id')) {
            return null;
        }

        if (! Arr::has($payload, 'date_completed')) {
            return null;
        }

        if (! Arr::has($payload, 'status')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/markcompletes', [
                'body' => json_encode([
                    'Markcomplete' => $payload,
                ]),
            ]);
        });
    }
}
