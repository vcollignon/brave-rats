<?php

declare(strict_types = 1);

namespace BraveRats\RoundResults;

use BraveRats\Card;
use BraveRats\RoundResult;

class Player2Win implements RoundResult
{
    private
        $winingCard;

    public function __construct(Card $winingCard)
    {
        $this->winingCard = $winingCard;
    }

    public function isEmbassadeur(): bool
    {
        return $this->winingCard->isEmbassadeur();
    }
}