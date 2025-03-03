import { Button } from '@/Components/ui/button';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import { formatDateIndo } from '@/lib/utils';
import { IconDownload, IconEye } from '@tabler/icons-react';

export function Detail({ activityRegistration }) {
    return (
        <Sheet className="m-4">
            <SheetTrigger asChild>
                <Button variant="purple" size="sm">
                    <IconEye className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent side="right" className="overflow-y-auto">
                <SheetHeader>
                    <SheetTitle className="font-bold">Detail Pendaftaran Kegiatan MBKM</SheetTitle>
                    <SheetDescription>
                        Informasi mengenai pendaftaran kegiatan MBKM oleh {activityRegistration.student.user.name}
                    </SheetDescription>
                </SheetHeader>

                <div className="mt-8 flex flex-col gap-1">
                    <h3 className="text-md font-semibold">{activityRegistration.activity.name}</h3>
                    <p className="text-sm">{activityRegistration.activity.partner.name}</p>

                    <h3 className="text-md mt-4 font-semibold">Jenis Anggota</h3>
                    <p className="text-sm">{activityRegistration.memberType}</p>

                    <h3 className="text-md mt-4 font-semibold">Jadwal Ujian</h3>
                    {activityRegistration.schedule ? (
                        <span className="text-sm">
                            {formatDateIndo(activityRegistration.schedule.date)},{' '}
                            {activityRegistration.schedule.start_time} - {activityRegistration.schedule.end_time}
                        </span>
                    ) : (
                        <span className="text-sm italic text-gray-400">Belum ada jadwal</span>
                    )}

                    {activityRegistration.document && (
                        <>
                            <h3 className="text-md mt-4 font-semibold">Laporan Akhir</h3>
                            <Button variant="blue" size="sm" className="w-32" asChild>
                                <a href={activityRegistration.document} download>
                                    <IconDownload className="size-4" />
                                    Document
                                </a>
                            </Button>
                        </>
                    )}

                    <h3 className="text-md mt-4 font-semibold">Konversi SKS</h3>
                    {activityRegistration.conversions.length === 0 ? (
                        <>
                            <p className="text-sm italic text-gray-400">
                                Tidak ada konversi mata kuliah yang diambil mahasiswa
                            </p>
                        </>
                    ) : (
                        <>
                            <Table className="w-full">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>#</TableHead>
                                        <TableHead>Mata Kuliah</TableHead>
                                        <TableHead>Jumlah SKS</TableHead>
                                        <TableHead>Nilai</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {activityRegistration.conversions.map((conversion, index) => (
                                        <TableRow key={index}>
                                            <TableCell>{index + 1}</TableCell>
                                            <TableCell>{conversion.course.name}</TableCell>
                                            <TableCell>{conversion.course.credit} SKS</TableCell>
                                            <TableCell>
                                                {conversion.grade ? (
                                                    <span className="font-medium text-green-600">
                                                        {conversion.grade}
                                                    </span>
                                                ) : (
                                                    <span className="italic text-gray-400">Belum ada</span>
                                                )}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </>
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
}
