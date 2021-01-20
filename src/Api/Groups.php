<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Groups extends Api
{
    /**
     * Search groups.
     * https://docs.learnupon.com/api/#search-for-groups
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/groups', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a group.
     * https://docs.learnupon.com/api/#create-a-new-group
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'title')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/groups', [
                'body' => json_encode([
                    'Group' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Update a group.
     * https://docs.learnupon.com/api/#update-a-group
     *
     * @param  string $groupId
     * @param  array  $payload
     * @return array|null
     */
    public function update($groupId, $payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'title') && ! Arr::has($payload, 'description')) {
            return null;
        }

        return $this->try(function() use ($groupId, $payload)
        {
            return $this->client->put('v1/groups/'.$groupId, [
                'body' => json_encode([
                    'Group' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a group.
     * https://docs.learnupon.com/api/#delete-a-group
     *
     * @param  string $groupId
     * @return array|null
     */
    public function delete($groupId)
    {
        return $this->try(function() use ($groupId)
        {
            return $this->client->delete('v1/groups/'.$groupId);
        });
    }
}
