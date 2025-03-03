<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class ApiTest extends TestCase
{
    function test_it_handles_a_json_response()
    {
        $api = new Api();

        $response = new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Users/get.json'));

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $user = Arr::first(Arr::get($response, 'user'));

        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array(Arr::get($response, 'user')));
        $this->assertTrue(Arr::has($user,'id'));
        $this->assertTrue(Arr::has($user,'first_name'));
        $this->assertTrue(Arr::has($user,'last_name'));
        $this->assertTrue(Arr::has($user,'email'));
        $this->assertTrue(Arr::has($user,'created_at'));
        $this->assertTrue(Arr::has($user,'locale'));
    }

    function test_it_catches_a_request_exception()
    {
        $api = new Api();

        $response = function () {
            throw new ClientException('+1 second delay', new Request('get', 'test'), new Response(404));
        };

        $response = $this->invokeMethod($api, 'try', [ $response ]);

        $this->assertTrue(is_null($response));
    }

    function test_it_handles_an_empty_json_response()
    {
        $api = new Api();

        $response = new Response(200, ['Content-Type' => 'application/json']);

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $this->assertTrue(is_null($response));
    }

    function test_it_handles_an_xml_response()
    {
        $api = new Api();

        $response = new Response(200, ['Content-Type' => 'application/xml'], file_get_contents(__DIR__.'/../Fixtures/Stubbies/get.xml'));

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('id', $response));
    }

    function test_it_handles_an_empty_xml_response()
    {
        $api = new Api();

        $response = new Response(200, ['Content-Type' => 'application/xml']);

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $this->assertTrue(is_null($response));
    }

    function test_it_handles_a_learnupon_current_page_header()
    {
        $api = new Api();

        $response = new Response(200, ['LU-Current-Page' => '1'], file_get_contents(__DIR__.'/../Fixtures/Users/index.json'));

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $model = Arr::get($response, 'metadata');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'metadata'));
        $this->assertTrue(Arr::has($model,'current_page'));
    }

    function test_it_handles_a_learnupon_records_per_page_header()
    {
        $api = new Api();

        $response = new Response(200, ['LU-Records-Per-Page' => '500'], file_get_contents(__DIR__.'/../Fixtures/Users/index.json'));

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $model = Arr::get($response, 'metadata');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'metadata'));
        $this->assertTrue(Arr::has($model,'per_page'));
    }

    function test_it_handles_a_learnupon_has_next_page_header()
    {
        $api = new Api();

        $response = new Response(200, ['LU-Has-Next-Page' => true], file_get_contents(__DIR__.'/../Fixtures/Users/index.json'));

        $response = $this->invokeMethod($api, 'handleReponse', [ $response ]);

        $model = Arr::get($response, 'metadata');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'metadata'));
        $this->assertTrue(Arr::has($model,'has_next_page'));
    }

    function test_it_handles_a_404_response()
    {
        $api = new Api();

        $exception = new RequestException(
            'Page not found',
            new Request('GET', 'test'),
            new Response(404, ['Content-Type' => 'application/json'])
        );

        $response = $this->invokeMethod($api, 'handleBadResponse', [ $exception ]);

        $this->assertTrue(is_null($response));
    }

    function test_it_handles_a_422_response()
    {
        $api = new Api();

        $exception = new RequestException(
            'Unprocessable Entity',
            new Request('GET', 'test'),
            new Response(422, ['Content-Type' => 'application/json'])
        );

        $response = $this->invokeMethod($api, 'handleBadResponse', [ $exception ]);

        $this->assertTrue(is_null($response));
    }

    function test_it_throws_an_exception_for_other_bad_responses()
    {
        $this->expectException(RequestException::class);

        $api = new Api();

        $exception = new RequestException(
            'Forbidden',
            new Request('GET', 'test'),
            new Response(403, ['Content-Type' => 'application/json'])
        );

        $response = $this->invokeMethod($api, 'handleBadResponse', [ $exception ]);
    }
}
