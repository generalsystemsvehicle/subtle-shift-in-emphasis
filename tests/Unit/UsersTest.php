<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Users;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class UsersTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/index.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'user'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'user'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'locale'));
    }

    /** @test */
    function it_searches_for_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/search.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->search();

        $this->assertNull($response);

        $response = $api->search([]);

        $this->assertNull($response);

        $response = $api->search([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->search([
            'email' => 'learnuponapi@samplelearningco.com',
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
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/get.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->get('1000001');

        $model = Arr::first(Arr::get($response, 'user'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'user'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'locale'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/create.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'password' => '1234',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
            'password' => '1234',
            'first_name' => 'Learn',
            'last_name' => 'Upon',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_updates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/update.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->update('1000000');

        $this->assertNull($response);

        $response = $api->update('1000000', []);

        $this->assertNull($response);

        $response = $api->update('1000000', [
            'first_name' => 'Of Course',
            'last_name' => 'I Still Love You',
        ]);

        $this->assertNull($response);

        $response = $api->update('1000000', [
            'email' => 'ofcourse@samplelearningco.com',
            'first_name' => 'Of Course',
            'last_name' => 'I Still Love You',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/delete.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->delete('1000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    /** @test */
    function it_returns_a_paginated_index_of_instructors()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/instructors.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->instructors();

        $model = Arr::first(Arr::get($response, 'instructor_users'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'instructor_users'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'instructor_pm_id'));
        $this->assertTrue(Arr::has($model,'user_type'));
    }

    /** @test */
    function it_gets_custom_user_data_fields()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/customUserData.json')),
        ]);

        $api = new Users(['mock' => $mock]);

        $response = $api->customUserData();

        $model = Arr::first(Arr::get($response, 'customDataFieldDefinitions'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'customDataFieldDefinitions'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'type_id'));
        $this->assertTrue(Arr::has($model,'label'));
        $this->assertTrue(Arr::has($model,'predefined_values'));
    }
}
