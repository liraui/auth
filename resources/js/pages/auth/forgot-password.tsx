import React from 'react';
import { ForgotPasswordCard } from '../../components/cards/forgot-password-card';
import { AuthLayout } from '../../layouts/auth-layout';

export default function ForgotPassword() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <ForgotPasswordCard />
        </div>
    );
}

ForgotPassword.layout = (page: React.ReactNode) => <AuthLayout>{page}</AuthLayout>;
