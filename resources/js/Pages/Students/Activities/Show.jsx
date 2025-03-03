import HeaderTitle from '@/Components/HeaderTitle';
import { Thumbnail, ThumbnailFallback, ThumbnailImage } from '@/Components/Thumbnail';
import { Button } from '@/Components/ui/button';
import StudentLayout from '@/Layouts/StudentLayout';
import { Link } from '@inertiajs/react';
import { IconArrowLeft, IconBriefcase, IconMap, IconPhone } from '@tabler/icons-react';

export default function Show(props) {
    return (
        <div className="flex w-full flex-col gap-y-5">
            <div className="mb-0 flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />

                <div className="flex flex-row gap-3">
                    <Button variant="blue" size="xl" asChild className="w-full lg:w-auto">
                        <Link href={route('students.activity-registrations.create', [props.activity])}>Daftar</Link>
                    </Button>

                    <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                        <Link href={route('students.activities.index')}>
                            <IconArrowLeft className="size-4" />
                            Kembali
                        </Link>
                    </Button>
                </div>
            </div>

            <div className="flex flex-col items-center gap-6 rounded-xl bg-neutral-50 p-6 shadow-sm lg:flex-row">
                <Thumbnail className="h-24 w-24">
                    <ThumbnailImage src={props.activity.partner.logo} />
                    <ThumbnailFallback>{props.activity.partner.name.substring(0, 1)}</ThumbnailFallback>
                </Thumbnail>
                <div className="text-center lg:text-left">
                    <h1 className="text-2xl font-bold">{props.activity.name}</h1>
                    <p className="text-md text-gray-600">{props.activity.type}</p>
                </div>
            </div>

            <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                <h1 className="text-2xl font-semibold">Rincian Kegiatan</h1>
                <p className="text-justify text-sm text-gray-600">{props.activity.description}</p>
            </div>

            <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                <h1 className="text-2xl font-semibold">Tentang Perusahaan</h1>

                <div className="flex flex-row items-center gap-x-4">
                    <Thumbnail className="h-14 w-14">
                        <ThumbnailImage src={props.activity.partner.logo} />
                        <ThumbnailFallback>{props.activity.partner.name.substring(0, 1)}</ThumbnailFallback>
                    </Thumbnail>
                    <div className="flex flex-col">
                        <p className="text-md text-justify font-semibold text-gray-600">
                            {props.activity.partner.name}
                        </p>
                        <p className="line-clamp-2 max-w-screen-lg text-sm text-gray-600">
                            {props.activity.partner.description || 'Mitra MBKM'}
                        </p>
                    </div>
                </div>

                <div className="mt-2 flex items-center">
                    <div className="flex items-center gap-x-2 pr-4">
                        <IconMap className="h-5 w-5" />
                        <p className="max-w-sm text-sm text-gray-600">
                            {props.activity.partner.address ? props.activity.partner.address : '-'}
                        </p>
                    </div>

                    <div className="flex items-center gap-x-2">
                        <IconPhone className="h-5 w-5" />
                        <p className="max-w-sm text-sm text-gray-600">
                            {props.activity.partner.contact ? props.activity.partner.contact : '-'}
                        </p>
                    </div>
                </div>
            </div>

            <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                <h1 className="text-2xl font-semibold">Konversi Mata Kuliah</h1>
                <div className="flex flex-wrap gap-2">
                    {props.activity.courses.length > 0 ? (
                        props.activity.courses.map((course) => (
                            <span
                                key={course.id}
                                className="rounded-full px-3 py-2 text-xs font-medium text-blue-500 ring-1 ring-inset ring-blue-500"
                            >
                                {course.name}
                            </span>
                        ))
                    ) : (
                        <span className="italic text-gray-400">Tidak ada konversi MKA</span>
                    )}
                </div>
            </div>
        </div>
    );
}

// Persistent layout
Show.layout = (page) => <StudentLayout title={page.props.page_settings.title} children={page} />;
