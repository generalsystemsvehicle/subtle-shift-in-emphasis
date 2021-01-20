<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\MarkCompletes;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class MarkCompletesTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/MarkCompletes/index.json')),
        ]);

        $api = new MarkCompletes(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'markcompletes'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'markcompletes'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'percentage'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'notes'));
        $this->assertTrue(Arr::has($model,'status'));
        $this->assertTrue(Arr::has($model,'action_source_type'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'date_completed'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/MarkCompletes/create.json')),
        ]);

        $api = new MarkCompletes(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'enrollment_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'date_completed' => '1975-10-10T10:10:10Z',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'enrollment_id' => '1000000',
            'date_completed' => '1975-10-10T10:10:10Z',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'enrollment_id' => '1000000',
            'date_completed' => '1975-10-10T10:10:10Z',
            'status' => 'completed',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
        $this->assertTrue(Arr::has($response,'created_at'));
    }
}
