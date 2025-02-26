import EmptyState from '@/Components/EmptyState';
import HeaderTitle from '@/Components/HeaderTitle';
import PaginationTable from '@/Components/PaginationTable';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardFooter } from '@/Components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import StudentLayout from '@/Layouts/StudentLayout';
import { formatDateIndo, STUDENTSTATUSVARIANT } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { IconBriefcase, IconEye } from '@tabler/icons-react';
import { useState } from 'react';

export default function Index(props) {
    const { data: activityRegistrations, meta, links } = props.activityRegistrations;
    const [params, setParams] = useState(props.state);

    return (
        <div className="flex w-full flex-col pb-0">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />
            </div>

            <Card>
                <CardContent className="p-0 py-2 [&-td]:whitespace-nowrap [&-td]:px-6 [&-th]:px-6">
                    {activityRegistrations.length === 0 ? (
                        <EmptyState
                            icon={IconBriefcase}
                            title="Tidak ada Kegiatan"
                            subTitle="Silahkan daftar Kegiatan MBKM terlebih dahulu!"
                        />
                    ) : (
                        <Table className="w-full">
                            <TableHeader>
                                <TableRow>
                                    <TableHead>#</TableHead>
                                    <TableHead>Tahun Ajaran</TableHead>
                                    <TableHead>Mitra MBKM</TableHead>
                                    <TableHead>Judul Kegiatan</TableHead>
                                    <TableHead>Konversi MKA</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Terdaftar Pada</TableHead>
                                    <TableHead>Aksi</TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {activityRegistrations.map((registration, index) => (
                                    <TableRow key={index}>
                                        <TableCell>{index + 1 + (meta.current_page - 1) * meta.per_page}</TableCell>

                                        <TableCell>
                                            {registration.academicYear.name} ({registration.academicYear.semester})
                                        </TableCell>

                                        <TableCell>
                                            <div className="flex items-center gap-2">
                                                <Avatar>
                                                    <AvatarImage src={registration.activity.partner.logo} />
                                                    <AvatarFallback>
                                                        {registration.activity.partner.name.substring(0, 1)}
                                                    </AvatarFallback>
                                                </Avatar>
                                                <span>{registration.activity.partner.name}</span>
                                            </div>
                                        </TableCell>

                                        <TableCell>{registration.activity.name}</TableCell>

                                        <TableCell>
                                            {registration.conversions.length > 0 ? (
                                                <div className="flex flex-wrap gap-2">
                                                    {registration.conversions.map((conversion) => (
                                                        <span
                                                            key={conversion.course.id}
                                                            className="rounded-full bg-blue-600 px-2 py-1 text-xs font-medium text-white"
                                                        >
                                                            {conversion.course.name}
                                                        </span>
                                                    ))}
                                                </div>
                                            ) : (
                                                <span className="italic text-gray-400">Kosong</span>
                                            )}
                                        </TableCell>

                                        <TableCell>
                                            <Badge variant={STUDENTSTATUSVARIANT[registration.status]}>
                                                {registration.status}
                                            </Badge>
                                        </TableCell>

                                        <TableCell>{formatDateIndo(registration.created_at)}</TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-x-1">
                                                <Button variant="blue" size="sm" asChild>
                                                    <Link
                                                        href={route('students.activity-registrations.show', [
                                                            registration,
                                                        ])}
                                                    >
                                                        <IconEye className="size-4" />
                                                    </Link>
                                                </Button>
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
                        Anda telah mengikuti <span className="font-medium text-blue-600">{meta.total}</span> kegiatan
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
Index.layout = (page) => <StudentLayout title={page.props.page_settings.title} children={page} />;
