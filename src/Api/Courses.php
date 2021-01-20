<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Courses extends Api
{
    /**
     * Get all courses.
     * https://docs.learnupon.com/api/#search-for-courses
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search for courses.
     * https://docs.learnupon.com/api/#search-for-courses
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/courses', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a course.
     * https://docs.learnupon.com/api/#create-a-course
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'name')) {
            return null;
        }

        if (! Arr::has($payload, 'owner_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/courses', [
                'body' => json_encode([
                    'Course' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Publish a course.
     * https://docs.learnupon.com/api/#publish-courses
     *
     * @param  array  $payload
     * @return array|null
     */
    public function publish($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/courses/publish', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Clone a course.
     * https://docs.learnupon.com/api/#clone-copy-course
     *
     * @param  array  $payload
     * @return array|null
     */
    public function clone($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/courses/clone', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Add a module to a course.
     * https://docs.learnupon.com/api/#add-a-module-to-a-course
     *
     * @param  array  $payload
     * @return array|null
     */
    public function addModule($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        if (! Arr::has($payload, 'module_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/courses/add_module', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Remove a module from a course.
     * https://docs.learnupon.com/api/#remove-module-from-a-course
     *
     * @param  array  $payload
     * @return array|null
     */
    public function removeModule($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        if (! Arr::has($payload, 'module_id')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/courses/remove_module', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Remove a module from a course.
     * https://docs.learnupon.com/api/#remove-module-from-a-course
     *
     * @param  string $courseId
     * @param  array  $payload
     * @return array|null
     */
    public function update($courseId, $payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        return $this->try(function() use ($courseId, $payload)
        {
            return $this->client->put('v1/courses/'.$courseId, [
                'body' => json_encode([
                    'Course' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a course.
     * https://docs.learnupon.com/api/#delete-courses
     *
     * @param  string $courseId
     * @return array|null
     */
    public function delete($courseId)
    {
        return $this->try(function() use ($courseId)
        {
            return $this->client->delete('v1/courses/'.$courseId);
        });
    }
}
