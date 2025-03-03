import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { useForm } from '@inertiajs/react';
import { IconDownload, IconFileExport } from '@tabler/icons-react';
import { useState } from 'react';

export function ExportActivityRegistration({ academicYears, direction }) {
    const [isSheetOpen, setIsSheetOpen] = useState(false);
    const { data, setData, errors, setError, clearErrors } = useForm({
        academicYearId: '',
    });
    const handleExport = () => {
        if (!data.academicYearId) {
            setError('academicYear', 'Silakan pilih Tahun Ajaran.');
            return;
        }
        clearErrors();
        window.location.href = route(direction, [data.academicYearId]);
    };
    console.log('Route name:', route);

    return (
        <Sheet className="m-4" open={isSheetOpen} onOpenChange={setIsSheetOpen}>
            <SheetTrigger asChild>
                <Button variant="orange" size="xl" className="w-full lg:w-auto">
                    <IconFileExport className="size-4" />
                    Buat Laporan
                </Button>
            </SheetTrigger>

            <SheetContent side="right">
                <SheetHeader>
                    <SheetTitle className="font-bold">Laporan Pendaftaran Kegiatan MBKM</SheetTitle>
                    <SheetDescription>
                        Unduh File Spreadsheet (Excel) Laporan Pendaftaran Kegiatan MBKM
                    </SheetDescription>
                </SheetHeader>

                <div className="mt-8 flex flex-col gap-2">
                    <h3 className="text-md font-semibold">Pilih Tahun Ajaran</h3>
                    {academicYears.length === 0 ? (
                        <>
                            <p className="text-sm italic text-gray-400">Tidak ada tahun ajaran terdaftar</p>
                        </>
                    ) : (
                        <>
                            <Select
                                defaultValue={data.academicYearId}
                                onValueChange={(value) => setData('academicYearId', value)}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih tahun ajaran" />
                                </SelectTrigger>

                                <SelectContent>
                                    {academicYears.map((year, index) => (
                                        <SelectItem key={index} value={year.value}>
                                            {year.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {errors.academicYear && <InputError message={errors.academicYear} />}

                            <Button onClick={handleExport} type="submit" variant="blue" className="mt-4 w-32">
                                <IconDownload className="size-4" />
                                Download
                            </Button>
                        </>
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
}
