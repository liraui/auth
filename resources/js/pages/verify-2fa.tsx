import { TwoFactorVerifyCard } from '../components/cards/two-factor-verify-card';
import { Layout } from '../layout';

export default function TwoFactorVerify() {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <TwoFactorVerifyCard />
            </div>
        </div>
    );
}

TwoFactorVerify.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
