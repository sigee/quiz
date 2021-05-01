<?php

namespace Controller\Api;

use Quiz\Game as QuizGame;

class Game
{

    public const MAX_ROUND = 20;
    private QuizGame $quizGame;

    public function __construct()
    {
        $this->quizGame = new QuizGame();
    }

    function status()
    {
        $status = [
            'current_question_id' => $_SESSION['current_question_id'],
            'current_round' => $_SESSION['current_round'],
            'max_round' => self::MAX_ROUND,
            'ongoing' => (bool)$_SESSION['ongoing'],
            'question' => $this->quizGame->getQuestion($_SESSION['current_question_id']),
            'selected_answer' => $_SESSION['selected_answer']
        ];

        return json_encode($status);
    }

    function start()
    {
        if (!$_SESSION['ongoing']) {
            $_SESSION['ongoing'] = true;
            $_SESSION['current_round'] = 1;
            $_SESSION['current_question_id'] = $this->quizGame->generateQuestionId();

            return $this->status();
        } else {
            http_response_code(400);
            exit;
        }
    }

    function restart()
    {
        $this->stop();
        return $this->start();
    }

    function select() {
        $_SESSION['selected_answer'] = $_POST['answer_id'];
        return json_encode(['selected' => $_POST['answer_id']]);
    }

    /** @TODO: For testing only. REMOVE IT!!! */
    function stop()
    {
        $_SESSION['ongoing'] = false;
        unset($_SESSION['current_round'], $_SESSION['current_question_id'], $_SESSION['selected_answer']);

        return $this->status();
    }
}
