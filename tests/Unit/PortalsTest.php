<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Portals;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class PortalsTest extends TestCase
{
    function test_it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Portals/index.json')),
        ]);

        $api = new Portals(['mock' => $mock]);

        $response = $api->index();

        $model = Arr::first(Arr::get($response, 'portals'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'portals'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'title'));
        $this->assertTrue(Arr::has($model,'subdomain'));
        $this->assertTrue(Arr::has($model,'ui_theme'));
        $this->assertTrue(Arr::has($model,'allow_course_authoring'));
        $this->assertTrue(Arr::has($model,'created_at'));
    }

    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Portals/create.json')),
        ]);

        $api = new Portals(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'subdomain' => 'clientx',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'title' => 'New Title',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'subdomain' => 'clientx',
            'title' => 'New Title',
            'description' => 'New description',
            'logo_image_url' => 'Image url',
            'banner_image_url' => 'Image url',
            'store_banner_image_url' => 'Image url',
            'favicon_image_url' => 'Image url',
            'header_color' => '#419BBD',
            'navigation_color' => '#256188',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    function test_it_updates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Portals/update.json')),
        ]);

        $api = new Portals(['mock' => $mock]);

        $response = $api->update('100000', []);

        $this->assertNull($response);

        $response = $api->update('100000', [
            'subdomain' => 'clienty',
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'logo_image_url' => 'Image url',
            'banner_image_url' => 'Image url',
            'store_banner_image_url' => 'Image url',
            'favicon_image_url' => 'Image url',
            'header_color' => '#419BBD',
            'navigation_color' => '#256188',
        ]);

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'id'));
    }

    function test_it_deletes_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Portals/delete.json')),
        ]);

        $api = new Portals(['mock' => $mock]);

        $response = $api->delete('100000');

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    function test_it_generates_api_keys()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Portals/generateKeys.json')),
        ]);

        $api = new Portals(['mock' => $mock]);

        $response = $api->generateKeys('100000');

        $model = Arr::get($response, 'portal');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'portal'));
        $this->assertTrue(Arr::has($model,'id'));
        $this->assertTrue(Arr::has($model,'username'));
        $this->assertTrue(Arr::has($model,'password'));
    }
}
