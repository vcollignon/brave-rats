<?php

declare(strict_types = 1);

namespace BraveRats;

final class Card
{
    private
        $label,
        $value,
        $capacity;

    private function __construct(string $label, int $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public static function fromLabel(string $label)
    {
        $cards = [
            'prince' => self::prince(),
            'general' => self::general(),
            'magicien' => self::magicien(),
            'embassadeur' => self::embassadeur(),
            'assassing' => self::assassin(),
            'espion' => self::espion(),
            'princesse' => self::princesse(),
            'musicien' => self::musicien(),
        ];

        if(! array_key_exists($label, $cards))
        {
            throw new \InvalidArgumentException('Card with label ' . $label . ' cannot be found');
        }
        
        return $cards[$label];
    }

    public static  function prince()
    {
        return new self('Prince', 7);
    }

    public static  function general()
    {
        return new self('General', 6);
    }

    public static  function magicien()
    {
        return new self('Magicien', 5);
    }

    public static  function embassadeur()
    {
        return new self('Embassadeur', 4);
    }

    public static  function assassin()
    {
        return new self('Assassin', 3);
    }

    public static  function espion()
    {
        return new self('Espion', 2);
    }

    public static  function princesse()
    {
        return new self('Princesse', 1);
    }

    public static  function musicien()
    {
        return new self('Musicien', 0);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}