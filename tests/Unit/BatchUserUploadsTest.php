<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\BatchUserUploads;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class BatchUserUploadsTest extends TestCase
{
    /** @test */
    function it_creates_an_upload()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/BatchUserUploads/create.json')),
        ]);

        $api = new BatchUserUploads(['mock' => $mock]);

        $response = $api->upload();

        $this->assertNull($response);

        $response = $api->upload([
            'sftp_username' => 'example_username',
        ]);

        $this->assertNull($response);

        $response = $api->upload([
            'user_id' => '1000001',
        ]);

        $this->assertNull($response);

        $response = $api->upload([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
        ]);

        $this->assertNull($response);

        $response = $api->upload([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
            'sftp_password' => 'example_password',
        ]);

        $this->assertNull($response);

        $response = $api->upload([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
            'sftp_password' => 'example_password',
            'file_url' => 'sftp://198.51.100.1:22/example_file.csv',
            'batch_params' => [
                'invite_users' => false,
                'update_users' => false,
                'group_sync' => false
            ],
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    /** @test */
    function it_creates_and_syncs_an_upload()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/BatchUserUploads/create.json')),
        ]);

        $api = new BatchUserUploads(['mock' => $mock]);

        $response = $api->uploadAndSync();

        $this->assertNull($response);

        $response = $api->uploadAndSync([
            'sftp_username' => 'example_username',
        ]);

        $this->assertNull($response);

        $response = $api->uploadAndSync([
            'user_id' => '1000001',
        ]);

        $this->assertNull($response);

        $response = $api->uploadAndSync([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
        ]);

        $this->assertNull($response);

        $response = $api->uploadAndSync([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
            'sftp_password' => 'example_password',
        ]);

        $this->assertNull($response);

        $response = $api->uploadAndSync([
            'user_id' => '1000001',
            'sftp_username' => 'example_username',
            'sftp_password' => 'example_password',
            'file_url' => 'sftp://198.51.100.1:22/example_file.csv',
            'batch_params' => [
                'invite_users' => false,
                'group_sync' => false
            ],
        ]);

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
