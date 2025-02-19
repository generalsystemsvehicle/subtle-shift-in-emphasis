<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GroupManagers;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupManagersTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/index.json')),
        ]);

        $api = new GroupManagers(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'group_manager'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_manager'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'group_id'));
        $this->assertTrue(Arr::has($model,'group_title'));
        $this->assertTrue(Arr::has($model,'can_create_users'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'updated_at'));

        $response = $api->index([
            'group_id' => '100000',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_manager'));

        $response = $api->index([
            'user_id' => '1000001',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_manager'));

        $response = $api->index([
            'username' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_manager'));

        $response = $api->index([
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_manager'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/create.json')),
        ]);

        $api = new GroupManagers(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'user_id' => '1000001',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'user_id' => '1000001',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'user_id' => '1000001',
            'can_create_users' => true,
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
        $this->assertTrue(Arr::has($response,'created_at'));
    }

    function test_it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupManagers/delete.json')),
        ]);

        $api = new GroupManagers(['mock' => $mock]);

        $response = $api->delete('100000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
