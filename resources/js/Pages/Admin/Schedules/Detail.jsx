import { Button } from '@/Components/ui/button';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import { formatDateIndo } from '@/lib/utils';
import { IconEye } from '@tabler/icons-react';

export function Detail({ schedule }) {
    return (
        <Sheet className="m-4">
            <SheetTrigger asChild>
                <Button variant="purple" size="sm">
                    <IconEye className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent side="right">
                <SheetHeader>
                    <SheetTitle className="font-bold">Detail Jadwal Ujian</SheetTitle>
                    <SheetDescription>
                        Daftar semua mahasiswa yang mengikuti ujian pada jadwal berikut.
                    </SheetDescription>
                </SheetHeader>

                <div className="mt-4 flex flex-col gap-1">
                    <h3 className="text-md mt-4 font-semibold">Jadwal</h3>
                    <p className="text-sm">{formatDateIndo(schedule.date)}</p>
                    <p className="text-sm">
                        Jam {schedule.start_time} - {schedule.end_time}
                    </p>

                    <h3 className="text-md mt-4 font-semibold">Daftar Mahasiswa</h3>
                    {schedule.activityRegistrations.length === 0 ? (
                        <>
                            <p className="text-sm italic text-gray-400">
                                Tidak ada mahasiswa terdaftar pada jadwal ini
                            </p>
                        </>
                    ) : (
                        <>
                            <Table className="w-full">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>#</TableHead>
                                        <TableHead>Mahasiswa</TableHead>
                                        <TableHead>Kegiatan</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {schedule.activityRegistrations.map((registration, index) => (
                                        <TableRow key={index}>
                                            <TableCell>{index + 1}.</TableCell>
                                            <TableCell>
                                                {registration.student.user.name} ({registration.student.student_number})
                                            </TableCell>
                                            <TableCell>{registration.activity.name}</TableCell>
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
