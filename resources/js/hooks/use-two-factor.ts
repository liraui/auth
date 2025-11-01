import type { TwoFactorPageProps, UseTwoFactorReturn } from '@/types/auth';
import { usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export function useTwoFactor(): UseTwoFactorReturn {
    const { twoFactorEnabled, flash } = usePage<TwoFactorPageProps>().props;

    const [showConfirmDialog, setShowConfirmDialog] = useState(false);
    const [showRecoveryCodes, setShowRecoveryCodes] = useState(false);
    const [qrCodeUrl, setQrCodeUrl] = useState<string | null>(null);
    const [secret, setSecret] = useState<string | null>(null);
    const [recoveryCodes, setRecoveryCodes] = useState<string[]>([]);

    useEffect(() => {
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
        }
    }, [flash]);

    return {
        twoFactorEnabled,
        showConfirmDialog,
        setShowConfirmDialog,
        showRecoveryCodes,
        setShowRecoveryCodes,
        qrCodeUrl,
        setQrCodeUrl,
        secret,
        setSecret,
        recoveryCodes,
        setRecoveryCodes,
    };
}
