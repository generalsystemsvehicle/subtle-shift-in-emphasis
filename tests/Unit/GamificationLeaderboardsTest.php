<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GamificationLeaderboards;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GamificationLeaderboardsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GamificationLeaderboards/index.json')),
        ]);

        $api = new GamificationLeaderboards(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'users'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'users'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'login'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'position'));
        $this->assertTrue(Arr::has($model,'level'));
        $this->assertTrue(Arr::has($model,'total_points'));
        $this->assertTrue(Arr::has($model,'total_badges'));
    }
}
