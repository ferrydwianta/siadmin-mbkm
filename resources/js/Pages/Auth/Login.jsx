import ApplicationLogo from '@/Components/ApplicationLogo';
import InputError from '@/Components/InputError';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Checkbox } from '@/Components/ui/checkbox';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import GuestLayout from '@/Layouts/GuestLayout';
import { useForm } from '@inertiajs/react';

export default function Login({ status }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('login'), { onFinish: () => reset('password') });
    };

    return (
        <div className="h-screen w-full overflow-hidden lg:grid lg:grid-cols-2">
            {/* Left Section */}
            <div className="flex flex-col px-6 py-4">
                <ApplicationLogo logo="/images/logo-mbkm.webp" />

                <div className="flex flex-col items-center justify-center py-12 lg:py-24">
                    <div className="mx-auto flex w-full flex-col gap-6 lg:w-1/2">
                        {/* Status Alert */}
                        {status && (
                            <Alert variant="success">
                                <AlertDescription>{status}</AlertDescription>
                            </Alert>
                        )}

                        {/* Login Heading */}
                        <div className="grid gap-2 text-center">
                            <h1 className="text-3xl font-bold text-foreground">Masuk</h1>
                            <p className="text-balance text-muted-foreground">
                                Masukkan email anda untuk masuk ke akun anda!
                            </p>
                        </div>

                        {/* Login Form */}
                        <form onSubmit={handleSubmit} className="grid gap-4">
                            <FormInput
                                id="email"
                                type="email"
                                name="email"
                                label="Email"
                                value={data.email}
                                placeholder="email@email.com"
                                autoComplete="username"
                                onChange={(e) => setData('email', e.target.value)}
                                error={errors.email}
                            />

                            <FormInput
                                id="password"
                                type="password"
                                name="password"
                                label="Password"
                                value={data.password}
                                autoComplete="current-password"
                                onChange={(e) => setData('password', e.target.value)}
                                error={errors.password}
                            />

                            {/* Remember Me Checkbox */}
                            <div className="items-top flex space-x-2">
                                <Checkbox
                                    id="remember"
                                    name="remember"
                                    checked={data.remember}
                                    onCheckedChange={(checked) => setData('remember', checked)}
                                />
                                <Label htmlFor="remember">Ingat saya</Label>
                            </div>
                            {errors.remember && <InputError message={errors.remember} />}

                            {/* Submit Button */}
                            <Button type="submit" variant="blue" size="xl" className="w-full" disabled={processing}>
                                Masuk
                            </Button>
                        </form>
                    </div>
                </div>
            </div>

            {/* Right Section */}
            <div className="hidden overflow-hidden bg-muted lg:block">
                <img src="/images/bg-login.webp" alt="Login" className="h-full w-full object-cover" />
            </div>
        </div>
    );
}

// Higher-order layout function
Login.layout = (page) => <GuestLayout children={page} title="Login" />;

// Reusable Form Input Component
function FormInput({ id, type, name, label, value, placeholder, autoComplete, onChange, error }) {
    return (
        <div className="grid gap-2">
            <Label htmlFor={id}>{label}</Label>
            <Input
                id={id}
                type={type}
                name={name}
                value={value}
                placeholder={placeholder}
                autoComplete={autoComplete}
                onChange={onChange}
            />
            {error && <InputError message={error} />}
        </div>
    );
}
