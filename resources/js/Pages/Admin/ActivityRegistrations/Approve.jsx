import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/ui/sheet';
import { Textarea } from '@/Components/ui/textarea';
import { flashMessage } from '@/lib/utils';
import { useForm } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';
import { useState } from 'react';
import { toast } from 'sonner';

export default function Approve({ registration, statuses, action }) {
    const [isSheetOpen, setIsSheetOpen] = useState(false);
    const { data, setData, put, errors, processing } = useForm({
        status: registration.status,
        notes: registration.notes ?? '',
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

    return (
        <Sheet open={isSheetOpen} onOpenChange={setIsSheetOpen}>
            <SheetTrigger asChild>
                <Button variant="green" size="sm">
                    <IconChecklist className="size-4 text-white" />
                </Button>
            </SheetTrigger>

            <SheetContent>
                <SheetHeader>
                    <SheetTitle>Setujui KRS Mahasiswa {registration.student.user.name}</SheetTitle>
                    <SheetDescription>Periksa pendaftaran kegiatan MBKM yang diajukan mahasiswa.</SheetDescription>
                </SheetHeader>

                <form className="mt-6 space-y-4" onSubmit={onHandleSubmit}>
                    <div className="grid w-full items-center gap-1.5">
                        <Label htflFor="status">Status</Label>
                        <Select defaultValue={data.status} onValueChange={(value) => setData('status', value)}>
                            <SelectTrigger>
                                <SelectValue>
                                    {statuses.find((status) => status.value == data.status)?.label ?? 'Pilih Status'}
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
                    {data.status === 'Reject' && (
                        <div className="grid w-full items-center gap-1.5">
                            <Label htflFor="notes">Keterangan</Label>
                            <Textarea
                                name="notes"
                                id="notes"
                                onChange={(e) => setData(e.target.name, e.target.value)}
                                placeholder="Masukkan catatan..."
                                value={data.notes}
                            ></Textarea>
                            {errors.notes && <InputError message={errors.notes} />}
                        </div>
                    )}

                    <Button type="submit" variant="orange" disable={processing}>
                        Save
                    </Button>
                </form>
            </SheetContent>
        </Sheet>
    );
}
