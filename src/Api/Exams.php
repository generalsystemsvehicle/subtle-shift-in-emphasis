<?php

namespace GeneralSystemsVehicle\LearnUpon\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\LearnUpon\Guzzle\Api;

class Exams extends Api
{
    /**
     * Get an exam's settings.
     * https://docs.learnupon.com/api/#exams-and-surveys
     *
     * @param  string $examId
     * @return array|null
     */
    public function get($examId)
    {
        return $this->try(function() use ($examId)
        {
            return $this->client->get('v1/exams/'.$examId);
        });
    }

    /**
     * Get question set for an exam.
     * https://docs.learnupon.com/api/#search-for-questions-and-associated-answers-from-a-specific-exam
     *
     * @param  string $examId
     * @return array|null
     */
    public function questions($examId)
    {
        return $this->try(function() use ($examId)
        {
            return $this->client->get('v1/exams/'.$examId.'/questions');
        });
    }

    /**
     * Get enrollments for an exam.
     * https://docs.learnupon.com/api/#search-for-exam-data
     *
     * @param  string $examId
     * @return array|null
     */
    public function enrollments($examId)
    {
        return $this->try(function() use ($examId)
        {
            return $this->client->get('v1/exams/'.$examId.'/enrollments');
        });
    }

    /**
     * Get answers for an exam.
     * https://docs.learnupon.com/api/#search-for-exam-data
     *
     * @param  string $examId
     * @param  string $examEnrollmentId
     * @return array|null
     */
    public function answers($examId, $examEnrollmentId)
    {
        return $this->try(function() use ($examId, $examEnrollmentId)
        {
            return $this->client->get('v1/exams/'.$examId.'/answers/'.$examEnrollmentId);
        });
    }
}
