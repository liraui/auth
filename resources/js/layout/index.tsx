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
                    <div className="bg-background/80 border-border sticky top-0 z-99 backdrop-blur-md">
                        <AuthHeader />
                        <div className="via-border absolute right-0 bottom-0 left-0 h-[1px] bg-gradient-to-r from-transparent to-transparent"></div>
                    </div>
                    <div className="relative mx-auto flex max-w-7xl gap-8">
                        <div className="flex-1 overflow-x-hidden">
                            <div className="max-w-full">{children}</div>
                        </div>
                    </div>
                    <div className="bg-background/80 relative backdrop-blur-md">
                        <div className="via-border absolute top-0 right-0 left-0 h-[1px] bg-gradient-to-r from-transparent to-transparent"></div>
                        <AuthFooter />
                    </div>
                </div>
            </div>
        </div>
    );
}

export { Layout };
