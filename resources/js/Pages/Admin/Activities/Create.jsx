import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { MultiSelect } from '@/Components/MultiSelect';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import AppLayout from '@/Layouts/AppLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconBriefcase, IconCheck } from '@tabler/icons-react';
import React from 'react';
import { toast } from 'sonner';

export default function Create(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        partner_id: null,
        name: '',
        description: '',
        type: null,
        courses: [],
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
    const multiSelectRef = React.useRef(null);
    const onHandleReset = () => {
        reset();
        multiSelectRef.current?.clear();
    };
    const totalCredits = props.courses
        .filter((course) => data.courses.includes(course.value))
        .reduce((total, course) => total + course.credit, 0);

    return (
        <div className="flex w-full flex-col pb-32">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('admin.activities.index')}>
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
                                <Label htmlFor="partner_id">Mitra MBKM*</Label>
                                <Select
                                    defaultValue={data.partner_id}
                                    onValueChange={(value) => setData('partner_id', value)}
                                >
                                    <SelectTrigger>
                                        <SelectValue>
                                            {props.partners.find((partner) => partner.value == data.partner_id)
                                                ?.label ?? 'Pilih Mitra MBKM'}
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
                                {errors.partner_id && <InputError message={errors.partner_id} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="name">Judul Kegiatan*</Label>
                                <Input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value={data.name}
                                    onChange={onHandleChange}
                                    placeholder="Masukkan judul kegiatan MBKM"
                                />
                                {errors.name && <InputError message={errors.name} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="type">Jenis Kegiatan*</Label>
                                <Select defaultValue={data.type} onValueChange={(value) => setData('type', value)}>
                                    <SelectTrigger>
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

                            <div className="col-span-full">
                                <Label htmlFor="description">Deskripsi*</Label>
                                <textarea
                                    name="description"
                                    id="description"
                                    placeholder="Masukkan tentang kegiatan"
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    className="w-full rounded-xl border-gray-300 p-2 text-sm focus:border-blue-700"
                                    rows={4}
                                />

                                {errors.description && <InputError message={errors.description} />}
                            </div>

                            <div className="col-span-full">
                                <Label htmlFor="courses">
                                    Konversi Mata Kuliah
                                    {data.courses.length > 0 && (
                                        <span className="ml-1 text-sm text-blue-600">({totalCredits} SKS)</span>
                                    )}
                                </Label>
                                <MultiSelect
                                    ref={multiSelectRef}
                                    options={props.courses}
                                    onValueChange={(values) => setData('courses', values)}
                                    defaultValue={[]}
                                    placeholder="Pilih matakuliah"
                                    variant="custom"
                                    animation={2}
                                    maxCount={props.courses.length}
                                />
                                {errors.courses && <InputError message={errors.courses} />}
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

Create.layout = (page) => <AppLayout children={page} title={page.props.page_settings.title} />;
