<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Portals extends Api
{
    /**
     * Search portals.
     * https://docs.learnupon.com/api/#search-for-a-portal
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/portals', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a portal.
     * https://docs.learnupon.com/api/#create-a-new-portal
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'subdomain')) {
            return null;
        }

        if (! Arr::has($payload, 'title')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/portals', [
                'body' => json_encode([
                    'Portal' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Update a portal.
     * https://docs.learnupon.com/api/#update-a-portal
     *
     * @param  string  $portalId
     * @param  array  $payload
     * @return array|null
     */
    public function update($portalId, $payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        return $this->try(function() use ($portalId, $payload)
        {
            return $this->client->put('v1/portals/'.$portalId, [
                'body' => json_encode([
                    'Portal' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a portal.
     * https://docs.learnupon.com/api/#delete-a-portal
     *
     * @param  string $portalId
     * @return array|null
     */
    public function delete($portalId)
    {
        return $this->try(function() use ($portalId)
        {
            return $this->client->delete('v1/portals/'.$portalId);
        });
    }

    /**
     * Generate keys for a portal.
     * https://docs.learnupon.com/api/#generate-keys
     *
     * @param  string  $portalId
     * @return array|null
     */
    public function generateKeys($portalId)
    {
        return $this->try(function() use ($portalId)
        {
            return $this->client->post('v1/portals/'.$portalId.'/generate_keys');
        });
    }
}
