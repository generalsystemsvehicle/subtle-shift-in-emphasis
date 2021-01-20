<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GroupCourses extends Api
{
    /**
     * Search group courses.
     * https://docs.learnupon.com/api/#group-courses
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/group_courses', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Create a group course.
     * https://docs.learnupon.com/api/#create-a-groupcourse
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

        if (! Arr::has($payload, 'course_id')) {
            return null;
        }

        if (! Arr::has($payload, 're_enroll_completed')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/group_courses', [
                'body' => json_encode([
                    'GroupCourse' => Arr::except($payload, ['re_enroll_completed']),
                    're_enroll_completed' => Arr::get($payload, 're_enroll_completed'),
                ]),
            ]);
        });
    }

    /**
     * Delete a group course.
     * https://docs.learnupon.com/api/#delete-a-groupcourse
     *
     * @param  string $groupCourseId
     * @param  array  $payload
     * @return array|null
     */
    public function delete($groupCourseId, $payload = [])
    {
        return $this->try(function() use ($groupCourseId, $payload)
        {
            return $this->client->delete('v1/group_courses/'.$groupCourseId, [
                'body' => json_encode($payload),
            ]);
        });
    }
}
