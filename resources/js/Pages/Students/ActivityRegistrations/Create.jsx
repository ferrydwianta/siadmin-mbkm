import AlertAction from '@/Components/AlertAction';
import EmptyState from '@/Components/EmptyState';
import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Thumbnail, ThumbnailFallback, ThumbnailImage } from '@/Components/Thumbnail';
import { Button } from '@/Components/ui/button';
import { Checkbox } from '@/Components/ui/checkbox';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import StudentLayout from '@/Layouts/StudentLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconBriefcase, IconCheck, IconNotes } from '@tabler/icons-react';
import { toast } from 'sonner';

export default function Create(props) {
    const { data, setData, post, reset, errors, processing } = useForm({
        conversions: [],
        member_type: null,
        _method: props.page_settings._method,
    });

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

    const totalCredits = props.activity.courses
        .filter((course) => data.conversions.includes(course.id))
        .reduce((sum, course) => sum + course.credit, 0);

    return (
        <div className="flex w-full flex-col gap-y-5">
            <div className="mb-0 flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconNotes}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('students.activities.index')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            <div className="flex flex-col items-center gap-6 rounded-lg bg-gray-50 p-6 shadow-sm lg:flex-row">
                <Thumbnail className="h-24 w-24">
                    <ThumbnailImage src={props.activity.partner.logo} />
                    <ThumbnailFallback>{props.activity.partner.name.substring(0, 1)}</ThumbnailFallback>
                </Thumbnail>
                <div className="text-center lg:text-left">
                    <h1 className="text-2xl font-bold">{props.activity.name}</h1>
                    <p className="text-md text-gray-600">{props.activity.partner.name}</p>
                </div>
            </div>

            <form onSubmit={onHandleSubmit}>
                {props.activity.courses.length == 0 ? (
                    <div className="flex flex-col items-center gap-4 rounded-lg bg-gray-50 p-6 shadow-sm">
                        <EmptyState
                            icon={IconBriefcase}
                            title="Tidak ada konversi matakuliah"
                            subTitle="Kegiatan ini tidak memiliki mata kuliah konversi!"
                        />
                    </div>
                ) : (
                    <div className="flex flex-col items-start gap-4 rounded-lg bg-gray-50 p-6 shadow-sm">
                        <h1 className="text-2xl font-semibold">
                            Pilih Konversi
                            {totalCredits > 0 && (
                                <span className="ml-2 text-2xl text-blue-600">({totalCredits} SKS)</span>
                            )}
                        </h1>
                        <Table className="w-full">
                            <TableHeader>
                                <TableRow>
                                    <TableHead>#</TableHead>
                                    <TableHead>Mata Kuliah</TableHead>
                                    <TableHead>Jumlah SKS</TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {props.activity.courses.map((course, index) => (
                                    <TableRow key={index}>
                                        <TableCell>
                                            <Checkbox
                                                id={`conversions_${course.id}`}
                                                name="conversions"
                                                checked={data.conversions.includes(course.id)}
                                                onCheckedChange={(checked) => {
                                                    setData(
                                                        'conversions',
                                                        checked
                                                            ? [...data.conversions, course.id]
                                                            : data.conversions.filter((id) => id !== course.id),
                                                    );
                                                }}
                                            />
                                        </TableCell>

                                        <TableCell>{course.name}</TableCell>

                                        <TableCell>{course.credit} SKS</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>

                        {errors.conversions && <InputError message={errors.conversions} />}
                    </div>
                )}

                <div className="mt-5 flex flex-col items-start gap-3 rounded-lg bg-gray-50 p-6 shadow-sm">
                    <h1 className="text-2xl font-semibold">Pilih Jenis Anggota</h1>
                    <div className="w-full lg:w-48">
                        <Select
                            defaultValue={String(data.member_type)}
                            onValueChange={(value) => setData('member_type', value)}
                        >
                            <SelectTrigger className="mt-1 h-11 rounded-md border-gray-300">
                                <SelectValue>
                                    {props.memberTypes.find((type) => type.value == data.member_type)?.label ??
                                        'Pilih Jenis Anggota'}
                                </SelectValue>
                            </SelectTrigger>

                            <SelectContent>
                                {props.memberTypes.map((type, index) => (
                                    <SelectItem key={index} value={type.value}>
                                        {type.label}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                    {errors.member_type && <InputError message={errors.member_type} />}
                </div>

                <div className="mt-8 flex flex-col gap-2 lg:flex-row lg:justify-end">
                    <Button type="button" variant="ghost" size="xl" onClick={onHandleReset}>
                        Reset
                    </Button>

                    <AlertAction
                        trigger={
                            <Button type="button" variant="blue" size="xl" disabled={processing}>
                                <IconCheck className="size-4" />
                                Daftar
                            </Button>
                        }
                        action={onHandleSubmit}
                        description={`Apakah anda yakin mendaftar ke ${props.activity.name}?`}
                    />
                </div>
            </form>
        </div>
    );
}

Create.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
