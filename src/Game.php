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

    public function getPlayer1(): Player
    {
        return $this->player1;
    }

    public function getPlayer2(): Player
    {
        return $this->player2;
    }

    public function playRound(Card $player1Card, Card $player2Card): void
    {
        $this->player1->getRemainingCards()->removeCard($player1Card);
        $this->player2->getRemainingCards()->removeCard($player2Card);
    }

}