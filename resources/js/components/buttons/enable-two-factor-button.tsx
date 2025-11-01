import { enableTwoFactor } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

interface EnableTwoFactorButtonProps {
    setQrCodeUrl: (url: string) => void;
    setSecret: (secret: string) => void;
    setShowConfirmDialog: (show: boolean) => void;
}

export function EnableTwoFactorButton({ setQrCodeUrl, setSecret, setShowConfirmDialog }: EnableTwoFactorButtonProps) {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    const handleSuccess = (page: any) => {
        const { flash } = page.props;

        setShowPasswordDialog(false);

        if (flash.qrCodeUrl && flash.secret) {
            setQrCodeUrl(flash.qrCodeUrl);
            setSecret(flash.secret);
            setShowConfirmDialog(true);
        }
    };

    return (
        <div className="flex flex-col gap-4">
            <h4 className="text-sm font-bold md:text-base">You have not enabled two factor authentication.</h4>
            <h4 className="text-sm md:text-base">
                When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve
                this token from your phone's authenticator application.
            </h4>
            <Button type="button" onClick={() => setShowPasswordDialog(true)} className="mr-auto w-fit">
                Enable
            </Button>
            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={(open: boolean) => {
                    setShowPasswordDialog(open);
                }}
                title="Enable two-factor authentication"
                description="Please confirm your password before enabling two-factor authentication."
                form={enableTwoFactor.form()}
                success={handleSuccess}
                confirmButtonText="Enable"
                confirmButtonVariant="default"
            />
        </div>
    );
}
