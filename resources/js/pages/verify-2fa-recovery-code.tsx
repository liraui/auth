import { TwoFactorRecoveryCard } from '../components/cards/two-factor-recovery-card';
import { Layout } from '../layout';

export default function TwoFactorRecovery() {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <TwoFactorRecoveryCard />
            </div>
        </div>
    );
}

TwoFactorRecovery.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
