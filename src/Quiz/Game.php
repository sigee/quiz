<?php

namespace Quiz;

use PDO;

class Game
{

    public function __construct()
    {
    }

    public function example(int $a, int $b): int
    {
        return $a + $b;
    }

    // @TODO: get random question id from database
    public function generateQuestionId($previousQuestions = [])
    {
        return 1;
    }

    public function getQuestion($current_question_id)
    {
        return [
            'text' => 'Mi a kérdés?',
            'answers' => [
                1 => 'Válasz 1',
                2 => 'Válasz 2',
                3 => 'Válasz 3',
                4 => 'Válasz 4'
            ],
        ];
    }

}
