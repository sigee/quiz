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

}
