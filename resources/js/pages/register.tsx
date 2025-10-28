import React from 'react';
import { RegisterCard } from '../components/cards/register-card';
import { Layout } from '../layout';

export default function Register() {
    return (
        <div className="flex min-h-[calc(100vh-7rem)] w-full items-center justify-center px-4">
            <div className="w-full max-w-md">
                <RegisterCard />
            </div>
        </div>
    );
}

Register.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
