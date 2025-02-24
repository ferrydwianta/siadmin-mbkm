import { Button } from "@/Components/ui/button";
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from "@/Components/ui/sheet";
import { IconBooks, IconEye } from "@tabler/icons-react";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import EmptyState from "@/Components/EmptyState";
import { formatDateIndo } from "@/lib/utils";

export function DetailLayout({ activityRegistration }) {
    return (
        <Sheet className='m-4'>
            <SheetTrigger asChild>
                <Button
                    variant='purple'
                    size='sm'
                >
                    <IconEye className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent side='right'>
                <SheetHeader>
                    <SheetTitle className='font-bold'>Detail Pendaftaran Kegiatan MBKM</SheetTitle>
                    <SheetDescription>Informasi mengenai pendaftaran kegiatan MBKM oleh {activityRegistration.student.user.name}</SheetDescription>
                </SheetHeader>

                <div className="flex flex-col gap-1 mt-8">
                    <h3 className="text-md font-semibold">{activityRegistration.activity.name}</h3>
                    <p className="text-sm">{activityRegistration.activity.partner.name}</p>

                    <h3 className="text-md font-semibold mt-4">Konversi SKS</h3>
                    {activityRegistration.conversions.length === 0 ? (
                        <>
                            <p className="text-sm italic text-gray-400">Tidak ada konversi mata kuliah yang diambil mahasiswa</p>
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
                                                    <span className="font-medium text-green-600">{conversion.grade}</span>
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

                    <h3 className="text-md font-semibold mt-4">Jadwal Ujian</h3>
                    {activityRegistration.schedule ? (
                        <span className="text-sm">{formatDateIndo(activityRegistration.schedule.date)}, {activityRegistration.schedule.start_time} - {activityRegistration.schedule.end_time}</span>
                    ) : (
                        <span className="text-sm italic text-gray-400">Belum ada jadwal</span>
                    )}
                </div>


            </SheetContent>
        </Sheet>
    )
}