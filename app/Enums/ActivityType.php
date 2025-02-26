<?php

namespace App\Enums;

enum ActivityType: string {
    case INTERN = 'Magang atau Kerja Praktek';
    case VILLAGE = 'Proyek di Desa';
    case TEACHING = 'Mengajar Di Sekolah';
    case EXCHANGE = 'Pertukaran Pelajar';
    case RESEARCH = 'Penelitian/Riset';
    case ENTREPRENEUR = 'Kegiatan Wirausaha';
    case STUDY = 'Study atau Proyek Independen';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->value,
        ])->values()->toArray();
    }
}