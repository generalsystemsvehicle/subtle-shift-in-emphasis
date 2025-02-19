<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\PortalInvites;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class PortalInvitesTest extends TestCase
{
    function test_it_creates_a_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/PortalInvites/create.json')),
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/PortalInvites/create.json')),
        ]);

        $api = new PortalInvites(['mock' => $mock]);

        $response = $api->create();

        $this->assertNull($response);

        $response = $api->create([]);

        $this->assertNull($response);

        $response = $api->create([
            'first_name' => 'Learn',
            'last_name' => 'Upon',
        ]);

        $this->assertNull($response);

        $response = $api->send();

        $this->assertNull($response);

        $response = $api->send([]);

        $this->assertNull($response);

        $response = $api->send([
            'first_name' => 'Learn',
            'last_name' => 'Upon',
        ]);

        $this->assertNull($response);

        $response = $api->create([
            'first_name' => 'Learn',
            'last_name' => 'Upon',
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $model = Arr::get($response, 'portal_invite');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'portal_invite'));
        $this->assertTrue(Arr::has($model, 'id'));
        $this->assertTrue(Arr::has($model, 'email'));

        $response = $api->send([
            'first_name' => 'Learn',
            'last_name' => 'Upon',
            'email' => 'learnuponapi@samplelearningco.com',
        ]);

        $model = Arr::get($response, 'portal_invite');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'portal_invite'));
    }
}
