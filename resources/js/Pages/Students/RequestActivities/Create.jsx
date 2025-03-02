import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import StudentLayout from '@/Layouts/StudentLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconCheck, IconHistory, IconInfoCircle, IconNotes } from '@tabler/icons-react';
import { useRef } from 'react';
import { toast } from 'sonner';

export default function Create(props) {
    const fileInputDoc = useRef();
    const { data, setData, post, reset, errors, processing } = useForm({
        partner_id: null,
        name: '',
        description: '',
        type: null,
        document: null,
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
        fileInputDoc.current.value = null;
    };

    return (
        <div className="flex w-full flex-col gap-y-5">
            <div className="mb-0 flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconNotes}
                />

                <div className="flex flex-col gap-3 lg:flex-row lg:justify-end">
                    <Button variant="default" size="xl" className="w-full lg:w-auto" asChild>
                        <Link href={route('students.request-activities.history')}>
                            <IconHistory className="size-4" />
                            Riwayat
                        </Link>
                    </Button>

                    <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                        <Link href={route('students.activities.index')}>
                            <IconArrowLeft className="size-4" />
                            Kembali
                        </Link>
                    </Button>
                </div>
            </div>

            <Alert variant="yellowGhost" className="mt-1">
                <AlertDescription className="flex flex-row gap-0 text-sm">
                    <IconInfoCircle className="mr-2 h-5 w-5" />
                    Sebelum Mengajukan Pastikan Kegiatan MBKM belum terdaftar pada sistem!
                </AlertDescription>
            </Alert>

            <form onSubmit={onHandleSubmit}>
                <div className="mt-2 flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6">
                    <h1 className="text-2xl font-semibold">Mitra MBKM</h1>

                    {errors.partner_id && <InputError message={errors.partner_id} className="-mb-2 ml-1" />}
                    <Select defaultValue={data.partner_id} onValueChange={(value) => setData('partner_id', value)}>
                        <SelectTrigger className="bg-white">
                            <SelectValue>
                                {props.partners.find((partner) => partner.value == data.partner_id)?.label ??
                                    'Pilih Mitra MBKM'}
                            </SelectValue>
                        </SelectTrigger>

                        <SelectContent>
                            {props.partners.map((partner, index) => (
                                <SelectItem key={index} value={partner.value}>
                                    {partner.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>

                    <Link
                        href={route('students.request-activities.create-partner')}
                        className="-mt-2 ml-1 w-full text-start text-sm font-medium text-black hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Mitra MBKM tidak ada? <span className="font-semibold text-blue-600">Tambahkan</span>
                    </Link>
                </div>

                <div className="mt-5 flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    <h1 className="text-2xl font-semibold">Kegiatan MBKM</h1>

                    <div className="grid w-full grid-cols-1 gap-6 lg:grid-cols-4">
                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="name">Judul Kegiatan</Label>
                            <Input
                                type="text"
                                name="name"
                                id="name"
                                value={data.name}
                                onChange={onHandleChange}
                                placeholder="Masukkan judul kegiatan MBKM"
                                className="bg-white"
                            />
                            {errors.name && <InputError message={errors.name} />}
                        </div>

                        <div className="col-span-2 space-y-1">
                            <Label htmlFor="type">Jenis Kegiatan</Label>
                            <Select defaultValue={data.type} onValueChange={(value) => setData('type', value)}>
                                <SelectTrigger className="bg-white">
                                    <SelectValue>
                                        {props.types.find((type) => type.value === data.type)?.label ||
                                            'Pilih Jenis Kegiatan'}
                                    </SelectValue>
                                </SelectTrigger>

                                <SelectContent>
                                    {props.types.map((type, index) => (
                                        <SelectItem key={index} value={type.value}>
                                            {type.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            {errors.type && <InputError message={errors.type} />}
                        </div>

                        <div className="col-span-full space-y-1">
                            <Label htmlFor="description">Deskripsi</Label>
                            <textarea
                                name="description"
                                id="description"
                                placeholder="Masukkan tentang kegiatan"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className="w-full rounded-xl border-gray-300 bg-white p-2 text-sm focus:border-blue-700"
                                rows={4}
                            />

                            {errors.description && <InputError message={errors.description} />}
                        </div>
                    </div>
                </div>

                <div className="mt-5 flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    <h1 className="text-2xl font-semibold">Dokumen Pendukung</h1>
                    <div className="col-span-full">
                        <Input
                            type="file"
                            name="document"
                            id="document"
                            onChange={(e) => setData(e.target.name, e.target.files[0])}
                            className="bg-white"
                            ref={fileInputDoc}
                        />
                        {errors.document && <InputError message={errors.document} />}
                    </div>
                </div>

                <div className="mt-8 flex flex-col gap-2 lg:flex-row lg:justify-end">
                    <Button type="button" variant="ghost" size="xl" onClick={onHandleReset}>
                        Reset
                    </Button>

                    <Button type="submit" variant="blue" size="xl" disabled={processing}>
                        <IconCheck />
                        Ajukan
                    </Button>
                </div>
            </form>
        </div>
    );
}

Create.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
