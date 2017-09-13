<?php

declare(strict_types = 1);

namespace BraveRats;

use BraveRats\RoundResolver;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;

class GameResolver
{
    private
        $roundResolver;

    public function __construct()
    {
        $this->roundResolver = new RoundResolver();
    }

    public function resolve(RoundHistory $roundHistory): GameResult
    {
        $gameResult = new GameResult();

        foreach ($roundHistory as $round)
        {
            $gameResult->roundNumber++;

            $roundResult = $this->roundResolver->resolve($round);

            if($roundResult instanceof Player1Win)
            {
                $gameResult->player1WonRounds++;
            }
            if($roundResult instanceof Player2Win)
            {
                $gameResult->player2WonRounds++;
            }
        }

        return $gameResult;
    }
    
}