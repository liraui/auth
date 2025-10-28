import React from 'react';
import { ForgotPasswordCard } from '../components/cards/forgot-password-card';
import { Layout } from '../layout';

export default function ForgotPassword({ status }: { status?: string }) {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <ForgotPasswordCard status={status} />
            </div>
        </div>
    );
}

ForgotPassword.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
