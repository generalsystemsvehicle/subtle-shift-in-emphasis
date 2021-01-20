<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class LearningPaths extends Api
{
    /**
     * Search learning paths.
     * https://docs.learnupon.com/api/#search-for-learning-paths
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/learning_paths', [
                'query' => $payload,
            ]);
        });
    }
}
