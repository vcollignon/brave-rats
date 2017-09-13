<?php

declare(strict_types = 1);

namespace BraveRats\RoundResolvers;

use BraveRats\Card;
use BraveRats\Round;
use BraveRats\RoundHistory;
use BraveRats\RoundResult;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;

class ValueResolver
{
    public function resolve(Round $round, RoundHistory $roundHistory): RoundResult
    {
        $player1Card = $round->getPlayer1Card();
        $player2Card = $round->getPlayer2Card();

        $player1Bonus = 0;
        $player2Bonus = 0;

        $penultiemRound = $roundHistory->getPenultiemRound($round);

        if($penultiemRound instanceof Round)
        {
            if($penultiemRound->isPlayer1General())
            {
                $player1Bonus = 2;
            }
            if($penultiemRound->isPlayer2General())
            {
                $player2Bonus = 2;
            }

        }

        if ($this->isAssassin($player1Card, $player2Card))
        {
            return $this->computeAssassinRoundResult($player1Card, $player2Card, $player1Bonus, $player2Bonus);
        }

        return $this->computeDefaultRoundResult($player1Card, $player2Card, $player1Bonus, $player2Bonus);
    }

    private function computeDefaultRoundResult(Card $player1Card, Card $player2Card, $player1Bonus, $player2Bonus): RoundResult
    {
        $player1Value = $player1Card->getValue() + $player1Bonus;
        $player2Value = $player2Card->getValue() + $player2Bonus;

        if($player1Value > $player2Value)
        {
            return new Player1Win($player1Card);
        }

        if($player2Value > $player1Value)
        {
            return new Player2Win($player2Card);
        }

        return new RoundOnHold();
    }

    private function computeAssassinRoundResult(Card $player1Card, Card $player2Card, $player1Bonus, $player2Bonus): RoundResult
    {
        $player1Value = $player1Card->getValue() + $player1Bonus;
        $player2Value = $player2Card->getValue() + $player2Bonus;

        if($player1Value < $player2Value)
        {
            return new Player1Win($player1Card);
        }

        if($player2Value < $player1Value)
        {
            return new Player2Win($player2Card);
        }

        return new RoundOnHold();
    }

    private function isAssassin(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::ASSASSIN || $player2Card->getLabel() === Card::ASSASSIN;
    }

}