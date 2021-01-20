<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GroupInvites extends Api
{
    /**
     * Search group invites.
     * https://docs.learnupon.com/api/#search-for-groupinvites
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/group_invites', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get a group invite.
     * https://docs.learnupon.com/api/#search-for-groupinvites
     *
     * @param  string $groupInviteId
     * @return array|null
     */
    public function get($groupInviteId)
    {
        return $this->try(function() use ($groupInviteId)
        {
            return $this->client->get('v1/group_invites/'.$groupInviteId);
        });
    }

    /**
     * Create a group invite.
     * https://docs.learnupon.com/api/#create-a-groupinvite
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'email_addresses')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/group_invites', [
                'body' => json_encode([
                    'GroupInvite' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a group invite.
     * https://docs.learnupon.com/api/#delete-a-groupinvite
     *
     * @param  string $groupInviteId
     * @return array|null
     */
    public function delete($groupInviteId)
    {
        return $this->try(function() use ($groupInviteId)
        {
            return $this->client->delete('v1/group_invites/'.$groupInviteId);
        });
    }
}
