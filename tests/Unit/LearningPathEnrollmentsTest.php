<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\LearningPathEnrollments;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class LearningPathEnrollmentsTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/index.json')),
        ]);

        $api = new LearningPathEnrollments(['mock' => $mock]);

        $response = $api->index();

        $this->assertNull($response);

        $response = $api->index([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->index([
            'user_id' => '1000000',
        ]);

        $model = Arr::first(Arr::get($response, 'enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'percentage'));
        $this->assertTrue(Arr::has($model,'lp_id'));
        $this->assertTrue(Arr::has($model,'lp_name'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'certificate_name'));
        $this->assertTrue(Arr::has($model,'status'));

        $response = $api->index([
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));

        $response = $api->index([
            'username' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));

        $response = $api->index([
            'lp_id' => '10000',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));

        $response = $api->index([
            'lp_name' => 'Learning Path',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
    }

    function test_it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/get.json')),
        ]);

        $api = new LearningPathEnrollments(['mock' => $mock]);

        $response = $api->get('1000001');

        $model = Arr::first(Arr::get($response, 'enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'percentage'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'certificate_name'));
        $this->assertTrue(Arr::has($model,'date_enrolled'));
        $this->assertTrue(Arr::has($model,'cert_expires_at'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPathEnrollments/create.json')),
        ]);

        $api = new LearningPathEnrollments(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([
            'lp_name' => 'Learning Path',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
            'lp_name' => 'Learning Path',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
        $this->assertTrue(Arr::has($response,'created_at'));
    }
}
