<?php

declare(strict_types = 1);

namespace BraveRats;

class Round
{
    private
        $player1Card,
        $player2Card;

    public function __construct(Card $player1Card, Card $player2Card)
    {
        $this->player1Card = $player1Card;
        $this->player2Card = $player2Card;
    }

    public function getPlayer1Card(): Card
    {
        return $this->player1Card;
    }

    public function getPlayer2Card(): Card
    {
        return $this->player2Card;
    }
}