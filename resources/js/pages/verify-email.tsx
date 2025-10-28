import React from 'react';
import { VerifyEmailCard } from '../components/cards/verify-email-card';
import { Layout } from '../layout';

export default function VerifyEmail({ email, status }: { email: string; status?: string }) {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <VerifyEmailCard email={email} status={status} />
            </div>
        </div>
    );
}

VerifyEmail.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
