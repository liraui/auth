import { verifyEmail } from '@/actions/LiraUi/Auth/Http/Controllers/EmailVerificationController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { AccessCodeConfirmationDialog } from '../dialogs/access-code-confirmation-dialog';

interface VerifyEmailButtonProps {
    email: string;
    buttonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
    buttonSize?: 'default' | 'sm' | 'lg' | 'icon';
    className?: string;
}

export function VerifyEmailButton({ email, buttonVariant = 'outline', buttonSize = 'sm', className = '' }: VerifyEmailButtonProps) {
    const [showAccessCodeDialog, setShowAccessCodeDialog] = useState(false);

    return (
        <>
            <Button type="button" variant={buttonVariant} size={buttonSize} onClick={() => setShowAccessCodeDialog(true)} className={className}>
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
                confirmButtonVariant="default"
            />
        </>
    );
}
