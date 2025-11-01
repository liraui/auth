import { Logo } from '@/components/ui/logo';
import { Link } from '@inertiajs/react';

export function AuthHeader() {
    return (
        <header className="flex h-12 items-center">
            <div className="grow">
                <div className="mx-auto flex h-12 max-w-7xl items-center">
                    <div className="flex items-center gap-16">
                        <Link href="/" className="flex items-center">
                            <Logo variant="primary" withText />
                        </Link>
                    </div>
                    <div className="grow" />
                </div>
            </div>
        </header>
    );
}
