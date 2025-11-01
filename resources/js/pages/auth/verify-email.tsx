import React from 'react';
import { VerifyEmailCard } from '../../components/cards/verify-email-card';
import { AuthLayout } from '../../layouts/auth-layout';

export default function VerifyEmail({ email, status }: { email: string; status?: string }) {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <VerifyEmailCard email={email} status={status} />
        </div>
    );
}

VerifyEmail.layout = (page: React.ReactNode) => <AuthLayout>{page}</AuthLayout>;
