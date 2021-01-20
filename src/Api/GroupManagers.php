<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GroupManagers extends Api
{
    /**
     * Search group managers.
     * https://docs.learnupon.com/api/#group-managers
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/group_managers', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a group manager.
     * https://docs.learnupon.com/api/#create-groupmanager
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'group_id')) {
            return null;
        }

        if (! Arr::has($payload, 'user_id')) {
            return null;
        }

        if (! Arr::has($payload, 'can_create_users')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/group_managers', [
                'body' => json_encode([
                    'GroupManager' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a group manager.
     * https://docs.learnupon.com/api/#delete-a-groupmanager
     *
     * @param  string $groupManagerId
     * @return array|null
     */
    public function delete($groupManagerId)
    {
        return $this->try(function() use ($groupManagerId)
        {
            return $this->client->delete('v1/group_managers/'.$groupManagerId);
        });
    }
}
