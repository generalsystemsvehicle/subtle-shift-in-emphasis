<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Api\Exams;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;

class ExamsTest extends TestCase
{
    function test_it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Exams/get.json')),
        ]);

        $api = new Exams(['mock' => $mock]);

        $response = $api->get('1000000');

        $model = Arr::get($response, 'exam');

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'exam'));
        $this->assertTrue(Arr::has($model,'name'));
        $this->assertTrue(Arr::has($model,'is_survey'));
        $this->assertTrue(Arr::has($model,'exam_id'));
    }

    function test_it_gets_a_list_of_questions()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Exams/questions.json')),
        ]);

        $api = new Exams(['mock' => $mock]);

        $response = $api->questions('1000000');

        $model = Arr::first(Arr::get($response, 'questions'));

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'exam_id'));
        $this->assertIsArray(Arr::get($response, 'questions'));
        $this->assertTrue(Arr::has($model,'question_id'));
        $this->assertTrue(Arr::has($model,'question_text'));
        $this->assertTrue(Arr::has($model,'question_type'));
        $this->assertTrue(Arr::has($model,'question_choice_type'));
        $this->assertTrue(Arr::has($model,'points'));
        $this->assertIsArray(Arr::get($model, 'answers'));
    }

    function test_it_gets_a_list_of_enrollments()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Exams/enrollments.json')),
        ]);

        $api = new Exams(['mock' => $mock]);

        $response = $api->enrollments('1000000');

        $model = Arr::first(Arr::get($response, 'exam_enrollments'));

        $this->assertIsArray($response);
        $this->assertIsArray(Arr::get($response, 'exam_enrollments'));
        $this->assertTrue(Arr::has($model,'exam_id'));
        $this->assertTrue(Arr::has($model,'exam_enrollment_id'));
        $this->assertTrue(Arr::has($model,'time_taken'));
        $this->assertTrue(Arr::has($model,'attempts_used'));
        $this->assertTrue(Arr::has($model,'score'));
        $this->assertTrue(Arr::has($model,'user_id'));
        $this->assertTrue(Arr::has($model,'portal_membership_id'));
    }

    function test_it_gets_a_list_of_submitted_answers()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Exams/answers.json')),
        ]);

        $api = new Exams(['mock' => $mock]);

        $response = $api->answers('1000000', '10000000');

        $model = Arr::first(Arr::get($response, 'questions'));

        $this->assertIsArray($response);
        $this->assertTrue(Arr::has($response,'exam_id'));
        $this->assertIsArray(Arr::get($response, 'questions'));
        $this->assertTrue(Arr::has($model,'question_text'));
        $this->assertIsArray(Arr::get($model, 'answers'));
        $this->assertTrue(Arr::has($model,'overall_status'));
        $this->assertTrue(Arr::has($response,'user'));
        $this->assertTrue(Arr::has($response,'email'));
    }
}
