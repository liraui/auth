import { Button } from '@/components/ui/button';
import { verify } from '@/routes/verification';
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
                Verify Email
            </Button>

            <AccessCodeConfirmationDialog
                show={showAccessCodeDialog}
                onOpenChange={(open: boolean) => {
                    setShowAccessCodeDialog(open);
                }}
                title="Verify Email Address"
                description={`Please enter the 6-digit verification code sent to ${email}.`}
                form={verify.form()}
                success={() => {
                    setShowAccessCodeDialog(false);
                }}
                confirmButtonText="Verify"
                confirmButtonVariant="default"
            />
        </>
    );
}
