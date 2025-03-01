import CardStat from '@/Components/CardStat';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import StudentLayout from '@/Layouts/StudentLayout';
import { formatDateIndo } from '@/lib/utils';
import { IconBooks, IconBuildings, IconCalendar, IconPencil } from '@tabler/icons-react';

export default function Dashboard(props) {
    return (
        <div className="flex flex-col gap-8">
            <div className="flex flex-col items-center justify-between gap-y-4 lg:flex-row">
                <div>
                    <h3 className="text-2xl font-semibold leading-relaxed tracking-tight text-foreground">
                        {props.page_settings.title}
                    </h3>
                    <p className="text-sm text-muted-foreground">{props.page_settings.subtitle}</p>
                </div>
            </div>

            <div className="grid gap-4 lg:grid-cols-3">
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

            {props.activityRegistrations.length > 0 && (
                <div className="flex flex-col items-start gap-3 rounded-lg p-0">
                    <h3 className="mb-1 text-xl font-semibold">Jadwal Ujian</h3>

                    {props.activityRegistrations.map((registration, index) => (
                        <Alert variant="default">
                            <AlertDescription className="flex flex-row gap-0 text-sm">
                                <IconCalendar className="mr-2 h-5 w-5" />
                                Ujian akhir&nbsp;
                                <span className="font-medium">{registration.activity.name}</span>&nbsp;pada&nbsp;
                                <span className="font-medium">
                                    {formatDateIndo(registration.schedule.date)}, {registration.schedule.start_time} -{' '}
                                    {registration.schedule.end_time}
                                </span>
                            </AlertDescription>
                        </Alert>
                    ))}
                </div>
            )}

            {/* {props.announcements.length > 0 && (
                <div className="flex flex-col items-start gap-4 rounded-lg mb-2">
                    <h3 className="text-xl font-semibold">Pengumuman</h3>
                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2 w-full">
                        {props.announcements.map((announcement, index) => (
                            <div className="rounded-xl p-4 border border-gray-200">
                                <div className='flex flex-row gap-x-4'>
                                    <p className="w-12 h-8 bg-gray-100 text-gray-800 rounded-md text-sm font-semibold flex items-center justify-center">
                                        {index + 1}
                                    </p>
                                    <div>
                                        <h3 className="text-md font-semibold">{announcement.title}</h3>
                                        <p className="text-sm text-muted-foreground mt-0">
                                            {announcement.description}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )} */}
        </div>
    );
}

Dashboard.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
