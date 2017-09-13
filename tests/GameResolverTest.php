<?php

namespace BraveRats;

use BraveRats\Card;
use BraveRats\GameResolver;
use BraveRats\GameResult;
use PHPUnit\Framework\TestCase;

class GameResolverTest extends TestCase
{
    public function testResolve()
    {
        $roundHistory = new RoundHistory();
        $roundHistory
            ->addRound(new Round(Card::general(), Card::magicien())) //joueur1 gagne
            ->addRound(new Round(Card::prince(), Card::embassadeur())) //joueur1 gagne
            ->addRound(new Round(Card::embassadeur(), Card::general())) //joueur 2 gagne
            ->addRound(new Round(Card::assassin(), Card::assassin())); //manche nulle

        $gameResolver = new GameResolver();
        $gameResult = $gameResolver->resolve($roundHistory);

        $this->assertTrue($gameResult instanceof GameResult);
        $this->assertSame(2, $gameResult->player1WonRounds);
        $this->assertSame(1, $gameResult->player2WonRounds);
        $this->assertSame(4, $gameResult->roundNumber);
    }
}
