<?php

namespace App\Enum;

enum BookStatus: string
{
    case Available = 'available';
    case Borrowed = 'borrowed';
    case Unavailable = 'unavailable';

    public function getLabel(): string
    {
        return (string)match ($this) {
            self::Available => 'Disponible',
            self::Borrowed => 'Emprunté',
            self::Unavailable => 'Indisponible',
        };
    }

    public function toString(): string
    {
        return $this->value;
    }
}
