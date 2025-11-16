import { disableTwoFactor } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { CircleOffIcon } from 'lucide-react';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

export function DisableTwoFactorButton() {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    return (
        <>
            <Button variant={'destructive'} type="button" onClick={() => setShowPasswordDialog(true)}>
                <CircleOffIcon /> Disable
            </Button>
            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={(open: boolean) => {
                    setShowPasswordDialog(open);
                }}
                title="Disable two-factor authentication"
                description="Please confirm your password before disabling two-factor authentication. This will remove the additional security layer from your account."
                form={disableTwoFactor.form()}
                success={() => setShowPasswordDialog(false)}
                confirmButtonText="Disable"
                confirmButtonVariant="destructive"
            />
        </>
    );
}
