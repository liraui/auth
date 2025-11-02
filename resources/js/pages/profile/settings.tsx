import { DashboardLayout } from '@/components/layouts/dashboard';
import { ProfileNavigation } from '@/components/navigations/profile-navigation';
import { BrowserSessionsForm } from '../../components/forms/browser-sessions-form';
import { ChangePasswordForm } from '../../components/forms/change-password-form';
import { DeleteAccountForm } from '../../components/forms/delete-account-form';
import { ProfileInformationForm } from '../../components/forms/profile-information-form';
import { TwoFactorForm } from '../../components/forms/two-factor-form';

export default function Settings() {
    return (
        <div>
            <ProfileNavigation />
            <div className="mx-auto my-8 flex max-w-7xl flex-col gap-8">
                <ProfileInformationForm />
                <ChangePasswordForm />
                <TwoFactorForm />
                <BrowserSessionsForm />
                <DeleteAccountForm />
            </div>
        </div>
    );
}

Settings.layout = (page: React.ReactNode) => <DashboardLayout>{page}</DashboardLayout>;
