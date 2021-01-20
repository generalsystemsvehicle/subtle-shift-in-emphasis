<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Enrollments extends Api
{
    /**
     * Search for enrollments.
     * https://docs.learnupon.com/api/#enrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search for enrollments.
     * https://docs.learnupon.com/api/#enrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'user_id') &&
            ! Arr::has($payload, 'email') &&
            ! Arr::has($payload, 'username') &&
            ! Arr::has($payload, 'course_id') &&
            ! Arr::has($payload, 'course_name')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/enrollments/search', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get an enrollment.
     * https://docs.learnupon.com/api/#enrollments
     *
     * @param  string $enrollmentId
     * @return array|null
     */
    public function get($enrollmentId)
    {
        return $this->try(function() use ($enrollmentId)
        {
            return $this->client->get('v1/enrollments/'.$enrollmentId);
        });
    }

    /**
     * Create an enrollment.
     * https://docs.learnupon.com/api/#create-an-enrollment-enroll-users-on-a-course
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

        if (! Arr::has($payload, 'course_name') && ! Arr::has($payload, 'course_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/enrollments', [
                'body' => json_encode([
                    'Enrollment' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete an enrollment.
     * https://docs.learnupon.com/api/#delete-enrollment
     *
     * @param  string $enrollmentId
     * @param  array $payload
     * @return array|null
     */
    public function delete($enrollmentId, $payload = [])
    {
        return $this->try(function() use ($enrollmentId, $payload)
        {
            return $this->client->delete('v1/enrollments/'.$enrollmentId, [
                'body' => json_encode($payload),
            ]);
        });
    }
}
