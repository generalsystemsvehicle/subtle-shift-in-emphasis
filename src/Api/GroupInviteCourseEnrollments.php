<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class GroupInviteCourseEnrollments extends Api
{
    /**
     * Search for group invite course enrollments.
     * https://docs.learnupon.com/api/#search-for-all-groupinvitecourseenrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->search($payload);
    }

    /**
     * Search for group invite course enrollments.
     * https://docs.learnupon.com/api/#search-for-all-groupinvitecourseenrollments
     *
     * @param  array $payload
     * @return array|null
     */
    public function search($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/group_invite_course_enrollments', [
                'query' => $payload,
            ]);
        });
    }

    /**
     * Get a group invite course enrollment.
     * https://docs.learnupon.com/api/#group-invite-course-enrollment
     *
     * @param  string $groupInviteCourseEnrollmentId
     * @return array|null
     */
    public function get($groupInviteCourseEnrollmentId)
    {
        return $this->try(function() use ($groupInviteCourseEnrollmentId)
        {
            return $this->client->get('v1/group_invite_course_enrollments/'.$groupInviteCourseEnrollmentId);
        });
    }

    /**
     * Create a group invite course enrollment.
     * https://docs.learnupon.com/api/#create-a-groupinvitecourseenrollment
     *
     * @param  array  $payload
     * @return array|null
     */
    public function create($payload = [])
    {
        if (count($payload) == 0) {
            return null;
        }

        if (! Arr::has($payload, 'group_invite_id')) {
            return null;
        }

        if (! Arr::has($payload, 'course_id') && ! Arr::has($payload, 'course_name')) {
            return null;
        }

        return $this->try(function() use ($payload)
        {
            return $this->client->post('v1/group_invite_course_enrollments', [
                'body' => json_encode([
                    'GroupInviteCourseEnrollment' => $payload,
                ]),
            ]);
        });
    }

    /**
     * Delete a group invite course enrollment.
     * https://docs.learnupon.com/api/#delete-a-groupinvite
     *
     * @param  string $groupInviteCourseEnrollmentId
     * @return array|null
     */
    public function delete($groupInviteCourseEnrollmentId)
    {
        return $this->try(function() use ($groupInviteCourseEnrollmentId)
        {
            return $this->client->delete('v1/group_invite_course_enrollments/'.$groupInviteCourseEnrollmentId);
        });
    }
}
