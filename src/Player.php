<?php

declare(strict_types = 1);

namespace BraveRats;

class Player
{
    private
        $name,
        $hand;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->hands = new Hand();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRemainingCards(): Hand
    {
        return $this->hands;
    }
}