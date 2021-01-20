<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Enrollments;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class EnrollmentsTest extends TestCase
{
    /** @test */
    function it_searches_for_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Enrollments/search.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Enrollments/search.json')),
        ]);

        $api = new Enrollments(['mock' => $mock]);

        $response = $api->index();

        $this->assertNull($response);

        $response = $api->search();

        $this->assertNull($response);

        $response = $api->index([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->search([
            'other_field' => '0',
        ]);

        $this->assertNull($response);

        $response = $api->index([
            'email' => 'ofcourse@samplelearningco.com',
        ]);

        $model = Arr::first(Arr::get($response, 'enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'date_enrolled'));

        $response = $api->search([
            'email' => 'ofcourse@samplelearningco.com',
        ]);

        $model = Arr::first(Arr::get($response, 'enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'date_enrolled'));
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Enrollments/get.json')),
        ]);

        $api = new Enrollments(['mock' => $mock]);

        $response = $api->get('1000000');

        $model = Arr::first(Arr::get($response, 'enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'enrollments'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'course_id'));
        $this->assertTrue(Arr::has($model,'first_name'));
        $this->assertTrue(Arr::has($model,'last_name'));
        $this->assertTrue(Arr::has($model,'email'));
        $this->assertTrue(Arr::has($model,'date_enrolled'));
    }

    /** @test */
    function it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Enrollments/create.json')),
        ]);

        $api = new Enrollments(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'course_id' => '1000000',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'email' => 'learnuponapi@samplelearningco.com',
            'course_id' => '1000000',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
        $this->assertTrue(Arr::has($response,'created_at'));
    }

    /** @test */
    function it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Enrollments/delete.json')),
        ]);

        $api = new Enrollments(['mock' => $mock]);

        $response = $api->delete('1000000', [
            'remove_from_history' => true,
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
