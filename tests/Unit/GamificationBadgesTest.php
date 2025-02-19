<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GamificationBadges;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GamificationBadgesTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GamificationBadges/index.json')),
        ]);

        $api = new GamificationBadges(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'badges'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'badges'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'points'));
        $this->assertTrue(Arr::has($model,'is_used'));
        $this->assertTrue(Arr::has($model,'badge_type_id'));
        $this->assertTrue(Arr::has($model,'badge_type'));
    }
}
