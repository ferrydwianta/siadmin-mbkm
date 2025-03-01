import HeaderTitle from '@/Components/HeaderTitle';
import { Button } from '@/Components/ui/button';
import StudentLayout from '@/Layouts/StudentLayout';
import { flashMessage } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import { IconArrowLeft, IconHistory, IconNotes } from '@tabler/icons-react';
import { toast } from 'sonner';

export default function Create(props) {
    const { data, setData, post, reset, errors, processing } = useForm({
        conversions: [],
        member_type: null,
        _method: props.page_settings._method,
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

    const onHandleReset = () => {
        reset();
    };

    return (
        <div className="flex w-full flex-col gap-y-5">
            <div className="mb-0 flex flex-col items-start justify-between gap-y-4 pb-6 lg:flex-row lg:items-center">
                <HeaderTitle
                    title={props.page_settings.title}
                    subtitle={props.page_settings.subtitle}
                    icon={IconNotes}
                />

                <div className="space-x-3">
                    <Button variant="default" size="xl" className="w-full lg:w-auto" asChild>
                        <Link href={route('students.activities.index')}>
                            <IconHistory className="size-4" />
                            Riwayat
                        </Link>
                    </Button>

                    <Button variant="orange" size="xl" className="w-full lg:w-auto" asChild>
                        <Link href={route('students.activities.index')}>
                            <IconArrowLeft className="size-4" />
                            Kembali
                        </Link>
                    </Button>
                </div>
            </div>
        </div>
    );
}

Create.layout = (page) => <StudentLayout children={page} title={page.props.page_settings.title} />;
