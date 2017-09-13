<?php

declare(strict_types = 1);

namespace BraveRats;

class Game
{
    private
        $player1,
        $player2,
        $currentPlayer;

    public function __construct()
    {
        $this->player1 = new Player('Yargs');
        $this->player2 = new Player('Applewoods');

        $this->currentPlayer = $this->player1;
    }

    public function getCurrentPlayer(): Player
    {
        return $this->currentPlayer;
    }
}