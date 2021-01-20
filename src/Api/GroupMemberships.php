<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GroupMemberships extends Api
{
    /**
     * Search group memberships.
     * https://docs.learnupon.com/api/#search-for-groupmemberships-by-group-or-by-user
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'group_id') &&
            ! Arr::has($payload, 'user_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/group_memberships', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a group membership.
     * https://docs.learnupon.com/api/#create-a-groupmembership
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

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/group_memberships', [
                'body' => json_encode([
                    'GroupMembership' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a group membership.
     * https://docs.learnupon.com/api/#delete-a-groupmembership
     *
     * @param  string $groupMembershipId
     * @param  array  $payload
     * @return array|null
     */
    public function delete($groupMembershipId, $payload = [])
    {
        if ($groupMembershipId == 0 && ! Arr::has($payload, 'group_id')) {
            return null;
        }

        if ($groupMembershipId == 0 && ! Arr::has($payload, 'user_id')) {
            return null;
        }

        return $this->try(function() use ($groupMembershipId, $payload)
        {
            return $this->client->delete('v1/group_memberships/'.$groupMembershipId, [
                'body' => json_encode([
                    'GroupMembership' => $payload,
                ]),
            ]);
        });
    }
}
