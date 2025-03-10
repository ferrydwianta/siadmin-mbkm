import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Checkbox } from '@/Components/ui/checkbox';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import AppLayout from '@/Layouts/AppLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconBooks, IconCheck } from '@tabler/icons-react';
import { toast } from 'sonner';

export default function Create(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        code: '',
        credit: '',
        semester: '',
        is_open: false,
        _method: props.page_settings.method,
    });
    const onHandleChange = (e) => setData(e.target.name, e.target.value);
    const onHandleReset = () => {
        reset();
    };
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

    return (
        <div className="flex w-full flex-col pb-32">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBooks}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('admin.courses.index')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            <Card>
                <CardContent className="p-6">
                    <form onSubmit={onHandleSubmit}>
                        <div className="grid grid-cols-1 gap-4 lg:grid-cols-4">
                            <div className="col-span-full">
                                <Label htmlFor="name">Nama Mata Kuliah*</Label>
                                <Input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value={data.name}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan nama mata kuliah"
                                />
                                {errors.name && <InputError message={errors.name} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="code">Kode MKA*</Label>
                                <Input
                                    type="text"
                                    name="code"
                                    id="code"
                                    value={data.code}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan kode MKA"
                                />
                                {errors.code && <InputError message={errors.code} />}
                            </div>

                            <div className="col-span-2">
                                <Label htmlFor="credit">Satuan Kredit Semester (SKS)*</Label>
                                <Input
                                    type="number"
                                    name="credit"
                                    id="credit"
                                    value={data.credit}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan jumlah SKS"
                                />
                                {errors.credit && <InputError message={errors.credit} />}
                            </div>

                            <div className="col-span-2">
                                <Label htmlFor="semester">Semester</Label>
                                <Input
                                    type="number"
                                    name="semester"
                                    id="semester"
                                    value={data.semester}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan semester"
                                />
                                {errors.semester && <InputError message={errors.semester} />}
                            </div>

                            <div className="col-span-full">
                                <div className="item-top flex space-x-2">
                                    <Checkbox
                                        id="is_open"
                                        name="is_open"
                                        checked={data.is_open}
                                        onCheckedChange={(checked) => setData('is_open', checked)}
                                    />
                                    <div className="gap-1/5 grid leading-none">
                                        <Label htmlFor="is_open">Open Semester?</Label>
                                    </div>
                                </div>
                                {errors.is_open && <InputError message={errors.is_open} />}
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

// Persistant layout
Create.layout = (page) => <AppLayout children={page} title={page.props.page_settings.title} />;
