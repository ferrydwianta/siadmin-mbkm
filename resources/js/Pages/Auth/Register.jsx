import ApplicationLogo from '@/Components/ApplicationLogo';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import { Button } from '@/Components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import GuestLayout from '@/Layouts/GuestLayout';
import { Link, useForm } from '@inertiajs/react';
import { useRef } from 'react';

export default function Register(props) {
    const fileInputAvatar = useRef(null);
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        avatar: null,
        student_number: '',
        semester: 5,
        batch: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('register'), {
            reserveScroll: true,
            preserveState: true,
        });
    };
    const onHandleChange = (e) => setData(e.target.name, e.target.value);

    return (
        <GuestLayout>
            <div className="h-screen w-full overflow-hidden lg:grid lg:grid-cols-2">
                <div className="fixed left-0 top-0 hidden h-screen w-1/2 bg-muted lg:block">
                    <img src="/images/bg-register.jpg" alt="Login" className="h-full w-full object-cover" />
                </div>

                <div className="flex h-screen flex-col overflow-y-auto px-6 py-4 lg:col-start-2">
                    <ApplicationLogo logo="/images/logo-mbkm.webp" />

                    <div className="flex flex-col items-center justify-center py-12 lg:py-16">
                        <div className="mx-auto flex w-full flex-col gap-6 lg:w-9/12">
                            {/* Login Heading */}
                            <div className="grid gap-2 text-center">
                                <h1 className="text-3xl font-bold text-foreground">Register</h1>
                                <p className="text-balance text-muted-foreground">
                                    Masukkan informasi mahasiswa anda untuk mendaftar!
                                </p>
                            </div>

                            {/* Register Form */}
                            <form onSubmit={submit} className="grid grid-cols-1 gap-4 lg:grid-cols-4">
                                <div className="col-span-full">
                                    <InputLabel htmlFor="name" value="Nama" />
                                    <TextInput
                                        id="name"
                                        name="name"
                                        value={data.name}
                                        className="mt-1 block w-full"
                                        autoComplete="name"
                                        onChange={onHandleChange}
                                        required
                                    />
                                    <InputError message={errors.name} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        className="mt-1 block w-full"
                                        autoComplete="username"
                                        onChange={onHandleChange}
                                        required
                                    />
                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="password" value="Password" />
                                    <TextInput
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        className="mt-1 block w-full"
                                        autoComplete="new-password"
                                        onChange={onHandleChange}
                                        required
                                    />
                                    <InputError message={errors.password} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="student_number" value="Nomor Induk Mahasiswa (NIM)" />
                                    <TextInput
                                        id="student_number"
                                        name="student_number"
                                        value={data.student_number}
                                        className="mt-1 block w-full"
                                        onChange={onHandleChange}
                                        required
                                    />
                                    <InputError message={errors.student_number} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="semester" value="Semester" />
                                    <Select
                                        defaultValue={String(data.semester)}
                                        onValueChange={(value) => setData('semester', value)}
                                    >
                                        <SelectTrigger className="mt-1 h-11 rounded-md border-gray-300">
                                            <SelectValue>{data.semester || 'Pilih Semester'}</SelectValue>
                                        </SelectTrigger>

                                        <SelectContent>
                                            {[5, 6, 7, 8].map((value) => (
                                                <SelectItem key={value} value={String(value)}>
                                                    {value}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.semester} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="batch" value="Angkatan" />
                                    <TextInput
                                        type="number"
                                        id="batch"
                                        name="batch"
                                        value={data.batch}
                                        className="mt-1 block w-full"
                                        onChange={onHandleChange}
                                        required
                                    />
                                    <InputError message={errors.batch} className="mt-2" />
                                </div>

                                <div className="col-span-2 mt-4">
                                    <InputLabel htmlFor="avatar" value="Photo Profile" />
                                    <TextInput
                                        type="file"
                                        id="avatar"
                                        name="avatar"
                                        className="mt-1 block w-full rounded-md border border-gray-300 p-1.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        onChange={(e) => setData(e.target.name, e.target.files[0])}
                                        ref={fileInputAvatar}
                                    />
                                    <InputError message={errors.avatar} className="mt-2" />
                                </div>

                                {/* Submit Button */}
                                <div className="col-span-full flex flex-col items-center gap-4">
                                    <Button
                                        type="submit"
                                        variant="blue"
                                        size="xl"
                                        className="mt-4 w-full"
                                        disabled={processing}
                                    >
                                        Daftar
                                    </Button>

                                    <Link
                                        href={route('login')}
                                        className="w-full text-center text-sm font-medium text-black hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Sudah punya akun? <span className="text-blue-600">Masuk</span>
                                    </Link>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
