import { verifyEmail } from '@/actions/LiraUi/Auth/Http/Controllers/EmailVerificationController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { AccessCodeConfirmationDialog } from '../dialogs/access-code-confirmation-dialog';

export function VerifyEmailButton({ email }: { email: string }) {
    const [showAccessCodeDialog, setShowAccessCodeDialog] = useState(false);

    return (
        <>
            <Button variant={'outline'} type="button" onClick={() => setShowAccessCodeDialog(true)}>
                Verify email
            </Button>

            <AccessCodeConfirmationDialog
                show={showAccessCodeDialog}
                onOpenChange={(open: boolean) => {
                    setShowAccessCodeDialog(open);
                }}
                title="Verify email address"
                description={`Please enter the 6-digit verification code sent to ${email}.`}
                form={verifyEmail.form()}
                success={() => {
                    setShowAccessCodeDialog(false);
                }}
                confirmButtonText="Verify"
                confirmButtonVariant="ghost"
            />
        </>
    );
}
