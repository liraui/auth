import React from 'react';
import { LoginCard } from '../components/cards/login-card';
import { Layout } from '../layout';

export default function Login() {
    return (
        <div className="flex min-h-[calc(100vh-6.5rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <LoginCard />
            </div>
        </div>
    );
}

Login.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
