import React from 'react';
import { ResetPasswordCard } from '../components/cards/reset-password-card';
import { Layout } from '../layout';

export default function ResetPassword({ token, email }: { token: string; email: string }) {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <ResetPasswordCard token={token} email={email} />
            </div>
        </div>
    );
}

ResetPassword.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
