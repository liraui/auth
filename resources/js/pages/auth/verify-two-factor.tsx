import { TwoFactorVerifyCard } from '../../components/cards/two-factor-verify-card';
import { AuthLayout } from '../../layouts/auth-layout';

export default function TwoFactorVerify() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <TwoFactorVerifyCard />
        </div>
    );
}

TwoFactorVerify.layout = (page: React.ReactNode) => <AuthLayout>{page}</AuthLayout>;
