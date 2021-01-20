<?php

namespace GeneralSystemsVehicle\LearnUpon;

trait ServiceBindings
{
    /**
     * All of the service bindings for package.
     *
     * @var array
     */
    protected $serviceBindings = [
        Api\BatchUserUploads::class,
        Api\Courses::class,
        Api\CourseInstructors::class,
        Api\Enrollments::class,
        Api\Exams::class,
        Api\GamificationBadges::class,
        Api\GamificationLeaderboards::class,
        Api\GroupCourses::class,
        Api\GroupInviteCourseEnrollments::class,
        Api\GroupInvites::class,
        Api\GroupManagers::class,
        Api\GroupMemberships::class,
        Api\Groups::class,
        Api\InstructorLedTrainings::class,
        Api\LearningPathEnrollments::class,
        Api\LearningPaths::class,
        Api\MarkCompletes::class,
        Api\Modules::class,
        Api\PortalInvites::class,
        Api\Portals::class,
        Api\Users::class,
    ];
}
