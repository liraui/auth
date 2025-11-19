import { ProfileNavigation } from '@/components/navigation/profile-navigation';
import { DashboardShell } from '@/layouts/dashboard-shell';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { BrowserSessionsForm } from '../../components/forms/browser-sessions-form';
import { ChangePasswordForm } from '../../components/forms/change-password-form';
import { DeleteAccountForm } from '../../components/forms/delete-account-form';
import { ProfileInformationForm } from '../../components/forms/profile-information-form';
import { TwoFactorForm } from '../../components/forms/two-factor-form';

export default function Settings() {
    const variant = usePage<SharedData>().props.dashboard.shell || 'default';

    return (
        <div>
            {variant === 'default' && <ProfileNavigation />}
            <div className="flex w-full flex-col gap-8 px-8 py-8">
                <ProfileInformationForm />
                <ChangePasswordForm />
                <TwoFactorForm />
                <BrowserSessionsForm />
                <DeleteAccountForm />
            </div>
        </div>
    );
}

Settings.layout = (page: React.ReactNode) => (
    <DashboardShell
        breadcrumbs={[
            { label: 'My account', href: '#' },
            { label: 'Settings', href: '#' },
        ]}
    >
        {page}
    </DashboardShell>
);
