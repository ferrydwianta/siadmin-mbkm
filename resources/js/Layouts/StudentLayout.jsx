import { Card, CardContent } from "@/Components/ui/card";
import { Toaster } from "@/Components/ui/toaster";
import { Head, usePage } from "@inertiajs/react";
import { flashMessage } from '@/lib/utils';
import { toast } from 'sonner';
import HeaderStudentLayout from "./Partials/HeaderStudentLayout";
import { useEffect } from 'react';

export default function StudentLayout({children, title}) {
    const { url } = usePage();
    const flash = flashMessage(usePage());

    useEffect(() => {
        if (flash && flash.message && flash.type == 'warning') toast[flash.type](flash.message);
    }, [flash]);

    return(
        <>
            <Head title={title}/>
            <Toaster position='top-center' richColors/>
            <div className="min-h-full">
                <div className="pb-32 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700">
                    {/* Header layout */}
                    <HeaderStudentLayout url={url}/>
                </div>

                <main className="px-6 pb-12 -mt-32 lg:px-28">
                    <Card>
                        <CardContent className='p-6'>
                            {children}
                        </CardContent>
                    </Card>
                </main>
            </div>
        </>
    )
}