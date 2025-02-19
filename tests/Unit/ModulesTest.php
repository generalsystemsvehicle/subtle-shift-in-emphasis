<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Modules;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class ModulesTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Modules/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Modules/index.json')),
        ]);

        $api = new Modules(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'modules'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'modules'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'number_of_linked_courses'));
        $this->assertTrue(Arr::has($model,'created_at'));

        $response = $api->search([
            'course_id' => '1000000',
        ]);

        $model = Arr::first(Arr::get($response, 'modules'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'modules'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'number_of_linked_courses'));
        $this->assertTrue(Arr::has($model,'created_at'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Modules/create.json')),
        ]);

        $api = new Modules(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'module_title' => 'Module Title',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'video_url' => 'https://samplelearningco.com/media.mp4',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'module_title' => 'Module Title',
            'video_url' => 'https://samplelearningco.com/media.mp4',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }
}
