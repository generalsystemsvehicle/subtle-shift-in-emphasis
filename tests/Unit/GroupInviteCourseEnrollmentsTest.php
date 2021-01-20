<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GroupInviteCourseEnrollments;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupInviteCourseEnrollmentsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInviteCourseEnrollments/index.json')),
        ]);

        $api = new GroupInviteCourseEnrollments(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'group_invite_course_enrollment'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite_course_enrollment'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'group_invite_id'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
        $this->assertTrue(Arr::has($model,'num_reminders_sent'));
        $this->assertTrue(Arr::has($model,'course_id'));
    }

    /** @test */
    function it_searches_for_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInviteCourseEnrollments/index.json')),
        ]);

        $api = new GroupInviteCourseEnrollments(['mock' => $mock]);

        $response = $api->search([
            'course_id' => '1000000',
        ]);

        $model = Arr::first(Arr::get($response, 'group_invite_course_enrollment'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite_course_enrollment'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'group_invite_id'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
        $this->assertTrue(Arr::has($model,'num_reminders_sent'));
        $this->assertTrue(Arr::has($model,'course_id'));
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInviteCourseEnrollments/get.json')),
        ]);

        $api = new GroupInviteCourseEnrollments(['mock' => $mock]);

        $response = $api->get('1000000');

        $model = Arr::first(Arr::get($response, 'group_invite_course_enrollment'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite_course_enrollment'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'group_invite_id'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
        $this->assertTrue(Arr::has($model,'num_reminders_sent'));
        $this->assertTrue(Arr::has($model,'course_id'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInviteCourseEnrollments/create.json')),
        ]);

        $api = new GroupInviteCourseEnrollments(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'group_invite_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_invite_id' => '1000000',
            'course_id' => '1000000',
        ]);

        $model = Arr::get($response, 'group_invite_course_enrollment');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite_course_enrollment'));
        $this->assertTrue(Arr::has($model,'id'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInviteCourseEnrollments/delete.json')),
        ]);

        $api = new GroupInviteCourseEnrollments(['mock' => $mock]);

        $response = $api->delete('1000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
