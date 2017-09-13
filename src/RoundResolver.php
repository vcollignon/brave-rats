<?php

declare(strict_types = 1);

namespace BraveRats;

use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;

class RoundResolver
{
    public function resolve(Round $round): RoundResult
    {
        $player1Card = $round->getPlayer1Card();
        $player2Card = $round->getPlayer2Card();

        if($player1Card->getValue() > $player2Card->getValue())
        {
            return new Player1Win();
        }

        if($player2Card->getValue() > $player1Card->getValue())
        {
            return new Player2Win();
        }

        return new RoundOnHold();
    }
}