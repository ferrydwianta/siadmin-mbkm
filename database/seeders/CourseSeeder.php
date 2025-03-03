<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'Algoritma dan Pemrograman I', 'code' => '1241023', 'credit' => 3, 'semester' => 1],
            ['name' => 'Manajemen Basis Data', 'code' => '1241043', 'credit' => 1, 'semester' => 1],
            ['name' => 'Konsep Teknologi', 'code' => '1200012', 'credit' => 2, 'semester' => 1],
            ['name' => 'Pengantar Sistem Informasi', 'code' => '1241073', 'credit' => 3, 'semester' => 2],
            ['name' => 'Algoritma dan Pemrograman II', 'code' => '1241083', 'credit' => 3, 'semester' => 2],
            ['name' => 'Pemrograman Web', 'code' => '1241102', 'credit' => 3, 'semester' => 2],
            ['name' => 'Rekayasa Kebutuhan Perangkat Lunak', 'code' => '1242162', 'credit' => 2, 'semester' => 3],
            ['name' => 'Keamanan Aset Informasi', 'code' => '1242182', 'credit' => 2, 'semester' => 3],
            ['name' => 'Desain & Manajemen Jaringan Komputer', 'code' => '1242192', 'credit' => 2, 'semester' => 3],
            ['name' => 'Interaksi Manusia & Komputer', 'code' => '1242212', 'credit' => 2, 'semester' => 3],
            ['name' => 'Manajemen Proses Bisnis', 'code' => '1242283', 'credit' => 3, 'semester' => 4],
            ['name' => 'Rancang Bangun Perangkat Lunak', 'code' => '1242293', 'credit' => 3, 'semester' => 4],
            ['name' => 'Sistem Informasi Geografis', 'code' => '1242312', 'credit' => 2, 'semester' => 4],
            ['name' => 'Pemrograman Aplikasi Mobile', 'code' => '124210342', 'credit' => 2, 'semester' => 5],
            ['name' => 'Manajemen Hubungan Pelanggan', 'code' => '124210362', 'credit' => 2, 'semester' => 5],
            ['name' => 'Uji Kualitas Perangkat Lunak', 'code' => '124210382', 'credit' => 2, 'semester' => 5],
            ['name' => 'Desain Pengalaman Pengguna', 'code' => '124210393', 'credit' => 3, 'semester' => 5],
            ['name' => 'Teknologi Cloud Computing', 'code' => '124210683', 'credit' => 3, 'semester' => 5],
            ['name' => 'Manajemen Risiko & Kualitas TI', 'code' => '124210473', 'credit' => 3, 'semester' => 6],
            ['name' => 'Manajemen Investasi TI', 'code' => '124210453', 'credit' => 3, 'semester' => 6],
            ['name' => 'Kecerdasan Bisnis', 'code' => '124210593', 'credit' => 3, 'semester' => 7],
            ['name' => 'Forensika Digital', 'code' => '124210613', 'credit' => 3, 'semester' => 7],
            ['name' => 'Pemasaran Digital', 'code' => '1242513', 'credit' => 3, 'semester' => 7],
            ['name' => 'Sistem Informasi Akuntansi', 'code' => '1242543', 'credit' => 3, 'semester' => 7],
            ['name' => 'Data Science', 'code' => '1242573', 'credit' => 3, 'semester' => 7],
            ['name' => 'Internet Untuk Segala (IoT)', 'code' => '1242643', 'credit' => 3, 'semester' => 7],
            ['name' => 'Kriptograpi', 'code' => '1242693', 'credit' => 3, 'semester' => 7],
            
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
