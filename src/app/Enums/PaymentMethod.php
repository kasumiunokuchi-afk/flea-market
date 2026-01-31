<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case CONVENIENCE_STORE = 1; // 良好
    case CARD = 2;      // 目立った傷や汚れなし

    // 表示名を返す
    public function label(): string
    {
        return match ($this) {
            self::CONVENIENCE_STORE => 'コンビニ払い',
            self::CARD => 'カード支払い',
        };
    }

}