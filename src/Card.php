<?php

declare(strict_types = 1);

namespace BraveRats;

final class Card
{
    private
        $label,
        $value,
        $capacity;

    const
        PRINCE = 'Prince',
        GENERAL = 'Général',
        MAGICIEN = 'Magicien',
        EMBASSADEUR = 'Embassadeur',
        ASSASSIN = 'Assassin',
        ESPION = 'Espion',
        PRINCESSE = 'Princesse',
        MUSICIEN = 'Musicien';

    private function __construct(string $label, int $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public static function fromLabel(string $label)
    {
        $cards = [
            self::PRINCE => self::prince(),
            self::GENERAL => self::general(),
            self::MAGICIEN => self::magicien(),
            self::EMBASSADEUR => self::embassadeur(),
            self::ASSASSIN => self::assassin(),
            self::ESPION => self::espion(),
            self::PRINCESSE => self::princesse(),
            self::MUSICIEN => self::musicien(),
        ];

        if(! array_key_exists($label, $cards))
        {
            throw new \InvalidArgumentException('Card with label ' . $label . ' cannot be found');
        }
        
        return $cards[$label];
    }

    public static  function prince()
    {
        return new self(self::PRINCE, 7);
    }

    public static  function general()
    {
        return new self(self::GENERAL, 6);
    }

    public static  function magicien()
    {
        return new self(self::MAGICIEN, 5);
    }

    public static  function embassadeur()
    {
        return new self(self::EMBASSADEUR, 4);
    }

    public static  function assassin()
    {
        return new self(self::ASSASSIN, 3);
    }

    public static  function espion()
    {
        return new self(self::ESPION, 2);
    }

    public static  function princesse()
    {
        return new self(self::PRINCESSE, 1);
    }

    public static  function musicien()
    {
        return new self(self::MUSICIEN, 0);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isMusicien()
    {
        return $this->label === self::MUSICIEN;
    }

    public function isMagicien()
    {
        return $this->label === self::MAGICIEN;
    }

    public function isEmbassadeur()
    {
        return $this->label === self::EMBASSADEUR;
    }

    public function isGeneral()
    {
        return $this->label === self::GENERAL;
    }
}