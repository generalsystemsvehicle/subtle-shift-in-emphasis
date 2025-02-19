<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\CourseInstructors;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class CourseInstructorsTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/CourseInstructors/index.json')),
        ]);

        $api = new CourseInstructors(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'course_instructor'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'course_instructor'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'enrollment_count'));
        $this->assertTrue(Arr::has($model,'course_id'));
        $this->assertTrue(Arr::has($model,'course_name'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'owner_user_id'));
        $this->assertTrue(Arr::has($model,'owner_email'));
        $this->assertTrue(Arr::has($model,'owner_first_name'));
        $this->assertTrue(Arr::has($model,'owner_last_name'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'course_created_at'));
        $this->assertTrue(Arr::has($model,'date_published'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/CourseInstructors/create.json')),
        ]);

        $api = new CourseInstructors(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'user_id' => '1000001',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => '1000000',
            'user_id' => '1000001',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
        $this->assertTrue(Arr::has($response,'created_at'));
    }

    function test_it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/CourseInstructors/delete.json')),
        ]);

        $api = new CourseInstructors(['mock' => $mock]);

        $response = $api->delete('100000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
