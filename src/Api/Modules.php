<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Modules extends Api
{
    /**
     * Search for modules.
     * https://docs.learnupon.com/api/#modules
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search for modules.
     * https://docs.learnupon.com/api/#modules
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/modules', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a video or audio module.
     * https://docs.learnupon.com/api/#add-a-video-or-audio-module
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'module_title')) {
            return null;
        }

        if (! Arr::has($payload, 'video_url') && ! Arr::has($payload, 'audio_url')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/modules', [
                'body' => json_encode($payload),
            ]);
        });
    }
}
