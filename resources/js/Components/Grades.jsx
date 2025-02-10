import { Button } from '@/Components/ui/button';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import { IconEye } from '@tabler/icons-react';

// export default function Grades({activityRegistration, activityConversions, name = null}) {
export default function Grades({ activityConversions, name = null }) {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button variant="purple" size="sm">
                    <IconEye className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent side="top">
                <SheetHeader>
                    <SheetTitle>Detail Konversi SKS Mahasiswa {name}</SheetTitle>
                    <SheetDescription>Detail konversi SKS mahasiswa</SheetDescription>
                </SheetHeader>

                <Table className="w-full border">
                    <TableHeader>
                        <TableRow>
                            <TableHead className="border">No</TableHead>
                            <TableHead className="border">Kode</TableHead>
                            <TableHead className="border">Matakuliah</TableHead>
                            <TableHead className="border">SKS</TableHead>
                            <TableHead className="border">Nilai</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        {activityConversions.map((conversion, index) => (
                            <TableRow key={index}>
                                <TableCell className="border">{index + 1}</TableCell>
                                <TableCell className="border">{conversion.course.code}</TableCell>
                                <TableCell className="border">{conversion.course.name}</TableCell>
                                <TableCell className="border">{conversion.course.credit}</TableCell>
                                <TableCell className="border">{conversion.grade}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>

                    {/* <TableFooter className='font-bold'>
                        <TableRow>
                            <TableCell colSpan='4'>IP rata-rata</TableCell>
                            <TableCell className='border'>{activityRegistration.grade}</TableCell>
                        </TableRow>
                    </TableFooter> */}
                </Table>
            </SheetContent>
        </Sheet>
    );
}
