import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import StudentLayout from '@/Layouts/StudentLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconCheck, IconInfoCircle, IconNotes } from '@tabler/icons-react';
import { useRef } from 'react';
import { toast } from 'sonner';

export default function CreatePartner(props) {
    const fileInputLogo = useRef();
    const { data, setData, post, reset, errors, processing } = useForm({
        name: '',
        description: '',
        logo: null,
        address: '',
        contact: '',
        _method: props.page_settings.method,
    });

    const onHandleChange = (e) => setData(e.target.name, e.target.value);
    const onHandleReset = () => {
        reset();
        fileInputLogo.current.value = null;
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
        <div className="flex w-full flex-col gap-y-5">
            <div className="mb-0 flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconNotes}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('students.request-activities.create')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            <Alert variant="yellowGhost" className="mt-1">
                <AlertDescription className="flex flex-row gap-0 text-sm">
                    <IconInfoCircle className="mr-2 h-5 w-5" />
                    Sebelum Menambahkan Mitra, Pastikan Mitra MBKM belum terdaftar pada sistem!
                </AlertDescription>
            </Alert>

            <form onSubmit={onHandleSubmit}>
                <div className="mt-2 flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6">
                    <h1 className="text-2xl font-semibold">Mitra MBKM</h1>

                    <div className="grid w-full grid-cols-1 gap-6 lg:grid-cols-4">
                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="name">Nama Mitra*</Label>
                            <Input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Masukkan nama mitra"
                                value={data.name}
                                onChange={(e) => setData(e.target.name, e.target.value)}
                                className="bg-white"
                            />

                            {errors.name && <InputError message={errors.name} />}
                        </div>

                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="logo">Logo</Label>
                            <Input
                                type="file"
                                name="logo"
                                id="logo"
                                onChange={(e) => setData(e.target.name, e.target.files[0])}
                                ref={fileInputLogo}
                                className="bg-white"
                            />

                            {errors.logo && <InputError message={errors.logo} />}
                        </div>

                        <div className="col-span-full space-y-1">
                            <Label htmlFor="description">Deskripsi*</Label>
                            <textarea
                                name="description"
                                id="description"
                                placeholder="Masukkan tentang mitra"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className="w-full rounded-xl border-gray-300 p-2 text-sm focus:border-blue-700"
                                rows={4}
                            />

                            {errors.description && <InputError message={errors.description} />}
                        </div>
                    </div>
                </div>

                <div className="mt-5 flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    <h1 className="text-2xl font-semibold">Informasi Pendukung</h1>

                    <div className="mb-2 grid w-full grid-cols-1 gap-6 lg:grid-cols-4">
                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="address">Alamat Mitra</Label>
                            <Input
                                type="text"
                                name="address"
                                id="address"
                                placeholder="Masukkan alamat mitra"
                                value={data.address}
                                onChange={(e) => setData(e.target.name, e.target.value)}
                                className="bg-white"
                            />

                            {errors.address && <InputError message={errors.address} />}
                        </div>

                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="contact">Contact Person</Label>
                            <Input
                                type="text"
                                name="contact"
                                id="contact"
                                placeholder="Masukkan contact person mitra"
                                value={data.contact}
                                onChange={(e) => setData(e.target.name, e.target.value)}
                                className="bg-white"
                            />

                            {errors.contact && <InputError message={errors.contact} />}
                        </div>
                    </div>
                </div>

                <div className="mt-8 flex flex-col gap-2 lg:flex-row lg:justify-end">
                    <Button type="button" variant="ghost" size="xl" onClick={onHandleReset}>
                        Reset
                    </Button>

                    <Button type="submit" variant="blue" size="xl" disabled={processing}>
                        <IconCheck />
                        Simpan
                    </Button>
                </div>
            </form>
        </div>
    );
}

CreatePartner.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
