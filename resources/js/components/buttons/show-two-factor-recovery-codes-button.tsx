import { showRecoveryCodes } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

interface ShowTwoFactorRecoveryCodesButtonProps {
    setRecoveryCodes: (codes: string[]) => void;
    setShowRecoveryCodes: (show: boolean) => void;
}

export function ShowTwoFactorRecoveryCodesButton({ setRecoveryCodes, setShowRecoveryCodes }: ShowTwoFactorRecoveryCodesButtonProps) {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    const handleSuccess = (page: any) => {
        const { flash } = page.props;

        setShowPasswordDialog(false);

        if (flash.recoveryCodes) {
            setRecoveryCodes(flash.recoveryCodes);
            setShowRecoveryCodes(true);
        }
    };

    return (
        <>
            <Button type="button" onClick={() => setShowPasswordDialog(true)}>
                Show Recovery Codes
            </Button>

            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={(open: boolean) => {
                    setShowPasswordDialog(open);
                }}
                title="Show recovery codes"
                description="Please confirm your password before viewing your recovery codes. These codes can be used to recover access to your account if you lose your two-factor authentication device."
                form={showRecoveryCodes.form()}
                success={handleSuccess}
                confirmButtonText="Show Codes"
            />
        </>
    );
}
