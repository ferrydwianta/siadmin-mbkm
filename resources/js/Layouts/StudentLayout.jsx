import { Card, CardContent } from '@/Components/ui/card';

import { Toaster } from '@/Components/ui/sonner';
import { Head, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import HeaderStudentLayout from './Partials/HeaderStudentLayout';

export default function StudentLayout({ children, title }) {
    const { url } = usePage();
    const auth = usePage().props.auth.user;

    const { flash_message } = usePage().props;

    useEffect(() => {
        if (flash_message && flash_message.message && flash_message.type) {
            toast[flash_message.type](flash_message.message);
        }
    }, [flash_message]);

    return (
        <>
            <Head title={title} />
            <Toaster position="top-center" richColors />
            <div className="min-h-full">
                <div className="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 pb-32">
                    {/* Header layout */}
                    <HeaderStudentLayout auth={auth} url={url} />
                </div>

                <main className="-mt-32 px-6 pb-12 lg:px-28">
                    <Card>
                        <CardContent className="p-6">{children}</CardContent>
                    </Card>
                </main>
            </div>
        </>
    );
}
