<?php

namespace BraveRats\RoundResolvers;

use BraveRats\Card;
use BraveRats\Round;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;
use PHPUnit\Framework\TestCase;

class ValueResolverTest extends TestCase
{
    public function testResolveCardValues()
    {
        $player1Card = Card::general();
        $player2Card = Card::magicien();

        $round = new Round($player1Card, $player2Card);

        $valueResolver = new ValueResolver();
        $roundResult = $valueResolver->resolve($round);

        $this->assertTrue($roundResult instanceof Player1Win);

        $player1Card = Card::espion();
        $player2Card = Card::embassadeur();

        $round = new Round($player1Card, $player2Card);

        $valueResolver = new ValueResolver();
        $roundResult = $valueResolver->resolve($round);

        $this->assertTrue($roundResult instanceof Player2Win);

        $player1Card = Card::musicien();
        $player2Card = Card::musicien();

        $round = new Round($player1Card, $player2Card);

        $valueResolver = new ValueResolver();
        $roundResult = $valueResolver->resolve($round);

        $this->assertTrue($roundResult instanceof RoundOnHold);
    }
}
