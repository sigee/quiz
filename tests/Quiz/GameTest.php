<?php

namespace Quiz;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    private Game $game;

    protected function setUp(): void
    {
        parent::setUp();
        $this->game = new Game();
    }

    public function testExample(): void
    {
        $this->assertEquals(3, $this->game->example(1, 2));
    }
}
