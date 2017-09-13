<?php

declare(strict_types = 1);

namespace BraveRats;

use BraveRats\Round;

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

    public function getPenultiemRound(Round $round)
    {
        if(count($this->rounds) > 1)
        {
            $index = 0;

            foreach ($this->rounds as $currentRound)
            {
                if ($currentRound === $round && $index != 0)
                {
                    return $this->rounds[$index - 1];
                }

                $index++;
            }
        }

        return null;
    }
}