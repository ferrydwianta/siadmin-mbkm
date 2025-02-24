import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import { flashMessage, formatDateIndo, STUDENTSTATUS } from '@/lib/utils';
import { useForm } from '@inertiajs/react';
import { IconEye } from '@tabler/icons-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

export function Detail({ activityRegistration, action }) {
    const [isSheetOpen, setIsSheetOpen] = useState(false);
    const { data, setData, put, errors, processing } = useForm({
        conversions: activityRegistration.conversions.map((conversion) => ({
            id: conversion.id,
            grade: conversion.grade ?? '',
        })),
        _method: 'PUT',
    });

    const onHandleSubmit = (e) => {
        e.preventDefault();
        put(action, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (success) => {
                const flash = flashMessage(success);
                if (flash) toast[flash.type](flash.message);
                setIsSheetOpen(false);
            },
        });
    };

    // update data.conversions when activityRegistration change
    useEffect(() => {
        if (activityRegistration) {
            data.conversions = activityRegistration.conversions.map((conversion) => ({
                id: conversion.id,
                grade: conversion.grade ?? '',
            }));
        }
    }, [activityRegistration]);

    return (
        <Sheet className="m-4" open={isSheetOpen} onOpenChange={setIsSheetOpen}>
            <SheetTrigger asChild>
                <Button variant="purple" size="sm">
                    <IconEye className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent side="right">
                <SheetHeader>
                    <SheetTitle className="font-bold">Detail Pendaftaran Kegiatan MBKM</SheetTitle>
                    <SheetDescription>
                        Informasi mengenai pendaftaran kegiatan MBKM oleh {activityRegistration.student.user.name}
                    </SheetDescription>
                </SheetHeader>

                <div className="mt-8 flex flex-col gap-1">
                    <h3 className="text-md font-semibold">{activityRegistration.activity.name}</h3>
                    <p className="text-sm">{activityRegistration.activity.partner.name}</p>

                    <h3 className="text-md mt-4 font-semibold">Jadwal Ujian</h3>
                    {activityRegistration.schedule ? (
                        <span className="text-sm">
                            {formatDateIndo(activityRegistration.schedule.date)},{' '}
                            {activityRegistration.schedule.start_time} - {activityRegistration.schedule.end_time}
                        </span>
                    ) : (
                        <span className="text-sm italic text-gray-400">Belum ada jadwal</span>
                    )}

                    <h3 className="text-md mt-4 font-semibold">Konversi SKS</h3>
                    {activityRegistration.conversions.length === 0 ? (
                        <>
                            <p className="text-sm italic text-gray-400">
                                Tidak ada konversi mata kuliah yang diambil mahasiswa
                            </p>
                        </>
                    ) : (
                        <form onSubmit={onHandleSubmit}>
                            <Table className="w-full">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>#</TableHead>
                                        <TableHead>Mata Kuliah</TableHead>
                                        <TableHead>Jumlah SKS</TableHead>

                                        {activityRegistration.status === STUDENTSTATUS.APPROVED && (
                                            <TableHead>Nilai</TableHead>
                                        )}
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {activityRegistration.conversions.map((conversion, index) => (
                                        <TableRow key={index}>
                                            <TableCell>{index + 1}</TableCell>
                                            <TableCell>{conversion.course.name}</TableCell>
                                            <TableCell>{conversion.course.credit} SKS</TableCell>

                                            {activityRegistration.status === STUDENTSTATUS.APPROVED && (
                                                <TableCell>
                                                    <input
                                                        id={`conversions_${conversion.id}`}
                                                        name={`conversions[${index}].grade`}
                                                        type="number"
                                                        className="w-16 rounded border p-1"
                                                        value={
                                                            data.conversions.find((c) => c.id === conversion.id)
                                                                ?.grade ?? ''
                                                        }
                                                        onChange={(e) => {
                                                            setData(
                                                                'conversions',
                                                                data.conversions.map((c) =>
                                                                    c.id === conversion.id
                                                                        ? { ...c, grade: e.target.value }
                                                                        : c,
                                                                ),
                                                            );
                                                        }}
                                                    />
                                                    {errors[`conversions.${index}.grade`] && (
                                                        <InputError message={errors[`conversions.${index}.grade`]} />
                                                    )}
                                                </TableCell>
                                            )}
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>

                            {activityRegistration.status === STUDENTSTATUS.APPROVED && (
                                <Button type="submit" variant="orange" disable={processing} className="mt-4">
                                    Simpan
                                </Button>
                            )}
                        </form>
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
}
