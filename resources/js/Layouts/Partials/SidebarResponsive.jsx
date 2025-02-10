import NavLink from '@/Components/NavLink';
import {
    IconBooks,
    IconCalendar,
    IconCalendarTime,
    IconCircleKey,
    IconLayout2,
    IconLogout2,
    IconUser,
    IconUsers,
    IconUsersGroup,
} from '@tabler/icons-react';

export default function SidebarResponsive({ url }) {
    return (
        <nav className="mt-4 flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col">
                <NavLink url="#" active={url.startsWith('/admin/dashboard')} title="Dashboard" icon={IconLayout2} />

                <div className="px-3 py-2 text-xs font-medium text-white">Master</div>
                <NavLink
                    url="#"
                    active={url.startsWith('/admin/academic-years')}
                    title="Tahun Ajaran"
                    icon={IconCalendarTime}
                />
                <NavLink url="#" active={url.startsWith('/admin/roles')} title="Peran" icon={IconCircleKey} />

                <div className="px-3 py-2 text-xs font-medium text-white">Pengguna</div>
                <NavLink url="#" active={url.startsWith('/admin/students')} title="Mahasiswa" icon={IconUsers} />
                <NavLink url="#" active={url.startsWith('/admin/lecturers')} title="Dosen" icon={IconUsersGroup} />
                <NavLink url="#" active={url.startsWith('/admin/coordinators')} title="Coordinator" icon={IconUser} />

                <div className="px-3 py-2 text-xs font-medium text-white">Akademik</div>
                <NavLink url="#" active={url.startsWith('/admin/courses')} title="Mata Kuliah" icon={IconBooks} />
                <NavLink
                    url="#"
                    active={url.startsWith('/admin/exam-schedules')}
                    title="Jadwal Ujian"
                    icon={IconCalendar}
                />

                <div className="px-3 py-2 text-xs font-medium text-white">Lainnya</div>
                <NavLink url={route('logout')} method='post' as='button' active={url.startsWith('/logout')} title="Logout" icon={IconLogout2} />
            </ul>
        </nav>
    );
}
