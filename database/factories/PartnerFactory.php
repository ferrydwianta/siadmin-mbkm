<?php

namespace Database\Factories;

use App\Enums\ActivityType;
use App\Enums\StudentStatus;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define structured data
        $records = [
            [
                'name' => 'Bank CIMB Niaga',
                'slug' => str()->slug('Bank CIMB Niaga'),
                'description' => 'Dukungan 476 jaringan kantor cabang konvensional & syariah di seluruh Indonesia & lebih dari 12.000 karyawan siap memberikan layanan perbankan terpadu',
                'address' => 'Graha CIMB Niaga. Jl. Jend. Sudirman No.Kav 58, RT.5/RW.3, Senayan, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12190',
                'contact' => '6281349583342',
            ],
            [
                'name' => 'PT Kalman Group Indonesia',
                'slug' => str()->slug('PT Kalman Group Indonesia'),
                'description' => 'KALMAN merupakan Perusahaan Marketing Agency pertama yang berdiri di bali pada tahun 2007 hingga saat ini.',
                'address' => 'Jalan Raya Padang Luwih No.8 Ruko-10, Kec. Kuta Utara, Badung, Bali, 80361',
                'contact' => '6281254435339',
            ],
            [
                'name' => 'OPPO INDONESIA MANUFACTURING',
                'slug' => str()->slug('OPPO INDONESIA MANUFACTURING'),
                'description' => 'PT. Bright Mobile Telecommunication (BMT) is the Manufacturing Center of OPPO Indonesia that located at Kawasan Industri Bayur, Tangerang.',
                'address' => 'Jalan Kawasan Industri Jl. Raya Bayur, Periuk Jaya, Kec. Periuk, Kota Tangerang, Banten 15131',
                'contact' => '6281369482829',
            ],
        ];

        return $this->faker->randomElement($records);
    }

    public function configure()
    {
        return $this->afterCreating(function ($partner) {
            $activities = match ($partner->name) {
                'Bank CIMB Niaga' => [
                    [
                        'name' => $name = 'UI UX Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'UI UX Intern
                            Mahasiswa akan mensupport team project member Arjuna 4.0 Stage 3 untuk pembuatan mock up & design UI/UX.
                            Requirement:
                            Dapat menggunakan aplikasi UI UX Design, seperti: Figma, Prototyping
                            Preferably seseorang yang memahami flow penggunaan aplikasi, best practices in UI UX Design, Application Design & Alur Proses
                            Dapat bekerja secara WFO selama periode magang
                            Preferably sudah lulus/semester akhir
                            Kompetensi yang akan dikembangkan
                            Pemahaman Teknologi Informasi
                            Manajemen Proyek
                            Kreativitas
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 7
                            Program studi yang diutamakan:
                            Teknik Informatika dan Ilmu Komputer
                            Lainnya'
                    ],
                    [
                        'name' => $name = 'Operations Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Mahasiswa akan mendapatkan real-assignment dalam menganalisa pekerjaan2 yang dilakukan oleh karyawan Operations dan mengolah data hasil analisa tersebut. 
                            Requirement:
                            Dapat bekerja secara full-time dan WFO pada periode waktu yang ditentukan
                            Mahir menggunakan Microsoft Excel 
                            Kompetensi yang akan dikembangkan
                            Administrasi
                            Keterampilan Komunikasi
                            Analisis Data
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 5
                            Terbuka untuk semua program studi.'
                    ],
                    [
                        'name' => $name = 'Cyber Security Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Cyber Security Intern
                            Requirement:
                            Dapat bekerja secara WFO sesuai dengan waktu yang ditentukan
                            Preferably seseorang yang telah berada pada semester akhir/hanya menunggu skripsi
                            Preferably dari jurusan Teknik Informasi, Computer Science dan sebagainya.
                            Kompetensi yang akan dikembangkan
                            Keterampilan Komunikasi
                            Keahlian Teknologi
                            Kerjasama Tim
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 7
                            Terbuka untuk semua program studi.'
                    ],
                    [
                        'name' => $name = 'Conten Creator, Graphic Design and Event Partnership',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Conten Creator, Graphic Design and Event Partnership
                            Melalui program internship ini, mahasiswa akan belajar merancang dan membuat konten Instagram, termasuk video dan carousel, serta berkontribusi dalam perencanaan dan pelaksanaan event eksternal maupun internal dalam ranah Talent Partnership. Selain itu, mereka juga akan membantu dalam pengolahan data pelamar, analisis data, serta pembuatan presentasi, memberikan pengalaman langsung dalam lingkungan kerja profesional.

                            Requirement:
                            Dapat bekerja secara fulltime dan WFO sesuai periode waktu yang ditentukan
                            Memiliki pengalaman menggunakan Canva/Adobe (Photosop maupun AI)
                            Memiliki keterampilan dalam membuat konten sosial media (Instagram/TikTok)
                            dan/ atau
                            Mahir menggunakan Microsoft Powerpoint dan Microsoft Excel
                            Mampu membantu pelaksanaan event
                            Kompetensi yang akan dikembangkan
                            Kreativitas
                            Keterampilan Komunikasi
                            Desain Grafis
                            Manajemen Proyek
                            Problem Solving
                            Kerjasama Tim
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 5
                            Terbuka untuk semua program studi.'
                    ],
                ],
                'PT Kalman Group Indonesia' => [
                    [
                        'name' => $name = 'Design Graphic Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Design Graphic Intern
                            Hi, Amazing Designers!

                            KALMAN Marketing Agency is currently seeking a creative and innovative Graphic Designer Intern. You will work closely with the marketing team and actively participate in all marketing activations for our clients.

                            What will you do?
                            Assist the senior graphic designer in creating online marketing content.
                            Develop offline marketing content (such as event materials, posters, merchandise, etc.).
                            Collaborate with the team on various marketing activities that require creativity and design skills.
                            What do you need to have?
                            An undergraduate student in graphic design, visual communication design, or a related field.
                            A strong passion for working as a graphic designer in a growing creative agency.
                            Proficiency in Adobe Illustrator, Premiere, and Adobe Photoshop (required).
                            Photography and video editing skills are a plus.
                            Willingness to work collaboratively and grow together as part of a team, rather than working solely as an individual.
                            Good attitude, humility, and open-mindedness.

                            Willing to be placed in the Bali Office (WORK FROM OFFICE).

                            We look forward to welcoming you!
                            Kompetensi yang akan dikembangkan
                            Komunikasi
                            Kreatif
                            Editing
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 6
                            Terbuka untuk semua program studi.'
                    ],
                    [
                        'name' => $name = 'Social Media Specialist Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Job Description:
                            Provide innovative suggestions to the graphic designer, account coordinator, KOL campaign specialists, and production team for crafting engaging content.
                            Assist in overseeing the management of social media profiles.
                            Formulate and execute a social media strategy tailored for Instagram, TikTok, following thorough research on platform dynamics, communication tone, and target audience.
                            Generate, publish, and distribute fresh content (including images, videos, and captions) on a daily basis.
                            Collect and analyse relevant social media metrics, reports, and insights to evaluate the effectiveness of each social media campaign.

                            Kualifikasi:
                            Currently in the final year of studies (with no classes to attend) or a recent graduate from any major.
                            Proficient in various social media platforms.
                            Preferably familiar with MetaAds.
                            Comfortable and self-assured when appearing on camera.
                            Basic skills in social media design, editing, and copywriting.
                            Must possess a sharp attention to detail and analytical mindset.
                            Open to working onsite in Bali.
                            Required to use personal device(s) for work purposes.

                            Willing to be placed in the Bali Office (WORK FROM OFFICE).
                            Kompetensi yang akan dikembangkan
                            Komunikasi
                            Administrasi
                            Teliti
                            Manajemen Waktu
                            Manajemen Proyek
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 6
                            Terbuka untuk semua program studi.'
                    ],
                    [
                        'name' => $name = 'Business Development Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Job Description:
                            Melakukan riset dan mengidentifikasi klien potensial di industri dan posisi target.
                            Menghubungi calon klien melalui cold calling, email, dan jaringan untuk memperkenalkan layanan kami.
                            Memahami kebutuhan perekrutan klien dan membantu seluruh proses keterlibatan klien, mulai dari kontak awal hingga penempatan.
                            Mencari peluang pelanggan baru dan menjaga hubungan antara pelanggan atau klien.
                            Berkolaborasi dengan divisi lain untuk memenuhi kebutuhan pasar atau klien.
                            Menyusun dan menyajikan rencana pengembangan bisnis perusahaan.
                            Mendukung dalam pembuatan strategi kampanye.
                            Melakukan riset perkembangan bisnis perusahaan secara berkala.
                            Memahami produk perusahaan, pesaing, dan posisi bisnis di pasar.

                            Kualifikasi:
                            Sedang menempuh pendidikan di bidang bisnis, pemasaran, atau bidang terkait.
                            Minat yang kuat dalam pengembangan bisnis dan penjualan.
                            Kemampuan komunikasi yang baik dan percaya diri dalam berinteraksi dengan orang baru.
                            Kemampuan untuk bekerja secara efektif dalam tim.
                            Sikap proaktif dengan kemauan untuk belajar dan berkontribusi.
                            Menguasai Microsoft Office.
                            Pengetahuan tentang strategi pemasaran dan pengembangan bisnis akan menjadi nilai tambah.

                            Bersedia ditempatkan di kantor Bali (WORK FROM OFFICE).
                            Kompetensi yang akan dikembangkan
                            Administrasi
                            Komunikasi
                            Operasional
                            Pengembangan Strategi
                            Pemahaman Lingkungan Bisnis
                            Analisis Persaingan
                            Pemahaman Teknologi Informasi
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 6
                            Terbuka untuk semua program studi.'
                    ],
                ],
                'OPPO INDONESIA MANUFACTURING' => [
                    [
                        'name' => $name = 'Augmented Reality (AR) Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Deskripsi Pekerjaan:
                            Mengembangkan dan mengimplementasikan fitur AR untuk aplikasi atau proyek yang sedang berjalan.
                            Melakukan riset dan eksplorasi teknologi AR terbaru untuk meningkatkan pengalaman pengguna.
                            Bekerja sama dengan tim desain dan pengembang untuk menciptakan interaksi AR yang inovatif.
                            Menguji dan melakukan debugging untuk memastikan performa aplikasi yang optimal.
                            Kualifikasi:
                            Mahasiswa aktif dari jurusan Teknik Informatika, Desain Multimedia, atau bidang terkait.
                            Memiliki pengalaman atau pemahaman dasar tentang teknologi AR (Unity, ARKit, ARCore, Vuforia, dsb.).
                            Mampu menggunakan bahasa pemrograman seperti C#, Python, atau JavaScript.
                            Memiliki kemampuan problem-solving dan kerja tim yang baik.
                            Nilai tambah jika memiliki pengalaman dalam 3D modeling atau animasi.
                            Kompetensi yang akan dikembangkan
                            Pengembangan Teknologi AR
                            Kolaborasi dan Manajemen Proyek
                            Pengembangan Aplikasi dan Software
                            Kriteria Akademik
                            Mahasiswa perguruan tinggi aktif minimal semester 6
                            Program studi yang diutamakan:
                            Seni dan Desain
                            Teknik Informatika dan Ilmu Komputer'
                    ],
                    [
                        'name' => $name = 'Data Analyst Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'About the Internship:
                            Join OPPO Indonesia’s Factory Preparation Project as the company moves towards National Industry 4.0 Lighthouse status. This 3-month internship offers hands-on experience in designing integrated systems, implementing clean databases, analyzing dashboard systems, and leveraging Big Data for data synchronization.

                            Responsibilities:
                            Design and analyze data systems using Power BI
                            Work with clean databases for efficient data management
                            Analyze dashboards and synchronize data using Big Data
                            Learn data forecasting and its real-world applications
                            Gain exposure to ERP systems, digital 5S assessment, and production management
                            Participate in industry-focused training and projects

                            Mentors:
                            Alvin Chandra (Production Engineer)
                            Yogi Sastra Dinata (Production Assistant Engineer)
                            Juliana Simatupang (Production Administration)
                            Required Skills:
                            Microsoft Excel & PowerPoint
                            Power BI & Data Analysis
                            Strong Analytical Thinking
                            Interest in Manufacturing & Industry 4.0

                            Why Join Us?
                            Hands-on training with industry professionals
                            Real-world experience in a leading smart factory environment
                            Opportunity to develop and showcase data analysis skills'
                    ],
                    [
                        'name' => $name = 'Mechatronic Engineer Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'Requirements: 
                            Enrolled in Mechanical, Automation, or Mechatronics Engineering.
                            Basic knowledge of PLCs, sensors, and automation tools (e.g., AGVs, RGVs).
                            Proficiency in CAD software (e.g., AutoCAD, SolidWorks).
                            Basic programming skills (Python, C++, or ladder logic).
                            Strong problem-solving and communication skills.
                            Whatll you doAssist in designing and maintaining automation systems.
                            Program and test PLCs and automation equipment.
                            Create and update mechanical layouts using CAD tools.
                            Analyze system performance and optimize processes.
                            Document procedures and support production teams.'
                    ],
                    [
                        'name' => $name = 'Legal Intern',
                        'slug' => str()->slug($name),
                        'type' => ActivityType::INTERN,
                        'status' => StudentStatus::APPROVED,
                        'description' => 'What You Will Learn:
                            Orientation & Introduction to the Legal Department – Understanding corporate structure, legal documentation systems, and legal tools used in the company.
                            Legal Research & Case Analysis – Conducting research on relevant regulations and analyzing legal cases handled by the company.
                            Legal Document Drafting – Assisting in contract drafting, document review, and negotiation simulations.
                            Legal Implementation & Compliance – Supporting compliance audits and consulting on legal matters with other departments.
                            Final Evaluation & Project – Preparing a final report and presenting internship findings to the legal team.
                            Qualifications:
                            Final-year law student or recent graduate.
                            Strong interest in corporate law, regulations, and compliance.
                            Critical thinking, analytical skills, and strong communication abilities.
                            Proactive, detail-oriented, and able to work in a team.
                            Benefits:
                            Hands-on experience in a professional legal environment.
                            Mentorship from the corporate legal team.
                            Internship certificate upon program completion.
                            '
                    ],
                ],
                default => [],
            };

            foreach ($activities as $activityData) {
                $activity = $partner->activities()->create([
                    'name' => $activityData['name'],
                    'slug' => $activityData['slug'],
                    'type' => $activityData['type'],
                    'status' => $activityData['status'],
                    'description' => $activityData['description'],
                ]);

                $courses = Course::inRandomOrder()->limit(rand(1, 5))->pluck('id');

                $activity->courses()->attach($courses);
            }
        });
    }
}
