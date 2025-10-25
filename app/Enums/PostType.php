<?php

namespace App\Enums;

enum PostType: int
{
    case Unknown = 0;
    case Question = 1;
    case Answer = 2;

    public static function fromValue(int $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
