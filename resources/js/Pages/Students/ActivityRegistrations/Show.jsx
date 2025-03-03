import AlertAction from '@/Components/AlertAction';
import EmptyState from '@/Components/EmptyState';
import HeaderTitle from '@/Components/HeaderTitle';
import InputError from '@/Components/InputError';
import { Thumbnail, ThumbnailFallback, ThumbnailImage } from '@/Components/Thumbnail';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import StudentLayout from '@/Layouts/StudentLayout';
import { deleteAction, flashMessage, formatDateIndo, STUDENTSTATUS } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconBooks, IconDownload, IconNotes, IconTrash } from '@tabler/icons-react';
import { useRef } from 'react';
import { toast } from 'sonner';

export default function Show(props) {
    const registration = props.activityRegistration;
    const fileInputDoc = useRef();
    const { data, setData, post, reset, errors, processing } = useForm({
        document: registration.document ?? null,
        _method: props.page_settings.method,
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

    return (
        <div className="flex w-full flex-col gap-y-6">
            <div className="flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconNotes}
                />

                <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                    <Link href={route('students.activity-registrations.index')}>
                        <IconArrowLeft className="size-4" />
                        Kembali
                    </Link>
                </Button>
            </div>

            {/* Alert Message for Rejected Registration */}
            {registration.status === STUDENTSTATUS.REJECT && (
                <Alert variant="destructive">
                    <AlertDescription className="text-sm">
                        Pendaftaran Kegiatan MBKM anda tidak disetujui! {registration.notes}
                    </AlertDescription>
                </Alert>
            )}

            {registration.status === STUDENTSTATUS.APPROVED && (
                <Alert variant="greenGhost">
                    <AlertDescription className="text-sm">
                        Pendaftaran Kegiatan MBKM anda telah disetujui!
                    </AlertDescription>
                </Alert>
            )}

            {registration.status === STUDENTSTATUS.PENDING && (
                <Alert variant="yellowGhost">
                    <AlertDescription className="text-sm">
                        Sedang Menunggu Verifikasi oleh Koordinator!
                    </AlertDescription>
                </Alert>
            )}

            {/* Activity Info */}
            <div className="flex flex-col items-center gap-6 rounded-xl bg-neutral-50 p-6 shadow-sm lg:flex-row">
                <Thumbnail className="h-24 w-24">
                    <ThumbnailImage src={registration.activity.partner.logo} />
                    <ThumbnailFallback>{registration.activity.partner.name.substring(0, 1)}</ThumbnailFallback>
                </Thumbnail>
                <div className="text-center lg:text-left">
                    <h1 className="text-2xl font-bold">{registration.activity.name}</h1>
                    <p className="text-md text-gray-600">{registration.activity.type}</p>
                </div>
            </div>

            {/* SKS Conversion Section */}

            {registration.conversions.length === 0 ? (
                <div className="flex flex-col items-center gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    <EmptyState
                        icon={IconBooks}
                        title="Tidak ada Konversi SKS"
                        subTitle="Tidak ada konversi mata kuliah yang diambil"
                    />
                </div>
            ) : (
                <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    {(() => {
                        const totalCredits = registration.conversions.reduce(
                            (total, conv) => total + conv.course.credit,
                            0,
                        );

                        return (
                            <h1 className="text-2xl font-semibold">
                                Konversi {totalCredits > 0 ? `(${totalCredits} SKS)` : ''}
                            </h1>
                        );
                    })()}
                    <Table className="w-full">
                        <TableHeader>
                            <TableRow>
                                <TableHead>#</TableHead>
                                <TableHead>Mata Kuliah</TableHead>
                                <TableHead>Jumlah SKS</TableHead>
                                <TableHead>Nilai</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {registration.conversions.map((conversion, index) => (
                                <TableRow key={index}>
                                    <TableCell>{index + 1}</TableCell>
                                    <TableCell>{conversion.course.name}</TableCell>
                                    <TableCell>{conversion.course.credit} SKS</TableCell>
                                    <TableCell>
                                        {conversion.grade ? (
                                            <span className="font-medium text-green-600">{conversion.grade}</span>
                                        ) : (
                                            <span className="italic text-gray-400">Belum ada</span>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            )}

            <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                <h1 className="text-2xl font-semibold">Informasi Pendaftaran</h1>
                <div className="flex flex-col gap-y-2 text-sm text-gray-600">
                    <p>
                        Tahun ajaran:{' '}
                        <span className="font-semibold text-blue-600">
                            {registration.academicYear.name} ({registration.academicYear.semester})
                        </span>
                    </p>
                    <p>
                        Jenis Anggota: <span className="font-bold">{registration.memberType}</span>
                    </p>
                    {registration.status === STUDENTSTATUS.APPROVED && (
                        <p>
                            Tanggal Ujian:
                            {registration.schedule ? (
                                <span className="text-sm font-bold">
                                    {' '}
                                    {formatDateIndo(registration.schedule.date)}, {registration.schedule.start_time} -{' '}
                                    {registration.schedule.end_time}
                                </span>
                            ) : (
                                <span className="text-gray-400"> Belum ada jadwal</span>
                            )}
                        </p>
                    )}
                </div>
            </div>

            {registration.status === STUDENTSTATUS.APPROVED && (
                <div className="flex flex-col items-start gap-4 rounded-xl bg-neutral-50 p-6 shadow-sm">
                    <h1 className="text-2xl font-semibold">Laporan Akhir</h1>
                    <form onSubmit={onHandleSubmit} className="space-y-4">
                        {data.document && registration.document ? (
                            <div className="space-x-2">
                                <Button variant="blue" size="sm" asChild>
                                    <a href={registration.document} download>
                                        <IconDownload className="size-4" />
                                        Document
                                    </a>
                                </Button>

                                <AlertAction
                                    trigger={
                                        <Button variant="red" size="sm">
                                            <IconTrash className="size-4" />
                                        </Button>
                                    }
                                    action={() =>
                                        deleteAction(
                                            route('students.activity-registrations.delete-document', [registration]),
                                        )
                                    }
                                />
                            </div>
                        ) : (
                            <>
                                <Input
                                    type="file"
                                    name="document"
                                    id="document"
                                    onChange={(e) => setData(e.target.name, e.target.files[0])}
                                    className="bg-white"
                                    ref={fileInputDoc}
                                />
                                {errors.document && <InputError message={errors.document} />}

                                <Button type="submit" variant="blue" disable={processing}>
                                    Unggah
                                </Button>
                            </>
                        )}
                    </form>
                </div>
            )}
        </div>
    );
}

Show.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
