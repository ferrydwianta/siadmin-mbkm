import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';

export default function ApplicationLogo({ logo, colorText }) {
    return (
        <Link href="#" className={cn('flex flex-row items-center gap-x-4')}>
            <div className="flex items-center">
                <img src={'/images/logo-si.webp'} alt="Logo SI" width={50} height={50} className="object-contain" />
            </div>

            <div className="flex items-center">
                <img src={logo} alt="Logo MBKM" width={80} height={80} className="object-contain" />
            </div>

            {/* <div className={cn('grid flex-1 text-left leading-tight', colorText)}>
                <span className="truncate font-bold">Prodi Sistem Informasi</span>
                <span className="truncate text-xs tracking-tighter">UPN "Veteran" Yogyakarta - MBKM</span>
            </div> */}
        </Link>
    );
}
