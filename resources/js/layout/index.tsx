import { AuthFooter } from './footer';
import { AuthHeader } from './header';

interface LayoutProps {
    children: React.ReactNode;
}

function Layout({ children, ...props }: LayoutProps) {
    return (
        <div className="relative">
            <div className="bg-background">
                <div {...props}>
                    <div>
                        <AuthHeader />
                    </div>
                    <div className="bg-muted/35 m-2 rounded-md border">
                        <main className="relative mx-auto min-h-[calc(100svh-8rem)] max-w-7xl flex-col gap-8">{children}</main>
                    </div>
                    <div>
                        <AuthFooter />
                    </div>
                </div>
            </div>
        </div>
    );
}

export { Layout };
