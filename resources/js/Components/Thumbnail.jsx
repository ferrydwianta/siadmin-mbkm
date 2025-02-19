import * as AvatarPrimitive from '@radix-ui/react-avatar';
import * as React from 'react';

import { cn } from '@/lib/utils';

const Thumbnail = React.forwardRef(({ className, ...props }, ref) => (
    <AvatarPrimitive.Root
        ref={ref}
        className={cn('relative flex shrink-0 overflow-hidden rounded-md', className)}
        {...props}
    />
));
Thumbnail.displayName = AvatarPrimitive.Root.displayName;

const ThumbnailImage = React.forwardRef(({ className, ...props }, ref) => (
    <AvatarPrimitive.Image ref={ref} className={cn('aspect-square h-full w-full', className)} {...props} />
));
ThumbnailImage.displayName = AvatarPrimitive.Image.displayName;

const ThumbnailFallback = React.forwardRef(({ className, ...props }, ref) => (
    <AvatarPrimitive.Fallback
        ref={ref}
        className={cn('flex h-full w-full items-center justify-center rounded-md bg-muted text-blue-600', className)}
        {...props}
    />
));
ThumbnailFallback.displayName = AvatarPrimitive.Fallback.displayName;

export { Thumbnail, ThumbnailFallback, ThumbnailImage };
