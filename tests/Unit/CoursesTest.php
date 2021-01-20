<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Courses;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class CoursesTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/index.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/index.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'courses'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'courses'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'version'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'date_published'));

        $response = $api->search([
            'name' => 'LearnUpon Test Course',
        ]);

        $model = Arr::first(Arr::get($response, 'courses'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'courses'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'version'));
        $this->assertTrue(Arr::has($model,'created_at'));
        $this->assertTrue(Arr::has($model,'date_published'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/create.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'name' => 'LearnUpon Test Course',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'owner_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'name' => 'LearnUpon Test Course',
            'owner_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_publishes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/publish.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->publish([]);

        $this->assertNull($response);

        $response = $api->publish([
            'lp_logic' => '2',
        ]);

        $this->assertNull($response);

        $response = $api->publish([
            'course_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_clones_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/clone.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->clone([]);

        $this->assertNull($response);

        $response = $api->clone([
            'clone_to_portal_id' => '100000',
        ]);

        $this->assertNull($response);

        $response = $api->clone([
            'course_id' => '1000000',
            'clone_to_portal_id' => '100000',
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    /** @test */
    function it_adds_a_module_to_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/addModule.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->addModule([]);

        $this->assertNull($response);

        $response = $api->addModule([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->addModule([
            'module_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->addModule([
            'course_id' => '1000000',
            'module_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_removes_a_module_to_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/removeModule.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->removeModule([]);

        $this->assertNull($response);

        $response = $api->removeModule([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->removeModule([
            'module_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->removeModule([
            'course_id' => '1000000',
            'module_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_updates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/update.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->update('1000000', []);

        $this->assertNull($response);

        $response = $api->update('1000000', [
            'name' => 'LearnUpon Course',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Courses/delete.json')),
        ]);

        $api = new Courses(['mock' => $mock]);

        $response = $api->delete('1000000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
