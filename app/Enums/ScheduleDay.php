<?php

namespace App\Enums;

enum ScheduleDay: string {
    case SENIN = 'Senin';
    case SELASA = 'Selasa';
    case RABU = 'Rabu';
    case KAMIS = 'Kamis';
    case JUMAT = 'Jumat';
    case SABTU = 'Sabtu';
    case MINGGU = 'Minggu';

    public function message(string $entity = '', ?string $error = null) 
    {
        if($this == MessageType::ERROR && $error) {
            return "{$this->value} {$error}";
        }
        return  "{$this->value} {$entity}";
    }
}