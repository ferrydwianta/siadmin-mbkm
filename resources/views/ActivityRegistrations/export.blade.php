<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tahun Ajaran</th>
            <th>Semester</th>
            <th>Jenis Aktivitas</th>
            <th>Mitra MBKM</th>
            <th>Judul Aktivitas</th>
            <th>Jenis Anggota</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Status</th>
            <th>Didaftarkan Pada</th>
            <th>Kode MK</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Nilai Angka</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $registration)
            @if ($registration->conversions->isNotEmpty())
                @foreach ($registration->conversions as $key => $conversion)
                    <tr>
                        @if ($key === 0)
                            {{-- Main row data (only shown once per ActivityRegistration) --}}
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->academicYear->name }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->academicYear->semester }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->activity->type }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->activity->partner->name }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->activity->name }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->member_type }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->student->student_number }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->student->user->name }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ $registration->status }}</td>
                            <td rowspan="{{ $registration->conversions->count() }}">{{ \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y') }}</td>
                        @endif
                        {{-- Conversion data (repeats for each conversion) --}}
                        <td>{{ $conversion->course->code }}</td>
                        <td>{{ $conversion->course->name }}</td>
                        <td>{{ $conversion->course->credit }}</td>
                        <td>{{ $conversion->grade }}</td>
                    </tr>
                @endforeach
            @else
                {{-- If no conversions, show one row with empty conversion columns --}}
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->academicYear->name }}</td>
                    <td>{{ $registration->academicYear->semester }}</td>
                    <td>{{ $registration->activity->type }}</td>
                    <td>{{ $registration->activity->partner->name }}</td>
                    <td>{{ $registration->activity->name }}</td>
                    <td>{{ $registration->member_type }}</td>
                    <td>{{ $registration->student->student_number }}</td>
                    <td>{{ $registration->student->user->name }}</td>
                    <td>{{ $registration->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y') }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>