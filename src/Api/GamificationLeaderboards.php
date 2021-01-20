<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GamificationLeaderboards extends Api
{
    /**
     * Search gamification leaderboards.
     * https://docs.learnupon.com/api/#methods-leaderboards
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/leaderboard', [
                'query' => $payload,
            ]);
        });
    }
}
