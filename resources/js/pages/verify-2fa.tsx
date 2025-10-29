import { TwoFactorVerifyCard } from '../components/cards/two-factor-verify-card';
import { Layout } from '../layout';

export default function TwoFactorVerify() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <TwoFactorVerifyCard />
        </div>
    );
}

TwoFactorVerify.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
