import EmptyState from '@/Components/EmptyState';
import HeaderTitle from '@/Components/HeaderTitle';
import PaginationTable from '@/Components/PaginationTable';
import { Thumbnail, ThumbnailFallback, ThumbnailImage } from '@/Components/Thumbnail';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import UseFilter from '@/hooks/UseFilter';
import StudentLayout from '@/Layouts/StudentLayout';
import { Link } from '@inertiajs/react';
import { IconBriefcase, IconRefresh } from '@tabler/icons-react';
import { useState } from 'react';

export default function Index(props) {
    const { data: activities, meta, links } = props.activities;
    const [params, setParams] = useState(props.state);

    UseFilter({
        route: route('students.activities.index'),
        values: params,
        only: ['activities'],
    });

    return (
        <div className="flex w-full flex-col pb-1">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />
            </div>

            {/* Filters & Sorting */}
            <Card>
                <CardHeader className="p-1">
                    {/* Filters */}
                    <div className="flex w-full flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center">
                        <Input
                            className="w-full sm:w-1/4"
                            placeholder="Search.."
                            value={params?.search}
                            onChange={(e) => setParams((prev) => ({ ...prev, search: e.target.value }))}
                        />

                        <Select value={params?.load} onValueChange={(e) => setParams({ ...params, load: e })}>
                            <SelectTrigger className="w-full sm:w-24">
                                <SelectValue placeholder="Load" />
                            </SelectTrigger>

                            <SelectContent>
                                {[9, 18, 27, 36, 45].map((number, index) => (
                                    <SelectItem key={index} value={number}>
                                        {number}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>

                        <Button variant="red" onClick={() => setParams(props.state)} size="xl">
                            <IconRefresh className="size-4" />
                            Bersihkan
                        </Button>
                    </div>
                </CardHeader>
            </Card>

            {/* Activities Section */}
            <div
                className={`my-6 grid ${activities.length === 0 ? 'flex items-center justify-center' : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3'} gap-6`}
            >
                {activities.length === 0 ? (
                    <EmptyState
                        icon={IconBriefcase}
                        title="Tidak ada Kegiatan MBKM"
                        subTitle="Mulailah dengan menambahkan data kegiatan baru!"
                    />
                ) : (
                    activities.map((activity, index) => (
                        <Card
                            key={index}
                            className="relative isolate flex h-full flex-col rounded-xl shadow-md transition-shadow hover:scale-105 hover:shadow-xl"
                        >
                            <a href={route('students.activities.show', { activity })}>
                                <span className="absolute inset-0 z-40"></span>
                            </a>
                            {/* Partner Info */}
                            <CardHeader className="flex flex-row items-center gap-4 border-b pb-6">
                                <Thumbnail className="h-14 w-14">
                                    <ThumbnailImage src={activity.partner.logo} />
                                    <ThumbnailFallback>{activity.partner.name.substring(0, 1)}</ThumbnailFallback>
                                </Thumbnail>
                                <div>
                                    <h3 className="text-lg font-semibold">{activity.partner.name}</h3>
                                    <p className="text-sm text-gray-500">{activity.type}</p>
                                </div>
                            </CardHeader>

                            {/* Card Content */}
                            <CardContent className="flex-grow p-6">
                                <h2 className="mb-2 text-xl font-bold">{activity.name}</h2>
                                <p className="line-clamp-3 text-gray-700">{activity.description}</p>

                                {/* Courses */}
                                <div className="mt-4 flex flex-wrap gap-2">
                                    {activity.courses.length > 0 ? (
                                        activity.courses.map((course) => (
                                            <span
                                                key={course.id}
                                                className="rounded-full px-3 py-1.5 text-xs font-medium text-blue-500 ring-1 ring-inset ring-blue-500"
                                            >
                                                {course.name}
                                            </span>
                                        ))
                                    ) : (
                                        <span className="italic text-gray-400">Tidak ada konversi MKA</span>
                                    )}
                                </div>
                            </CardContent>

                            {/* Enroll Button - Anchored Bottom Right */}
                            <CardFooter className="flex justify-end p-4">
                                <Button variant="blue" size="lg" asChild className="z-50">
                                    <Link href={route('students.activity-registrations.create', [activity])}>
                                        Daftar
                                    </Link>
                                </Button>
                            </CardFooter>
                        </Card>
                    ))
                )}
            </div>

            <Card>
                <CardContent className="flex w-full flex-col items-center justify-between gap-y-2 py-3 lg:flex-row">
                    <p className="text-sm text-muted-foreground">
                        Menampilkan <span className="font-medium text-blue-600">{meta.from ?? 0}</span> dari{' '}
                        {meta.total} kegiatan
                    </p>

                    <div className="overflow-x-auto">
                        {meta.has_pages && <PaginationTable meta={meta} links={links} />}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

// Persistent layout
Index.layout = (page) => <StudentLayout title={page.props.page_settings.title} children={page} />;
