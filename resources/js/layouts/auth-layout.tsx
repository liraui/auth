import { AuthHeader } from './auth-header';

interface AuthLayoutProps {
    children: React.ReactNode;
}

export function AuthLayout({ children, ...props }: AuthLayoutProps) {
    return (
        <div className="relative">
            <div className="bg-background">
                <div {...props}>
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
