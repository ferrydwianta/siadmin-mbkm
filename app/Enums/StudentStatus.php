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
}