<?php

declare(strict_types = 1);

namespace BraveRats;

class GameResult
{
    public
        $player1WonRounds,
        $player2WonRounds,
        $roundNumber;

    public function __construct()
    {
        $this->player1WonRounds = 0;
        $this->player2WonRounds = 0;
        $this->roundNumber = 0;
    }

    public function isGameEnded(): bool
    {
        return $this->player1WonRounds === 4 || $this->player2WonRounds === 4 || $this->roundNumber === 8;
    }

    public function getWiningPlayer(): ?string
    {
        if($this->player1WonRounds === 4)
        {
            return 'Yargs';
        }
        if($this->player2WonRounds === 4)
        {
            return 'Applewoods';
        }

        return null;
    }
}