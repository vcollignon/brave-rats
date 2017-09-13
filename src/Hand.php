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
            Card::MUSICIEN => Card::musicien(),
            Card::PRINCESSE => Card::princesse(),
            Card::ESPION => Card::espion(),
            Card::ASSASSIN => Card::assassin(),
            Card::EMBASSADEUR => Card::embassadeur(),
            Card::MAGICIEN => Card::magicien(),
            Card::GENERAL => Card::general(),
            Card::PRINCE => Card::prince(),
        ];
    }

    public function toLabelArray(): array
    {
        $cardList = [];

        foreach ($this->cards as $card)
        {
            $cardList[$card->getValue()] = $card->getLabel();
        }

        return $cardList;
    }

    public function removeCard(Card $card): void
    {
        if(! array_key_exists($card->getLabel(), $this->cards))
        {
            throw new \InvalidArgumentException('Card with label ' . $label . ' cannot be found');
        }

        unset($this->cards[$card->getLabel()]);
    }
}