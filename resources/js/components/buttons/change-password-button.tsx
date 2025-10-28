import { Button } from '@/components/ui/button';
import { update } from '@/routes/profile/password';
import { useState } from 'react';
import { ChangePasswordDialog } from '../dialogs/change-password-dialog';

interface ChangePasswordButtonProps {
    buttonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
    buttonSize?: 'default' | 'sm' | 'lg' | 'icon';
    className?: string;
}

export function ChangePasswordButton({ buttonVariant = 'default', buttonSize = 'default', className = '' }: ChangePasswordButtonProps) {
    const [showDialog, setShowDialog] = useState(false);

    return (
        <>
            <Button type="button" variant={buttonVariant} size={buttonSize} onClick={() => setShowDialog(true)} className={className}>
                Change Password
            </Button>
            <ChangePasswordDialog
                show={showDialog}
                onOpenChange={setShowDialog}
                form={update.form()}
                success={() => {
                    setShowDialog(false);
                }}
            />
        </>
    );
}
