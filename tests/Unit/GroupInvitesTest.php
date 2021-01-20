<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\GroupInvites;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class GroupInvitesTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInvites/index.json')),
        ]);

        $api = new GroupInvites(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'group_invite'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
        $this->assertTrue(Arr::has($model,'num_reminders_sent'));
        $this->assertTrue(Arr::has($model,'user_type'));
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInvites/get.json')),
        ]);

        $api = new GroupInvites(['mock' => $mock]);

        $response = $api->get('1000000');

        $model = Arr::first(Arr::get($response, 'group_invite'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invite'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
        $this->assertTrue(Arr::has($model,'num_reminders_sent'));
        $this->assertTrue(Arr::has($model,'user_type'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInvites/create.json')),
        ]);

        $api = new GroupInvites(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'group_id' => '100000',
            'group_membership_type_id' => '1',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'email_addresses' => 'learnuponapi@samplelearningco.com',
            'group_id' => '100000',
            'group_membership_type_id' => '1',
        ]);

        $model = Arr::first(Arr::get($response, 'group_invites'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'group_invites'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'invite_email_address'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/GroupInvites/delete.json')),
        ]);

        $api = new GroupInvites(['mock' => $mock]);

        $response = $api->delete('1000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
