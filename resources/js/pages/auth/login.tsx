import React from 'react';
import { LoginCard } from '../../components/cards/login-card';
import { AuthLayout } from '../../layouts/auth-layout';

export default function Login() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <LoginCard />
        </div>
    );
}

Login.layout = (page: React.ReactNode) => <AuthLayout>{page}</AuthLayout>;
