import React from 'react';
import { RegisterCard } from '../components/cards/register-card';
import { Layout } from '../layout';

export default function Register() {
    return (
        <div className="absolute inset-0 flex items-center justify-center">
            <RegisterCard />
        </div>
    );
}

Register.layout = (page: React.ReactNode) => <Layout>{page}</Layout>;
