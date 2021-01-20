<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GamificationBadges extends Api
{
    /**
     * Search gamification badges.
     * https://docs.learnupon.com/api/#gamification
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/badges', [
                'query' => $payload,
            ]);
        });
    }
}
