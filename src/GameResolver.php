<?php

declare(strict_types = 1);

namespace BraveRats;

use BraveRats\RoundResolver;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;

class GameResolver
{
    private
        $roundResolver;

    public function __construct(RoundResolver $roundResolver)
    {
        $this->roundResolver = $roundResolver;
    }

    public function resolve(RoundHistory $roundHistory): GameResult
    {
        $gameResult = new GameResult();
        $roundHold = 0;

        foreach ($roundHistory as $round)
        {
            $gameResult->roundNumber++;

            $roundResult = $this->roundResolver->resolve($round, $roundHistory);

            if($roundResult instanceof Player1Win)
            {
                $roundCount = 1;
                if($roundResult->isEmbassadeur())
                {
                    $roundCount = 2;
                }
                $gameResult->player1WonRounds += $roundCount;
                $gameResult->player1WonRounds += $roundHold;
                $roundHold = 0;
            }

            if($roundResult instanceof Player2Win)
            {
                $roundCount = 1;
                if($roundResult->isEmbassadeur())
                {
                    $roundCount = 2;
                }

                $gameResult->player2WonRounds += $roundCount;
                $gameResult->player2WonRounds += $roundHold;
                $roundHold = 0;
            }

            if($roundResult instanceof RoundOnHold)
            {
                $roundHold++;
            }
        }

        return $gameResult;
    }
}