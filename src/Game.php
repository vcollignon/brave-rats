<?php

declare(strict_types = 1);

namespace BraveRats;

class Game
{
    private
        $player1,
        $player2,
        $currentPlayer,
        $roundHistory,
        $gameResolver;

    public function __construct()
    {
        $this->player1 = new Player('Yargs');
        $this->player2 = new Player('Applewoods');

        $this->currentPlayer = $this->player1;
        $this->roundHistory = new RoundHistory();
        $this->gameResolver = new GameResolver();
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

    public function playRound(Card $player1Card, Card $player2Card): GameResult
    {
        $this->player1->getRemainingCards()->removeCard($player1Card);
        $this->player2->getRemainingCards()->removeCard($player2Card);

        $round = new Round($player1Card, $player2Card);

        $this->roundHistory->addRound($round);

        return $this->gameResolver->resolve($this->roundHistory);
    }

}