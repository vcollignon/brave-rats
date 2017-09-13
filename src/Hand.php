<?php

declare(strict_types = 1);

namespace BraveRats;

class Hand
{
    private
        $cards;

    public function __construct()
    {
        $this->cards = [
            Card::prince(),
            Card::general(),
            Card::magicien(),
            Card::embassadeur(),
            Card::assassin(),
            Card::espion(),
            Card::princesse(),
            Card::musicien(),
        ];
    }

    public function toLabelArray(): array
    {
        $cardList = [];

        foreach ($this->cards as $card)
        {
            $cardList[] = $card->getLabel();
        }

        return $cardList;
    }
}