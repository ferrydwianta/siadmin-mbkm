import CardStat from '@/Components/CardStat';
import HeaderTitle from '@/Components/HeaderTitle';
import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import { IconBooks, IconLayout2, IconPencil, IconUsers } from '@tabler/icons-react';

export default function Dashboard(props) {
    const auth = usePage().props.auth.user;
    return (
        <div className="flex w-full flex-col gap-y-6 pb-32">
            <div className="flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconLayout2}
                />
            </div>

            <div className="flex flex-col items-start gap-1 rounded-lg bg-gray-50 p-6 shadow-sm">
                <h2 className="text-2xl font-semibold">Tahun Ajaran</h2>
                <p className="text-sm text-muted-foreground">
                    {props.academicYear?.name ? (
                        <span>
                            {props.academicYear.name} {props.academicYear.semester}
                        </span>
                    ) : (
                        <span className="italic">Tidak ada tahun ajaran aktif</span>
                    )}
                </p>
            </div>

            <div className="grid w-full gap-4 lg:grid-cols-3">
                <CardStat
                    data={{
                        title: 'Mitra MBKM Terdaftar',
                        icon: IconBooks,
                        background: 'text-white bg-gradient-to-r from-red-400 via-red-500 to-red-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.partners}</div>
                </CardStat>

                <CardStat
                    data={{
                        title: 'Kegiatan MBKM Terdaftar',
                        icon: IconPencil,
                        background: 'text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.activities}</div>
                </CardStat>

                <CardStat
                    data={{
                        title: 'Total Mahasiswa',
                        icon: IconUsers,
                        background: 'text-white bg-gradient-to-r from-lime-400 via-lime-500 to-lime-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.students}</div>
                </CardStat>
            </div>
        </div>
    );
}

Dashboard.layout = (page) => <AppLayout title={page.props.page_settings.title} children={page} />;
