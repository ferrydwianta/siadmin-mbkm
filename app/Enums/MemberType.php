<?php

namespace App\Enums;

enum MemberType: string {
    case PERSONAL = 'Personal';
    case GROUP = 'Kelompok';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->value,
        ])->values()->toArray();
    }
}