<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class CourseInstructors extends Api
{
    /**
     * Search course instructors.
     * https://docs.learnupon.com/api/#search-for-courseinstructors
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/course_instructors', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a course instructor.
     * https://docs.learnupon.com/api/#create-a-courseinstructor
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        if (! Arr::has($payload, 'user_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/course_instructors', [
                'body' => json_encode([
                    'CourseInstructor' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a course instructor.
     * https://docs.learnupon.com/api/#delete-a-courseinstructor
     *
     * @param  string $courseInstructorId
     * @return array|null
     */
    public function delete($courseInstructorId)
    {
        return $this->try(function() use ($courseInstructorId)
        {
            return $this->client->delete('v1/course_instructors/'.$courseInstructorId);
        });
    }
}
