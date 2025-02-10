import ApplicationLogo from "@/Components/ApplicationLogo";
import NavigationMenu from "@/Components/NavigationMenu";
import { Avatar, AvatarFallback } from "@/Components/ui/avatar";
import { Button } from "@/Components/ui/button";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "@/Components/ui/dropdown-menu";
import { cn } from "@/lib/utils";
import { Disclosure } from "@headlessui/react";
import { Link } from "@inertiajs/react";
import { IconChevronCompactDown, IconLayoutSidebar, IconLogout2, IconX } from "@tabler/icons-react";

export default function HeaderStudentLayout({url}) {
    return(
        <>
            <Disclosure
                as='nav'
                className='py-4 border-b border-blue300 border-opacity-25 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 lg:border-none'
            >
                {({ open }) => (
                    <>
                        <div className="px-6 lg:px-24">
                            <div className="relative flex items-center justify-between h-16">
                                <div className="flex items-center">
                                    <ApplicationLogo
                                        bgLogo='from-orange-500 via-orange-600 to-orange-600'
                                        colorLogo='text-white'
                                        colorText='text-white'
                                    />
                                </div>

                                <div className="flex lg:hidden">
                                    {/* mobile */} 
                                    <Disclosure.Button className='relative inline-flex items-center justify-center p-2 text-white rounded-xl hover:text-white focus:outline-non'>
                                        <span className="absolute -inset-0.5"/>
                                        { open ? (
                                            <IconX className="block size-6"/>
                                        ) : (
                                            <IconLayoutSidebar className="block size-6"/>
                                        )}
                                    </Disclosure.Button>
                                </div>

                                <div className="hidden lg:ml-4 lg:block">
                                    <div className="flex items-center">
                                        <div className="hidden lg:mx-10 lg:block">
                                            <div className="flex space-x-4">
                                                <NavigationMenu
                                                    url='#'
                                                    active={url.startsWith('students/dashboard')}
                                                    title='Dashboard'
                                                />
                                                <NavigationMenu
                                                    url='#'
                                                    active={url.startsWith('students/activities')}
                                                    title='Kegiatan MBKM'
                                                />
                                                <NavigationMenu
                                                    url='#'
                                                    active={url.startsWith('students/activity-registration')}
                                                    title='Kegiatan Aktif'
                                                />
                                                <NavigationMenu
                                                    url='#'
                                                    active={url.startsWith('students/exam-schedules')}
                                                    title='Jadwal Ujian'
                                                />
                                            </div>
                                        </div>

                                        {/* profile dropdown */}
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button
                                                    variant='blue'
                                                    size='xl'
                                                    className="data-[state=open]:bg-orange-500 data-[state=open]:text-white"
                                                >
                                                    <Avatar className='size-8 rounded-lg'>
                                                        <AvatarFallback className='text-blue-600 rounded-lg'>X</AvatarFallback>
                                                    </Avatar>

                                                    <div className="grid flex-1 text-sm leading-tight text-left">
                                                        <span className="font-semibold truncate">Full name</span>
                                                        <span className="text-xs truncate">fullname@gmail.com</span>
                                                    </div>

                                                    <IconChevronCompactDown className="ml-auto size-4"/>
                                                </Button>
                                            </DropdownMenuTrigger>

                                            <DropdownMenuContent
                                                className='w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg'
                                                side='bottom'
                                                align='end'
                                                sideOffset={4}
                                            >
                                                <DropdownMenuLabel className='p-0 font-normal'>
                                                    <div className="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                                        <Avatar className='size-8 rounded-lg'>
                                                            <AvatarFallback className='text-blue-600 rounded-lg'>
                                                                X
                                                            </AvatarFallback>
                                                        </Avatar>

                                                        <div className="grid flex-1 text-sm leading-tight text-left">
                                                            <span className="font-semibold truncate">Full name</span>
                                                            <span className="text-xs truncate">fullname@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </DropdownMenuLabel>

                                                <DropdownMenuSeparator/>
                                                <DropdownMenuItem asChild>
                                                    <Link
                                                        href={route('logout')}
                                                        method='post'
                                                        as='button'
                                                    >
                                                        <IconLogout2/>
                                                        Logout
                                                    </Link>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Disclosure.Panel className='lg:hidden'>
                            {/* mobile */}
                            <div className="px-2 pt-2 pb-3 space-y-1">
                                <Disclosure.Button
                                    as='a'
                                    href='#'
                                    className={cn(
                                        url.startsWith('/students/dashboard')
                                        ? 'bg-blue-500 text-white'
                                        : 'text-white hover:bg-blue-500',
                                    'block rounded-md px-3 py-2 text-base font-medium'
                                    )}
                                >
                                    Dashboard
                                </Disclosure.Button>

                                <Disclosure.Button
                                    as='a'
                                    href='#'
                                    className={cn(
                                        url.startsWith('/students/activities')
                                        ? 'bg-blue-500 text-white'
                                        : 'text-white hover:bg-blue-500',
                                    'block rounded-md px-3 py-2 text-base font-medium'
                                    )}
                                >
                                    Kegiatan MBKM
                                </Disclosure.Button>

                                <Disclosure.Button
                                    as='a'
                                    href='#'
                                    className={cn(
                                        url.startsWith('/students/activity-registration')
                                        ? 'bg-blue-500 text-white'
                                        : 'text-white hover:bg-blue-500',
                                    'block rounded-md px-3 py-2 text-base font-medium'
                                    )}
                                >
                                    Kegiatan Aktif
                                </Disclosure.Button>

                                <Disclosure.Button
                                    as='a'
                                    href='#'
                                    className={cn(
                                        url.startsWith('/students/exam-schedules')
                                        ? 'bg-blue-500 text-white'
                                        : 'text-white hover:bg-blue-500',
                                    'block rounded-md px-3 py-2 text-base font-medium'
                                    )}
                                >
                                    Jadwal Ujian
                                </Disclosure.Button>

                                <div className="pt-4 pb-3">
                                    <div className="flex items-center px-5">
                                        <div className="flex-shrink-0">
                                            <Avatar>
                                                <AvatarFallback>X</AvatarFallback>
                                            </Avatar>
                                        </div>

                                        <div className="ml-3">
                                            <div className="text-base font-medium text-white">Full name</div>
                                            <div className="text-sm font-medium text-white">fullname@gmail.com</div>
                                        </div>
                                    </div>

                                    <div className="px-2 mt-3 space-y-1">
                                        <Disclosure.Button
                                            as='button'
                                            href={route('logout')}
                                            method='post'
                                            className='block px-3 py-2 text-base font-medium text-white rounded-md hover:bg-blue-500'
                                        >
                                            Logout
                                        </Disclosure.Button>
                                    </div>
                                </div>
                            </div>
                        </Disclosure.Panel>
                    </>
                )}
            </Disclosure>
            
            <header className="py-6"></header>
        </>
    )
}