<?php

declare(strict_types = 1);

namespace BraveRats;

class RoundHistory implements \IteratorAggregate
{
    private
        $rounds;

    public function addRound(Round $round): RoundHistory
    {
        $this->rounds[] = $round;

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->rounds);
    }
}