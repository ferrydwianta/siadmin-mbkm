<?php

namespace App\Enums;

enum StudentStatus: string {
    case PENDING = 'Pending';
    case APPROVED = 'Approve';
    case REJECT = 'Reject';

    public function message(string $entity = '', ?string $error = null) 
    {
        if($this == MessageType::ERROR && $error) {
            return "{$this->value} {$error}";
        }
        return  "{$this->value} {$entity}";
    }

    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->value,
        ])->values()->toArray();
    }
}