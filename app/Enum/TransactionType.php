<?php

namespace App\Enum;

enum TransactionType: string
{
    case CREDIT = 'c';
    case DEBIT = 'd';
    case PIX = 'p';

    /**
     * @return int
     */
    public function getTax(): int
    {
        return match ($this) {
            self::CREDIT => 5,
            self::DEBIT => 3,
            self::PIX => 0,
        };
    }
}
