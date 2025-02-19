<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GroupMemberships;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupMembershipsTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupMemberships/indexGroupId.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupMemberships/indexUserId.json')),
        ]);

        $api = new GroupMemberships(['mock' => $mock]);

        $response = $api->index();

        $this->assertNull($response);

        $response = $api->index([]);

        $this->assertNull($response);

        $response = $api->index([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->index([
            'group_id' => '100000',
        ]);

        $model = Arr::first(Arr::get($response, 'user'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'user'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'locale'));

        $response = $api->index([
            'user_id' => '1000000',
        ]);

        $model = Arr::first(Arr::get($response, 'group'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'description'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'updated_at'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupMemberships/create.json')),
        ]);

        $api = new GroupMemberships(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'user_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'user_id' => '1000000',
            'process_enrollments' => true,
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    function test_it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupMemberships/delete.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupMemberships/delete.json')),
        ]);

        $api = new GroupMemberships(['mock' => $mock]);

        $response = $api->delete(0, []);

        $this->assertNull($response);

        $response = $api->delete(0, [
            'group_id' => '100000',
        ]);

        $this->assertNull($response);

        $response = $api->delete('10000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);

        $response = $api->delete(0, [
            'group_id' => '100000',
            'user_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
