<?php

namespace App\Enums;

enum PostHistoryType: int
{
    case Unknown = 0;
    case InitialTitle = 1;
    case InitialBody = 2;
    case InitialTags = 3;
    case EditTitle = 4;
    case EditBody = 5;
    case EditTags = 6;
    case RollbackTitle = 7;
    case RollbackBody = 8;
    case RollbackTags = 9;
    case PostClosed = 10;
    case PostReopened = 11;
    case PostDeleted = 12;
    case PostUndeleted = 13;
    case PostLocked = 14;
    case PostUnlocked = 15;
    case CommunityOwned = 16;
    case PostMigrated = 17;
    case QuestionMerged = 18;
    case QuestionProtected = 19;
    case QuestionUnprotected = 20;
    case PostDisassociated = 21;
    case QuestionUnmerged = 22;

    public static function fromValue(int $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
