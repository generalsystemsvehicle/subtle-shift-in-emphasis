<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GroupCourses;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupCoursesTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupCourses/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupCourses/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupCourses/index.json')),
        ]);

        $api = new GroupCourses(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'group_courses'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_courses'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'group_id'));
        $this->assertTrue(Arr::has($model,'course_id'));
        $this->assertTrue(Arr::has($model,'group_title'));
        $this->assertTrue(Arr::has($model,'course_name'));

        $response = $api->index([
            'group_id' => '100000',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_courses'));

        $response = $api->index([
            'course_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_courses'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupCourses/create.json')),
        ]);

        $api = new GroupCourses(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'course_id' => '1000000',
            're_enroll_completed' => true,
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    function test_it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupCourses/delete.json')),
        ]);

        $api = new GroupCourses(['mock' => $mock]);

        $response = $api->delete('100000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
