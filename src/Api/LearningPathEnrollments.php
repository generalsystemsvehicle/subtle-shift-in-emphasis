<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class LearningPathEnrollments extends Api
{
    /**
     * Search learning path enrollments.
     * https://docs.learnupon.com/api/#search-for-learning-path-enrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search learning path enrollments.
     * https://docs.learnupon.com/api/#search-for-learning-path-enrollments
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
            ! Arr::has($payload, 'lp_name') &&
            ! Arr::has($payload, 'lp_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/learning_path_enrollments/search', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get a learning path enrollment.
     * https://docs.learnupon.com/api/#learning-path-enrollments
     *
     * @param  string $learningPathEnrollmentId
     * @return array|null
     */
    public function get($learningPathEnrollmentId)
    {
        return $this->try(function() use ($learningPathEnrollmentId)
        {
            return $this->client->get('v1/learning_path_enrollments/'.$learningPathEnrollmentId);
        });
    }

    /**
     * Create a learning path enrollment.
     * https://docs.learnupon.com/api/#create-a-learning-path-enrollment
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'user_id') &&
            ! Arr::has($payload, 'email') &&
            ! Arr::has($payload, 'username')) {
            return null;
        }

        if (! Arr::has($payload, 'lp_id') &&
            ! Arr::has($payload, 'lp_name')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/learning_path_enrollments', [
                'body' => json_encode([
                    'Enrollment' => $payload,
                ]),
            ]);
        });
    }
}
