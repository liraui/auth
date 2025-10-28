import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { useState } from 'react';
import { DisableTwoFactorButton } from '../buttons/disable-two-factor-button';
import { EnableTwoFactorButton } from '../buttons/enable-two-factor-button';
import { ShowTwoFactorRecoveryCodesButton } from '../buttons/show-two-factor-recovery-codes-button';
import { ConfirmTwoFactorDialog } from '../dialogs/confirm-two-factor-dialog';
import { RecoveryCodesDialog } from '../dialogs/recovery-codes-dialog';

function TwoFactorAuthenticationForm() {
    const { twoFactorEnabled, flash } = usePage<
        SharedData & {
            twoFactorEnabled: boolean;
            flash?: { qrCodeUrl?: string; secret?: string; recoveryCodes?: string[] };
            [key: string]: any;
        }
    >().props;

    const [showConfirmDialog, setShowConfirmDialog] = useState(false);
    const [showRecoveryCodes, setShowRecoveryCodes] = useState(false);
    const [qrCodeUrl, setQrCodeUrl] = useState<string | null>(null);
    const [secret, setSecret] = useState<string | null>(null);
    const [recoveryCodes, setRecoveryCodes] = useState<string[]>([]);

    useState(() => {
        if (!flash) return;

        if (flash.qrCodeUrl && flash.secret) {
            setQrCodeUrl(flash.qrCodeUrl);
            setSecret(flash.secret);
            setShowConfirmDialog(true);
            return;
        }

        if (flash.recoveryCodes) {
            setRecoveryCodes(flash.recoveryCodes);
            setShowRecoveryCodes(true);
            return;
        }
    });

    return (
        <div className="flex flex-col gap-6 md:flex-row">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-xl leading-6 font-semibold md:text-2xl">Two-factor authentication</h1>
                <p className="text-muted-foreground leading-5">Add additional security to your account using two factor authentication.</p>
            </div>
            <div className="flex w-full flex-col gap-8 md:w-1/2">
                <div className="flex flex-col gap-2 sm:flex-row">
                    {!twoFactorEnabled ? (
                        <EnableTwoFactorButton setQrCodeUrl={setQrCodeUrl} setSecret={setSecret} setShowConfirmDialog={setShowConfirmDialog} />
                    ) : (
                        <div className="flex flex-col gap-4">
                            <h4 className="text-sm font-bold md:text-base">You have enabled two factor authentication.</h4>
                            <h4 className="text-sm md:text-base">
                                When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You
                                may retrieve this token from your phone's authenticator application.
                            </h4>
                            <div className="flex flex-col gap-2 sm:flex-row">
                                <ShowTwoFactorRecoveryCodesButton setRecoveryCodes={setRecoveryCodes} setShowRecoveryCodes={setShowRecoveryCodes} />
                                <DisableTwoFactorButton />
                            </div>
                        </div>
                    )}
                </div>
                <ConfirmTwoFactorDialog
                    showConfirmDialog={showConfirmDialog}
                    setShowConfirmDialog={setShowConfirmDialog}
                    qrCodeUrl={qrCodeUrl}
                    secret={secret}
                    setShowRecoveryCodes={setShowRecoveryCodes}
                    setRecoveryCodes={setRecoveryCodes}
                />
                <RecoveryCodesDialog
                    showRecoveryCodes={showRecoveryCodes}
                    setShowRecoveryCodes={setShowRecoveryCodes}
                    recoveryCodes={recoveryCodes}
                />
            </div>
        </div>
    );
}

export { TwoFactorAuthenticationForm };
