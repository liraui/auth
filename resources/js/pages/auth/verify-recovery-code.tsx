import { TwoFactorRecoveryCard } from '../../components/cards/two-factor-recovery-card';
import { AuthLayout } from '../../layouts/auth-layout';

export default function TwoFactorRecovery() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <TwoFactorRecoveryCard />
        </div>
    );
}

TwoFactorRecovery.layout = (page: React.ReactNode) => <AuthLayout>{page}</AuthLayout>;
