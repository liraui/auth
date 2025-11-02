import { deleteMethod } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

export function DeleteAccountForm() {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    return (
        <div className="flex flex-col gap-6 md:flex-row">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-xl leading-6 font-semibold md:text-2xl">Delete account</h1>
                <p className="text-muted-foreground leading-5">Permanently delete your account.</p>
            </div>
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <div className="flex flex-col gap-4">
                    <h4 className="text-sm md:text-base">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please
                        download any data or information that you wish to retain.
                    </h4>
                    <Button type="button" variant="outline" onClick={() => setShowPasswordDialog(true)} className="mr-auto">
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
                </div>
            </div>
        </div>
    );
}
