import { Logo } from '@/components/ui/logo';
import { Link } from '@inertiajs/react';

function AuthFooter() {
    return (
        <footer className="flex h-12 items-center">
            <div className="grow">
                <div className="mx-auto flex h-12 max-w-7xl items-center px-8">
                    <div className="flex gap-8">
                        <Link href="/" className="flex items-center">
                            <Logo variant="primary" />
                        </Link>
                    </div>
                </div>
            </div>
        </footer>
    );
}

export { AuthFooter };
