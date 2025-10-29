import React from 'react';
import { ForgotPasswordCard } from '../components/cards/forgot-password-card';
import { Layout } from '../layout';

export default function ForgotPassword({ status }: { status?: string }) {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <ForgotPasswordCard status={status} />
        </div>
    );
}

ForgotPassword.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
