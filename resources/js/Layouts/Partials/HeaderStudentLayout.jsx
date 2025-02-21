import ApplicationLogo from '@/Components/ApplicationLogo';
import NavigationMenu from '@/Components/NavigationMenu';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Button } from '@/Components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { cn } from '@/lib/utils';
import { Disclosure } from '@headlessui/react';
import { Link } from '@inertiajs/react';
import { IconChevronCompactDown, IconLayoutSidebar, IconLogout2, IconX } from '@tabler/icons-react';

export default function HeaderStudentLayout({ auth, url }) {
    return (
        <>
            <Disclosure
                as="nav"
                className="border-blue300 border-b border-opacity-25 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 py-4 lg:border-none"
            >
                {({ open }) => (
                    <>
                        <div className="px-6 lg:px-24">
                            <div className="relative flex h-16 items-center justify-between">
                                <div className="flex items-center">
                                    <ApplicationLogo logo="/images/logo-mbkm-white.webp" />
                                </div>

                                <div className="flex lg:hidden">
                                    {/* mobile */}
                                    <Disclosure.Button className="focus:outline-non relative inline-flex items-center justify-center rounded-xl p-2 text-white hover:text-white">
                                        <span className="absolute -inset-0.5" />
                                        {open ? (
                                            <IconX className="block size-6" />
                                        ) : (
                                            <IconLayoutSidebar className="block size-6" />
                                        )}
                                    </Disclosure.Button>
                                </div>

                                <div className="hidden lg:ml-4 lg:block">
                                    <div className="flex items-center">
                                        <div className="hidden lg:mx-10 lg:block">
                                            <div className="flex space-x-4">
                                                <NavigationMenu
                                                    url={route('students.dashboard')}
                                                    active={url.startsWith('/students/dashboard')}
                                                    title="Dashboard"
                                                />
                                                <NavigationMenu
                                                    url={route('students.activities.index')}
                                                    active={url.startsWith('/students/activities')}
                                                    title="Kegiatan MBKM"
                                                />
                                                <NavigationMenu
                                                    url={route('students.activity-registrations.index')}
                                                    active={url.startsWith('/students/activity-registration')}
                                                    title="KegiatanKu"
                                                />
                                            </div>
                                        </div>

                                        {/* profile dropdown */}
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button
                                                    variant="blue"
                                                    size="xl"
                                                    className="data-[state=open]:bg-orange-500 data-[state=open]:text-white"
                                                >
                                                    <Avatar className="size-8 rounded-lg">
                                                        <AvatarImage src={auth.avatar} />
                                                        <AvatarFallback className="rounded-lg text-blue-600">
                                                            {auth.name.substring(0, 1)}
                                                        </AvatarFallback>
                                                    </Avatar>

                                                    <div className="grid flex-1 text-left text-sm leading-tight">
                                                        <span className="truncate font-semibold">{auth.name}</span>
                                                        <span className="truncate text-xs">
                                                            {auth.student.student_number}
                                                        </span>
                                                    </div>

                                                    <IconChevronCompactDown className="ml-auto size-4" />
                                                </Button>
                                            </DropdownMenuTrigger>

                                            <DropdownMenuContent
                                                className="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                                side="bottom"
                                                align="end"
                                                sideOffset={4}
                                            >
                                                <DropdownMenuLabel className="p-0 font-normal">
                                                    <div className="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                                        <Avatar className="size-8 rounded-lg">
                                                            <AvatarImage src={auth.avatar} />
                                                            <AvatarFallback className="rounded-lg text-blue-600">
                                                                {auth.name.substring(0, 1)}
                                                            </AvatarFallback>
                                                        </Avatar>

                                                        <div className="grid flex-1 text-left text-sm leading-tight">
                                                            <span className="truncate font-semibold">{auth.name}</span>
                                                            <span className="truncate text-xs">
                                                                {auth.student.student_number}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </DropdownMenuLabel>

                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem asChild>
                                                    <Link
                                                        href={route('logout')}
                                                        method="post"
                                                        as="button"
                                                        className="w-full"
                                                    >
                                                        <IconLogout2 />
                                                        Logout
                                                    </Link>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Disclosure.Panel className="lg:hidden">
                            {/* mobile */}
                            <div className="space-y-1 px-2 pb-3 pt-2">
                                <Disclosure.Button
                                    as="a"
                                    href={route('students.dashboard')}
                                    className={cn(
                                        url.startsWith('/students/dashboard')
                                            ? 'bg-blue-500 text-white'
                                            : 'text-white hover:bg-blue-500',
                                        'block rounded-md px-3 py-2 text-base font-medium',
                                    )}
                                >
                                    Dashboard
                                </Disclosure.Button>

                                <Disclosure.Button
                                    as="a"
                                    href={route('students.activities.index')}
                                    className={cn(
                                        url.startsWith('/students/activities')
                                            ? 'bg-blue-500 text-white'
                                            : 'text-white hover:bg-blue-500',
                                        'block rounded-md px-3 py-2 text-base font-medium',
                                    )}
                                >
                                    Kegiatan MBKM
                                </Disclosure.Button>

                                <Disclosure.Button
                                    as="a"
                                    href={route('students.activity-registrations.index')}
                                    className={cn(
                                        url.startsWith('/students/activity-registration')
                                            ? 'bg-blue-500 text-white'
                                            : 'text-white hover:bg-blue-500',
                                        'block rounded-md px-3 py-2 text-base font-medium',
                                    )}
                                >
                                    KegiatanKu
                                </Disclosure.Button>

                                <div className="pb-3 pt-4">
                                    <div className="flex items-center px-5">
                                        <div className="flex-shrink-0">
                                            <Avatar>
                                                <AvatarImage src={auth.avatar} />
                                                <AvatarFallback>{auth.name.substring(0, 1)}</AvatarFallback>
                                            </Avatar>
                                        </div>

                                        <div className="ml-3">
                                            <div className="text-base font-medium text-white">{auth.name}</div>
                                            <div className="text-sm font-medium text-white">
                                                {auth.student.student_number}
                                            </div>
                                        </div>
                                    </div>

                                    <div className="mt-3 space-y-1 px-0">
                                        <Link
                                            href={route('logout')}
                                            method="post"
                                            as="button"
                                            className="block w-full rounded-md px-3 py-2 text-left text-base font-medium text-white hover:bg-blue-500"
                                        >
                                            Logout
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </Disclosure.Panel>
                    </>
                )}
            </Disclosure>

            <header className="py-6"></header>
        </>
    );
}
