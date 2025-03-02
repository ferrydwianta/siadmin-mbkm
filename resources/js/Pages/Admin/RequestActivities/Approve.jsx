import InputError from '@/Components/InputError';
import { MultiSelect } from '@/Components/MultiSelect';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { flashMessage } from '@/lib/utils';
import { useForm } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';
import { useRef, useState } from 'react';
import { toast } from 'sonner';
import Description from './Description';

export default function Approve({ activity, statuses, selectedCourses, courses, action }) {
    const [isSheetOpen, setIsSheetOpen] = useState(false);
    const { data, setData, put, errors, processing } = useForm({
        status: activity.status,
        courses: selectedCourses ?? [],
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
    const multiSelectRef = useRef(null);
    const totalCredits = courses
        .filter((course) => data.courses.includes(course.value))
        .reduce((total, course) => total + course.credit, 0);

    return (
        <Sheet open={isSheetOpen} onOpenChange={setIsSheetOpen}>
            <SheetTrigger asChild>
                <Button variant="green" size="sm">
                    <IconChecklist className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent className="overflow-y-auto">
                <SheetHeader>
                    <SheetTitle>Setujui Pengajuan Kegiatan MBKM</SheetTitle>
                    <SheetDescription>
                        Periksa pengajuan kegiatan MBKM yang diajukan oleh {activity.student.name} (
                        {activity.student.student_number}).
                    </SheetDescription>
                </SheetHeader>

                <div className="mt-8 flex flex-col gap-1">
                    <h3 className="text-md font-semibold">{activity.name}</h3>
                    <p className="text-sm">{activity.partner.name}</p>

                    <h3 className="text-md mt-4 font-semibold">Jenis Kegiatan</h3>
                    <p className="text-sm">{activity.type}</p>

                    <h3 className="text-md mt-4 font-semibold">Deskripsi</h3>
                    <Description description={activity.description} />

                    <form className="space-y-5" onSubmit={onHandleSubmit}>
                        <div className="mt-4 grid w-full items-center gap-1.5">
                            <Label htflFor="status" className="text-md font-semibold">
                                Status
                            </Label>
                            <Select defaultValue={data.status} onValueChange={(value) => setData('status', value)}>
                                <SelectTrigger>
                                    <SelectValue>
                                        {statuses.find((status) => status.value == data.status)?.label ??
                                            'Pilih Status'}
                                    </SelectValue>
                                </SelectTrigger>

                                <SelectContent>
                                    {statuses.map((status, index) => (
                                        <SelectItem key={index} value={status.value}>
                                            {status.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </div>

                        {data.status === 'Approve' && (
                            <div className="mt-2 grid w-full items-center gap-1.5">
                                <Label htmlFor="courses" className="text-md font-semibold">
                                    Konversi Mata Kuliah
                                    {data.courses.length > 0 && (
                                        <span className="ml-1 text-sm text-blue-600">({totalCredits} SKS)</span>
                                    )}
                                </Label>
                                <MultiSelect
                                    ref={multiSelectRef}
                                    options={courses}
                                    onValueChange={(values) => setData('courses', values)}
                                    defaultValue={selectedCourses}
                                    placeholder="Pilih matakuliah"
                                    variant="custom"
                                    animation={2}
                                    maxCount={courses.length}
                                />
                                {errors.courses && <InputError message={errors.courses} />}
                            </div>
                        )}

                        <Button type="submit" variant="orange" disable={processing}>
                            Save
                        </Button>
                    </form>
                </div>
            </SheetContent>
        </Sheet>
    );
}
