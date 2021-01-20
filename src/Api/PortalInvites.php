<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class PortalInvites extends Api
{
    /**
     * Send a portal invite.
     * https://docs.learnupon.com/api/#portal-invites
     *
     * @param  array  $payload
     * @return array|null
     */
    public function send($payload = [])
    {
        return $this->create($payload);
    }

    /**
     * Create a portal invite.
     * https://docs.learnupon.com/api/#portal-invites
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'email')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/portal_invite', [
                'body' => json_encode([
                    'Invite' => $payload,
                ]),
            ]);
        });
    }
}
