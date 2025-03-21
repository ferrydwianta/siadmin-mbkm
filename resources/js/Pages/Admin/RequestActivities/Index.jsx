import AlertAction from '@/Components/AlertAction';
import EmptyState from '@/Components/EmptyState';
import HeaderTitle from '@/Components/HeaderTitle';
import PaginationTable from '@/Components/PaginationTable';
import ShowFilter from '@/Components/ShowFilter';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import UseFilter from '@/hooks/UseFilter';
import AppLayout from '@/Layouts/AppLayout';
import { deleteAction, formatDateIndo, STUDENTSTATUSVARIANT } from '@/lib/utils';
import { IconArrowsDownUp, IconBriefcase, IconDownload, IconRefresh, IconTrash } from '@tabler/icons-react';
import { useState } from 'react';
import Approve from './Approve';

export default function Index(props) {
    const { data: activities, meta, links } = props.activities;
    const [params, setParams] = useState(props.state);
    const onSortable = (field) => {
        setParams({
            ...params,
            field: field,
            direction: params.direction == 'asc' ? 'desc' : 'asc',
        });
    };

    UseFilter({
        route: route('admin.request-activities.index'),
        values: params,
        only: ['activities'],
    });

    return (
        <div className="flex w-full flex-col pb-32">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />
            </div>

            <Card>
                <CardHeader className="mb-4 p-0">
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
                                {[10, 25, 50, 75, 100].map((number, index) => (
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

                    {/* Show Filter */}
                    <ShowFilter params={params} />
                </CardHeader>

                <CardContent className="p-0 [&-td]:whitespace-nowrap [&-td]:px-6 [&-th]:px-6">
                    {activities.length == 0 ? (
                        <EmptyState
                            icon={IconBriefcase}
                            title="Tidak ada Kegiatan MBKM"
                            subTitle="Mulailah dengan menambahkan data kegiatan baru!"
                        />
                    ) : (
                        <Table className="w-full">
                            <TableHeader>
                                <TableRow>
                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('id')}
                                        >
                                            #
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('student_id')}
                                        >
                                            Diajukan Oleh
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('partner_id')}
                                        >
                                            Mitra MBKM
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('name')}
                                        >
                                            Judul Kegiatan
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('status')}
                                        >
                                            Status
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('type')}
                                        >
                                            Jenis Kegiatan
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>

                                    <TableHead>Dokumen</TableHead>

                                    <TableHead>
                                        <Button
                                            variant="ghost"
                                            className="group inline-flex"
                                            onClick={() => onSortable('created_at')}
                                        >
                                            Diajukan Pada
                                            <span className="ml-2 flex-none rounded text-muted-foreground">
                                                <IconArrowsDownUp className="size-4" />
                                            </span>
                                        </Button>
                                    </TableHead>
                                    <TableHead>Aksi</TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {activities.map((activity, index) => (
                                    <TableRow key={index}>
                                        <TableCell>{index + 1 + (meta.current_page - 1) * meta.per_page}</TableCell>

                                        <TableCell>
                                            {activity.student.name} ({activity.student.student_number})
                                        </TableCell>

                                        <TableCell>
                                            <div className="flex items-center gap-2">
                                                <Avatar>
                                                    <AvatarImage src={activity.partner.logo} />
                                                    <AvatarFallback>
                                                        {activity.partner.name.substring(0, 1)}
                                                    </AvatarFallback>
                                                </Avatar>
                                                <span>{activity.partner.name}</span>
                                            </div>
                                        </TableCell>

                                        <TableCell>{activity.name}</TableCell>

                                        <TableCell>
                                            <Badge variant={STUDENTSTATUSVARIANT[activity.status]}>
                                                {activity.status}
                                            </Badge>
                                        </TableCell>

                                        <TableCell>{activity.type}</TableCell>

                                        <TableCell>
                                            {activity.document ? (
                                                <Button variant="blue" size="sm" asChild>
                                                    <a href={activity.document} download>
                                                        <IconDownload className="size-4" />
                                                        Document
                                                    </a>
                                                </Button>
                                            ) : (
                                                <span className="italic text-gray-400">No document</span>
                                            )}
                                        </TableCell>

                                        <TableCell>{formatDateIndo(activity.created_at)}</TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-x-1">
                                                <Approve
                                                    activity={activity}
                                                    statuses={props.statuses}
                                                    selectedCourses={activity.courses.map((course) => course.id)}
                                                    courses={props.courses}
                                                    action={route('admin.request-activities.approve', [activity])}
                                                />

                                                <AlertAction
                                                    trigger={
                                                        <Button variant="red" size="sm">
                                                            <IconTrash className="size-4" />
                                                        </Button>
                                                    }
                                                    action={() =>
                                                        deleteAction(
                                                            route('admin.request-activities.destroy', [activity]),
                                                        )
                                                    }
                                                />
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    )}
                </CardContent>

                <CardFooter className="flex w-full flex-col items-center justify-between gap-y-2 border-t py-3 lg:flex-row">
                    <p className="text-sm text-muted-foreground">
                        Menampilkan <span className="font-medium text-blue-600">{meta.from ?? 0}</span> dari{' '}
                        {meta.total} kegiatan
                    </p>

                    <div className="overflow-x-auto">
                        {meta.has_pages && <PaginationTable meta={meta} links={links} />}
                    </div>
                </CardFooter>
            </Card>
        </div>
    );
}

// Persistent layout
Index.layout = (page) => <AppLayout title={page.props.page_settings.title} children={page} />;
