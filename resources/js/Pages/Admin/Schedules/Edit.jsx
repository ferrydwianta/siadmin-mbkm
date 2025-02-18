import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import AppLayout from '@/Layouts/AppLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconCalendar, IconCheck } from '@tabler/icons-react';
import { toast } from 'sonner';

export default function Edit(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        start_time: props.schedule.start_time ?? '',
        end_time: props.schedule.end_time ?? '',
        date: props.schedule.date ?? '',
        quota: props.schedule.quota ?? 0,
        _method: props.page_settings.method,
    });
    const onHandleChange = (e) => setData(e.target.name, e.target.value);
    const onHandleSubmit = (e) => {
        e.preventDefault();
        post(props.page_settings.action, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (success) => {
                const flash = flashMessage(success);
                if (flash) toast[flash.type](flash.message);
            },
        });
    };
    const onHandleReset = () => {
        reset();
    };

    return (
        <div className="flex w-full flex-col pb-32">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconCalendar}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('admin.schedules.index')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            <Card>
                <CardContent className="p-6">
                    <form onSubmit={onHandleSubmit}>
                        <div className="grid grid-cols-1 gap-4 lg:grid-cols-4">
                            <div className="col-span-2">
                                <Label htmlFor="start_time">Waktu Mulai</Label>
                                <Input
                                    type="time"
                                    name="start_time"
                                    id="start_time"
                                    value={data.start_time}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan waktu mulai"
                                />
                                {errors.start_time && <InputError message={errors.start_time} />}
                            </div>

                            <div className="col-span-2">
                                <Label htmlFor="end_time">Waktu Berakhir</Label>
                                <Input
                                    type="time"
                                    name="end_time"
                                    id="end_time"
                                    value={data.end_time}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan waktu berakhir"
                                />
                                {errors.end_time && <InputError message={errors.end_time} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="date">Tanggal</Label>
                                <Input type="date" name="date" id="date" value={data.date} onChange={onHandleChange} />
                                {errors.date && <InputError message={errors.date} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="quota">Kuota Mahasiswa</Label>
                                <Input
                                    type="number"
                                    name="quota"
                                    id="quota"
                                    value={data.quota}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan kuota mahasiswa"
                                />
                                {errors.quota && <InputError message={errors.quota} />}
                            </div>
                        </div>

                        <div className="mt-8 flex flex-col gap-2 lg:flex-row lg:justify-end">
                            <Button type="button" variant="ghost" size="xl" onClick={onHandleReset}>
                                Reset
                            </Button>

                            <Button type="submit" variant="blue" size="xl" disabled={processing}>
                                <IconCheck />
                                Save
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    );
}

Edit.layout = (page) => <AppLayout children={page} title={page.props.page_settings.title} />;
