import { Button } from '@/components/ui/button';
import { disable } from '@/routes/profile/two-factor';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

export function DisableTwoFactorButton() {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);
    return (
        <>
            <Button type="button" variant="destructive" onClick={() => setShowPasswordDialog(true)}>
                Disable
            </Button>
            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={(open: boolean) => {
                    setShowPasswordDialog(open);
                }}
                title="Disable two-factor authentication"
                description="Please confirm your password before disabling two-factor authentication. This will remove the additional security layer from your account."
                form={disable.form()}
                success={() => setShowPasswordDialog(false)}
                confirmButtonText="Disable"
                confirmButtonVariant="destructive"
            />
        </>
    );
}
