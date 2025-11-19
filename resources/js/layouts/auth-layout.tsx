import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { AuthLayoutProps } from '../types';
import { AuthHeader } from './auth-header';

export function AuthLayout({ children }: AuthLayoutProps) {
    const { flash } = usePage<SharedData>().props;

    if (flash && flash.type === 'success' && flash.message) {
        toast.success(flash.message, {
            position: 'bottom-center',
        });
    }

    return (
        <div className="relative">
            <div className="bg-background">
                <div>
                    <div className="bg-background/80 border-border sticky top-0 z-99 backdrop-blur-md">
                        <AuthHeader />
                        <div className="via-border absolute right-0 bottom-0 left-0 h-px bg-linear-to-r from-transparent to-transparent"></div>
                    </div>
                    <div>
                        <main className="relative mx-auto min-h-[calc(100svh-8rem)] max-w-7xl flex-col gap-8">{children}</main>
                    </div>
                </div>
            </div>
        </div>
    );
}
