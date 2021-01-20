<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\LearningPaths;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class LearningPathsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/LearningPaths/index.json')),
        ]);

        $api = new LearningPaths(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'learning_paths'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'learning_paths'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'sellable'));
        $this->assertTrue(Arr::has($model,'cataloged'));
        $this->assertTrue(Arr::has($model,'keywords'));
        $this->assertTrue(Arr::has($model,'due_days_after_enrollment'));
    }
}
