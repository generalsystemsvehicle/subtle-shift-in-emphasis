<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Groups;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Groups/index.json')),
        ]);

        $api = new Groups(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'groups'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'groups'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'number_of_members'));
        $this->assertTrue(Arr::has($model,'description'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'updated_at'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Groups/create.json')),
        ]);

        $api = new Groups(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'description' => 'New description',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'title' => 'New Title',
            'description' => 'New description',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_updates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Groups/update.json')),
        ]);

        $api = new Groups(['mock' => $mock]);

        $response = $api->update('1000000', []);

        $this->assertNull($response);

        $response = $api->update('1000000', [
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->update('1000000', [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Groups/delete.json')),
        ]);

        $api = new Groups(['mock' => $mock]);

        $response = $api->delete('1000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
