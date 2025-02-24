import { router } from '@inertiajs/react';
import { clsx } from 'clsx';
import { format, parseISO } from 'date-fns';
import { id } from 'date-fns/locale';
import { toast } from 'sonner';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function flashMessage(params) {
    return params.props.flash_message;
}

export const deleteAction = (url, { closeModal, ...options } = {}) => {
    const defaultOptions = {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (success) => {
            const flash = flashMessage(success);
            if (flash) {
                toast[flash.type](flash.message);
            }

            if (closeModal && typeof closeModal == 'function') {
                closeModal();
            }
        },
        ...options,
    };
    router.delete(url, defaultOptions);
};

export const formatDateIndo = (dateString) => {
    return format(parseISO(dateString), 'eeee, dd MMMM yyyy', { locale: id });
};

export const STUDENTSTATUS = {
    PENDING: 'Pending',
    REJECT: 'Reject',
    APPROVED: 'Approve',
};

export const STUDENTSTATUSVARIANT = {
    [STUDENTSTATUS.PENDING]: 'secondary',
    [STUDENTSTATUS.REJECT]: 'destructive',
    [STUDENTSTATUS.APPROVED]: 'default',
};
