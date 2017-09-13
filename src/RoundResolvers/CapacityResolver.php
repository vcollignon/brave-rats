<?php

declare(strict_types = 1);

namespace BraveRats\RoundResolvers;

use BraveRats\Card;
use BraveRats\Exceptions\NoResultException;
use BraveRats\Exceptions\Player1WinGame;
use BraveRats\Exceptions\Player1WinGameException;
use BraveRats\Exceptions\Player2WinGameException;
use BraveRats\Exceptions\PrincesseWinGameException;
use BraveRats\Exceptions\RoundOnHoldException;
use BraveRats\Round;
use BraveRats\RoundHistory;
use BraveRats\RoundResult;
use BraveRats\RoundResults\NoResult;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;

class CapacityResolver
{
    public function resolve(Round $round, RoundHistory $roundHistory): RoundResult
    {
        $player1Card = $round->getPlayer1Card();
        $player2Card = $round->getPlayer2Card();

        $checkCardList = [
            'musicien' => function() use($player1Card, $player2Card) {
                return $this->checkMusicien($player1Card, $player2Card);
            },
            'princesse' => function() use($player1Card, $player2Card) {
                return $this->checkPrincesse($player1Card, $player2Card);
            },
            'espion' => function() use($player1Card, $player2Card) {
                return $this->checkEspion($player1Card, $player2Card);
            },
            'assassin' => function() use($player1Card, $player2Card) {
                return $this->checkAssassin($player1Card, $player2Card);
            },
            'magicien' => function() use($player1Card, $player2Card) {
                return $this->checkMagicien($player1Card, $player2Card);
            },
            'prince' => function() use($player1Card, $player2Card) {
                return $this->checkPrince($player1Card, $player2Card);
            },
            'embassadeur' => function() use($player1Card, $player2Card) {
                return $this->checkEmbassadeur($player1Card, $player2Card);
            },
            'general' => function() use($player1Card, $player2Card) {
                return $this->checkGeneral($player1Card, $player2Card);
            },
        ];

        foreach ($checkCardList as $checkCard)
        {
            try
            {
                $card = $checkCard();

                if ($card === null)
                {
                    continue;
                }

                return $this->computeRoundResult($player1Card, $player2Card, $card);
            }
            catch(RoundOnHoldException $e)
            {
                return new RoundOnHold();
            }
            catch(NoResultException $e)
            {
                return new NoResult();
            }
            catch(PrincesseWinGameException $e)
            {
                if ($player1Card->getLabel() === Card::PRINCESSE)
                {
                    throw new Player1WinGameException();
                }

                throw new Player2WinGameException();
            }
        }
    }

    private function computeRoundResult(Card $player1Card, Card $player2Card, string $cardLabel): RoundResult
    {
        if ($player1Card->getLabel() === $cardLabel)
        {
            return new Player1Win();
        }

        if ($player2Card->getLabel() === $cardLabel)
        {
            return new Player2Win();
        }

        return new RoundOnHold();
    }

    private function checkMusicien(Card $player1Card, Card $player2Card): ?string
    {
        if(! $this->isMusicien($player1Card, $player2Card))
        {
            return null;
        }

        if($this->isMagicien($player1Card, $player2Card))
        {
            return Card::MAGICIEN;
        }

        throw new RoundOnHoldException('Round on hold');
    }

    private function checkPrincesse(Card $player1Card, Card $player2Card): ?string
    {
        if(! $this->isPrincesse($player1Card, $player2Card))
        {
            return null;
        }

        if($this->isPrince($player1Card, $player2Card))
        {
            throw new PrincesseWinGameException();
        }

        throw new NoResultException();
    }

    private function checkEspion(Card $player1Card, Card $player2Card): ?string
    {
        if(! $this->isEspion($player1Card, $player2Card))
        {
            return null;
        }

        throw new NoResultException();
    }

    private function checkAssassin(Card $player1Card, Card $player2Card): ?string
    {
        if(! $this->isAssassin($player1Card, $player2Card))
        {
            return null;
        }

        if ($this->isPrince($player1Card, $player2Card))
        {
            return Card::PRINCE;
        }

        if ($this->isMagicien($player1Card, $player2Card))
        {
            return Card::MAGICIEN;
        }

        throw new NoResultException();
    }

    private function checkMagicien(Card $player1Card, Card $player2Card): ?string
    {
        if(! $this->isMagicien($player1Card, $player2Card))
        {
            return null;
        }

        throw new NoResultException();
    }

    private function checkPrince(Card $player1Card, Card $player2Card): ?string
    {
        if (! $this->isPrince($player1Card, $player2Card))
        {
            return null;
        }

        throw new NoResultException();
    }

    private function checkEmbassadeur(Card $player1Card, Card $player2Card): ?string
    {
        if (! $this->isEmbassadeur($player1Card, $player2Card))
        {
            return null;
        }

        throw new NoResultException();
    }

    private function checkGeneral(Card $player1Card, Card $player2Card): ?string
    {
        if (! $this->isGeneral($player1Card, $player2Card))
        {
            return null;
        }

        throw new NoResultException();
    }

    private function isMagicien(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::MAGICIEN || $player2Card->getLabel() === Card::MAGICIEN;
    }

    private function isMusicien(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::MUSICIEN || $player2Card->getLabel() === Card::MUSICIEN;   
    }

    private function isPrincesse(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::PRINCESSE || $player2Card->getLabel() === Card::PRINCESSE;   
    }

    private function isPrince(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::PRINCE || $player2Card->getLabel() === Card::PRINCE;   
    }

    private function isEspion(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::ESPION || $player2Card->getLabel() === Card::ESPION;
    }

    private function isAssassin(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::ASSASSIN || $player2Card->getLabel() === Card::ASSASSIN;
    }

    private function isEmbassadeur(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::EMBASSADEUR || $player2Card->getLabel() === Card::EMBASSADEUR;
    }

    private function isGeneral(Card $player1Card, Card $player2Card): bool
    {
        return $player1Card->getLabel() === Card::GENERAL || $player2Card->getLabel() === Card::GENERAL;
    }

}