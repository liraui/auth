import { deleteMethod } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

export function DeleteAccountButton() {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    return (
        <>
            <Button type="button" variant="destructive" onClick={() => setShowPasswordDialog(true)} className="mr-auto">
                Delete account
            </Button>
            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={(open: boolean) => {
                    setShowPasswordDialog(open);
                }}
                title="Delete account"
                description="This action cannot be undone. Please enter your password to confirm you want to permanently delete your account."
                form={deleteMethod.form()}
                success={() => {
                    setShowPasswordDialog(false);
                }}
                confirmButtonText="Delete account"
                confirmButtonVariant="destructive"
            />
        </>
    );
}
