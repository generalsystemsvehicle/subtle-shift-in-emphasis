<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\InstructorLedTrainings;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class InstructorLedTrainingsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/index.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'ilts'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'ilts'));
        $this->assertTrue(Arr::has($model,'course_id'));
        $this->assertTrue(Arr::has($model,'course_name'));
        $this->assertTrue(Arr::has($model,'start_date'));
        $this->assertTrue(Arr::has($model,'end_date'));
        $this->assertTrue(Arr::has($model,'session_type'));

        $response = $api->search([
            'course_id' => '1000000',
        ]);

        $model = Arr::first(Arr::get($response, 'ilts'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'ilts'));
        $this->assertTrue(Arr::has($model,'course_id'));
        $this->assertTrue(Arr::has($model,'course_name'));
        $this->assertTrue(Arr::has($model,'start_date'));
        $this->assertTrue(Arr::has($model,'end_date'));
        $this->assertTrue(Arr::has($model,'session_type'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/create.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'component' => [
                'session_type' => 'classroom',
                'title' => 'LearnUpon University Hawaii Session',
                'description' => '<p>Unlock the power of learning with LearnUpon LMS</p>\r\n',
                'tags' => 'Classroom, LearnUpon,',
                'timezone_id' => 'Hawaii',
                'location_id' => 2345,
                'start_at' => '2020-12-29T09:00:00',
                'end_at' => '2020-12-29T09:10:00',
                'max_capacity' => 25
            ],
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => 'learnuponapi@samplelearningco.com',
            'component' => [
                'session_type' => 'classroom',
                'title' => 'LearnUpon University Hawaii Session',
                'description' => '<p>Unlock the power of learning with LearnUpon LMS</p>\r\n',
                'tags' => 'Classroom, LearnUpon,',
                'timezone_id' => 'Hawaii',
                'location_id' => 2345,
                'start_at' => '2020-12-29T09:00:00',
                'end_at' => '2020-12-29T09:10:00',
                'max_capacity' => 25
            ],
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_returns_a_paginated_index_of_locations()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/locations.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->locations();

        $model = Arr::first(Arr::get($response, 'locations'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'locations'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'address_1'));
        $this->assertTrue(Arr::has($model,'address_2'));
        $this->assertTrue(Arr::has($model,'address_3'));
        $this->assertTrue(Arr::has($model,'timezone'));
        $this->assertTrue(Arr::has($model,'country_code'));
    }

    /** @test */
    function it_returns_a_list_of_timezones()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/timezones.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->timezones();

        $model = Arr::first(Arr::get($response, 'timezones'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'timezones'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
    }

    /** @test */
    function it_returns_a_list_of_webinar_connections()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/webinarConnections.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->webinarConnections();

        $model = Arr::first(Arr::get($response, 'webinar_connections'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'webinar_connections'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'has_default_password'));
    }

    /** @test */
    function it_returns_a_paginated_index_of_webinars()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/InstructorLedTrainings/webinars.json')),
        ]);

        $api = new InstructorLedTrainings(['mock' => $mock]);

        $response = $api->webinars();

        $this->assertNull($response);

        $response = $api->webinars([]);

        $this->assertNull($response);

        $response = $api->webinars([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->webinars([
            'webinar_connection_id' => '1000',
        ]);

        $model = Arr::first(Arr::get($response, 'webinars'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'webinars'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
    }
}
