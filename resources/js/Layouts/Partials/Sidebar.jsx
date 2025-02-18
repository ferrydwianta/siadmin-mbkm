import NavLink from '@/Components/NavLink';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Link } from '@inertiajs/react';
import {
    IconBooks,
    IconBriefcase,
    IconBuildingSkyscraper,
    IconCalendar,
    IconCalendarTime,
    IconCircleKey,
    IconLayout2,
    IconLogout2,
    IconNotes,
    IconScript,
    IconUsers,
    IconUsersGroup,
} from '@tabler/icons-react';

export default function Sidebar({ auth, url }) {
    return (
        <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col">
                <li className="-mx-6">
                    <Link
                        href="#"
                        className="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-blue-800"
                    >
                        <Avatar>
                            <AvatarImage src={auth.avatar} />
                            <AvatarFallback>{auth.name.substring(0, 1)}</AvatarFallback>
                        </Avatar>
                        <div className="flex flex-col text-left">
                            <span className="truncate font-bold">{auth.name}</span>
                            <span className="truncate">{auth.role_name}</span>
                        </div>
                    </Link>
                </li>

                {auth.roles.some((role) => ['Admin'].includes(role)) && (
                    <>
                        <NavLink
                            url={route('admin.dashboard')}
                            active={url.startsWith('/admin/dashboard')}
                            title="Dashboard"
                            icon={IconLayout2}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">Master</div>
                        <NavLink
                            url={route('admin.academic-years.index')}
                            active={url.startsWith('/admin/academic-years')}
                            title="Tahun Ajaran"
                            icon={IconCalendarTime}
                        />
                        <NavLink
                            url={route('admin.roles.index')}
                            active={url.startsWith('/admin/roles')}
                            title="Peran"
                            icon={IconCircleKey}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">Pengguna</div>
                        <NavLink
                            url={route('admin.students.index')}
                            active={url.startsWith('/admin/students')}
                            title="Mahasiswa"
                            icon={IconUsers}
                        />
                        <NavLink
                            url={route('admin.lecturers.index')}
                            active={url.startsWith('/admin/lecturers')}
                            title="Dosen"
                            icon={IconUsersGroup}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">MBKM</div>
                        <NavLink
                            url={route('admin.partners.index')}
                            active={url.startsWith('/admin/partners')}
                            title="Mitra MBKM"
                            icon={IconBuildingSkyscraper}
                        />
                        <NavLink
                            url={route('admin.activities.index')}
                            active={url.startsWith('/admin/activities')}
                            title="Kegiatan MKBM"
                            icon={IconBriefcase}
                        />
                        <NavLink
                            url="#"
                            active={url.startsWith('/admin/request-activities')}
                            title="Pengajuan Kegiatan"
                            icon={IconScript}
                        />
                        <NavLink
                            url="#"
                            active={url.startsWith('/admin/activity-registrations')}
                            title="Pendaftaran Kegiatan"
                            icon={IconNotes}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">Akademik</div>
                        <NavLink
                            url={route('admin.courses.index')}
                            active={url.startsWith('/admin/courses')}
                            title="Mata Kuliah"
                            icon={IconBooks}
                        />
                        <NavLink
                            url={route('admin.schedules.index')}
                            active={url.startsWith('/admin/exam-schedules')}
                            title="Jadwal Ujian"
                            icon={IconCalendar}
                        />
                    </>
                )}

                {auth.roles.some((role) => ['Lecturer'].includes(role)) && (
                    <>
                        <NavLink
                            url={route('lecturers.dashboard')}
                            active={url.startsWith('/lecturers/dashboard')}
                            title="Dashboard"
                            icon={IconLayout2}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">MBKM</div>
                        <NavLink
                            url={route('lecturers.activities.index')}
                            active={url.startsWith('/lecturers/activities')}
                            title="Kegiatan MKBM"
                            icon={IconBriefcase}
                        />

                        <NavLink
                            url="#"
                            active={url.startsWith('/lecturers/activity-registrations')}
                            title="Pendaftaran Kegiatan"
                            icon={IconNotes}
                        />

                        <div className="px-3 py-2 text-xs font-medium text-white">Akademik</div>
                        <NavLink
                            url={route('lecturers.students.index')}
                            active={url.startsWith('/lecturers/students')}
                            title="Mahasiswa"
                            icon={IconUsers}
                        />
                    </>
                )}

                <div className="px-3 py-2 text-xs font-medium text-white">Lainnya</div>
                <NavLink
                    url={route('logout')}
                    method="post"
                    as="button"
                    className="w-full"
                    active={url.startsWith('/logout')}
                    title="Logout"
                    icon={IconLogout2}
                />
            </ul>
        </nav>
    );
}
