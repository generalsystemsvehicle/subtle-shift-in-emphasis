<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Users extends Api
{
    /**
     * Get all users.
     * https://docs.learnupon.com/api/#users
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/users', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Search for users.
     * https://docs.learnupon.com/api/#users
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'email') && ! Arr::has($payload, 'username')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/users/search', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get all instructor users.
     * https://docs.learnupon.com/api/#users
     *
     * @param  array $payload
     * @return array|null
     */
    public function instructors($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/users/instructor_users', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get all custom user data fields for users.
     * https://docs.learnupon.com/api/#users
     *
     * @param  array $payload
     * @return array|null
     */
    public function customUserData($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/users/customuserdata', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get a user.
     * https://docs.learnupon.com/api/#users
     *
     * @param  string $userId
     * @return array|null
     */
    public function get($userId)
    {
        return $this->try(function() use ($userId)
        {
            return $this->client->get('v1/users/'.$userId);
        });
    }

    /**
     * Create a user.
     * https://docs.learnupon.com/api/#create-a-user
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'email') && ! Arr::has($payload, 'username')) {
            return null;
        }

        if (! Arr::has($payload, 'password')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/users', [
                'body' => json_encode([
                    'User' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Update a user.
     * https://docs.learnupon.com/api/#update-a-user
     *
     * @param  string $userId
     * @param  array  $payload
     * @return array|null
     */
    public function update($userId, $payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'email') && ! Arr::has($payload, 'username')) {
            return null;
        }

        return $this->try(function() use ($userId, $payload)
        {
            return $this->client->post('v1/users/'.$userId, [
                'body' => json_encode([
                    'User' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a user.
     * https://docs.learnupon.com/api/#delete-a-user
     *
     * @param  string $userId
     * @return array|null
     */
    public function delete($userId)
    {
        return $this->try(function() use ($userId)
        {
            return $this->client->delete('v1/users/'.$userId);
        });
    }
}
