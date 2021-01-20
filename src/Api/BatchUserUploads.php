<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class BatchUserUploads extends Api
{
    /**
     * Upload a CSV via an SFTP server.
     * https://docs.learnupon.com/api/#batch-user-upload
     *
     * @param  array  $payload
     * @return array|null
     */
    public function upload($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'user_id')) {
            return null;
        }

        if (! Arr::has($payload, 'sftp_username')) {
            return null;
        }

        if (! Arr::has($payload, 'sftp_password')) {
            return null;
        }

        if (! Arr::has($payload, 'file_url')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/batch/upload', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Upload and sync a CSV via an SFTP server.
     * https://docs.learnupon.com/api/#batch-user-upload-and-sync
     *
     * @param  array  $payload
     * @return array|null
     */
    public function uploadAndSync($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'user_id')) {
            return null;
        }

        if (! Arr::has($payload, 'sftp_username')) {
            return null;
        }

        if (! Arr::has($payload, 'sftp_password')) {
            return null;
        }

        if (! Arr::has($payload, 'file_url')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/batch/upload_and_sync', [
                'body' => json_encode($payload),
            ]);
        });
    }
}
