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
import { IconArrowLeft, IconBriefcase, IconDownload } from '@tabler/icons-react';

export default function History(props) {
    const { data: activities, meta, links } = props.activities;
    console.log(props.activities);
    return (
        <div className="flex w-full flex-col pb-0">
            <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconBriefcase}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('students.request-activities.create')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            <Card>
                <CardContent className="p-0 py-2 [&-td]:whitespace-nowrap [&-td]:px-6 [&-th]:px-6">
                    {activities.length === 0 ? (
                        <EmptyState
                            icon={IconBriefcase}
                            title="Tidak Ada Riwayat Pengajian"
                            subTitle="Silahkan mengajukan Kegiatan MBKM yang belum terdaftar disistem!"
                        />
                    ) : (
                        <Table className="w-full">
                            <TableHeader>
                                <TableRow>
                                    <TableHead>#</TableHead>
                                    <TableHead>Mitra MBKM</TableHead>
                                    <TableHead>Judul Kegiatan</TableHead>
                                    <TableHead>Jenis Kegiatan</TableHead>
                                    <TableHead>Deskripsi</TableHead>
                                    <TableHead>Dokumen Pendukung</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Diajukan Pada</TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {activities.map((activity, index) => (
                                    <TableRow key={index}>
                                        <TableCell>{index + 1 + (meta.current_page - 1) * meta.per_page}</TableCell>

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
                                        <TableCell>{activity.type}</TableCell>

                                        <TableCell className="max-w-[200px] overflow-hidden truncate text-ellipsis whitespace-nowrap">
                                            {activity.description}
                                        </TableCell>

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

                                        <TableCell>
                                            <Badge variant={STUDENTSTATUSVARIANT[activity.status]}>
                                                {activity.status}
                                            </Badge>
                                        </TableCell>

                                        <TableCell>{formatDateIndo(activity.created_at)}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    )}
                </CardContent>

                <CardFooter className="flex w-full flex-col items-center justify-between gap-y-2 border-t py-3 lg:flex-row">
                    <p className="text-sm text-muted-foreground">
                        Anda telah mengajukan <span className="font-medium text-blue-600">{meta.total}</span> kegiatan
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
History.layout = (page) => <StudentLayout title={page.props.page_settings.title} children={page} />;
