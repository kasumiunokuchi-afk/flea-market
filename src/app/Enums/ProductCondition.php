<?php

namespace App\Enums;

enum ProductCondition: int
{
    case VERY_GOOD = 1; // 良好
    case GOOD = 2;      // 目立った傷や汚れなし
    case BAD = 3;       // やや傷や汚れあり
    case VERY_BAD = 4;  // 状態が悪い

    // 表示名を返す
    public function label(): string
    {
        return match ($this) {
            self::VERY_GOOD => '良好',
            self::GOOD => '目立った傷や汚れなし',
            self::BAD => 'やや傷や汚れあり',
            self::VERY_BAD => '状態が悪い',
        };
    }

}