import { TwoFactorRecoveryCard } from '../components/cards/two-factor-recovery-card';
import { Layout } from '../layout';

export default function TwoFactorRecovery() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <TwoFactorRecoveryCard />
        </div>
    );
}

TwoFactorRecovery.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
