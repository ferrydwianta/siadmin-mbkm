import CardStat from '@/Components/CardStat';
import StudentLayout from '@/Layouts/StudentLayout';
import { IconBooks, IconBuildings, IconPencil } from '@tabler/icons-react';

export default function Dashboard(props) {
    return (
        <div className="flex flex-col gap-8">
            <div className="flex flex-col items-center justify-between gap-y-4 lg:flex-row">
                <div>
                    <h3 className="text-xl font-semibold leading-relaxed tracking-tight text-foreground">
                        {props.page_settings.title}
                    </h3>
                    <p className="text-sm text-muted-foreground">{props.page_settings.subtitle}</p>
                </div>
            </div>

            <div className="mb-8 grid gap-4 lg:grid-cols-3">
                <CardStat
                    data={{
                        title: 'Total Mitra MBKM',
                        icon: IconBuildings,
                        background: 'text-white bg-gradient-to-r from-blue-400 via-blue-500 to-blue-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.partners}</div>
                </CardStat>

                <CardStat
                    data={{
                        title: 'Total Kegiatan MBKM',
                        icon: IconPencil,
                        background: 'text-white bg-gradient-to-r from-green-400 via-green-500 to-green-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.activities}</div>
                </CardStat>

                <CardStat
                    data={{
                        title: 'Total Courses',
                        icon: IconBooks,
                        background: 'text-white bg-gradient-to-r from-red-400 via-red-500 to-red-500',
                        iconClassName: 'text-white',
                    }}
                >
                    <div className="text-2xl font-bold">{props.count.courses}</div>
                </CardStat>
            </div>
        </div>
    );
}

Dashboard.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
