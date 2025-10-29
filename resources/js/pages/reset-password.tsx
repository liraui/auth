import React from 'react';
import { ResetPasswordCard } from '../components/cards/reset-password-card';
import { Layout } from '../layout';

export default function ResetPassword({ token, email }: { token: string; email: string }) {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <ResetPasswordCard token={token} email={email} />
        </div>
    );
}

ResetPassword.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
