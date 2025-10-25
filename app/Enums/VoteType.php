<?php

namespace App\Enums;

enum VoteType: int
{
    case Unknown = 0;
    case AcceptedByOriginator = 1;
    case UpVote = 2;
    case DownVote = 3;
    case Offensive = 4;
    case Favorite = 5;
    case Close = 6;
    case Reopen = 7;
    case BountyStart = 8;
    case BountyClose = 9;
    case Deletion = 10;
    case Undeletion = 11;
    case Spam = 12;
    case InformModerator = 13;

    public static function fromValue(int $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
