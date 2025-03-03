<?php

namespace App\Exports;

use App\Enums\StudentStatus;
use App\Models\ActivityRegistration;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityRegistrationExport implements FromView, WithStyles, WithColumnWidths
{

    protected $academicYearId;

    public function __construct($academicYearId)
    {
        $this->academicYearId = $academicYearId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $activityRegistrations = ActivityRegistration::query()
            ->select(['activity_registrations.id', 'activity_registrations.student_id', 'activity_registrations.academic_year_id', 'activity_registrations.status', 'activity_registrations.member_type', 'activity_registrations.created_at', 'activity_registrations.activity_id', 'activity_registrations.notes', 'activity_registrations.schedule_id'])
            ->where('academic_year_id', $this->academicYearId)
            ->where('status', StudentStatus::APPROVED)
            ->with(['academicYear', 'activity', 'schedule', 'conversions', 'conversions.course', 'student', 'student.user'])
            ->latest('created_at')
            ->get();
        return view('ActivityRegistrations.export', ['data' => $activityRegistrations]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'D3D3D3'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'A:O' => [
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 15,  // Tahun Ajaran
            'C' => 10,  // Semester
            'D' => 20,  // Jenis Aktivitas
            'E' => 20,  // Mitra MBKM
            'F' => 25,  // Judul Aktivitas
            'G' => 15,  // Jenis Anggota
            'H' => 15,  // NIM
            'I' => 20,  // Nama Mahasiswa
            'J' => 15,  // Status
            'K' => 15,  // Didaftarkan Pada
            'L' => 15,  // Kode Mata Kuliah
            'M' => 25,  // Nama Mata Kuliah
            'N' => 10,  // SKS
            'O' => 10,  // Nilai
        ];
    }
}
