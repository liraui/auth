import { PropsWithChildren } from 'react';

export interface AuthLayoutProps extends PropsWithChildren {
    //
}

export interface BrowserSession {
    id: string;
    agent: {
        platform: string;
        browser: string;
    };
    ip_address: string;
    is_current_device: boolean;
    last_active: string;
}

export interface UseTwoFactorReturn {
    twoFactorEnabled: boolean;
    showConfirmDialog: boolean;
    setShowConfirmDialog: (show: boolean) => void;
    showRecoveryCodes: boolean;
    setShowRecoveryCodes: (show: boolean) => void;
    qrCodeUrl: string | null;
    setQrCodeUrl: (url: string | null) => void;
    secret: string | null;
    setSecret: (secret: string | null) => void;
    recoveryCodes: string[];
    setRecoveryCodes: (codes: string[]) => void;
}

export interface TwoFactorPageProps {
    twoFactorEnabled: boolean;
    flash?: {
        type: 'success' | 'error' | 'warning' | 'info';
        message: string;
        qrCodeUrl?: string;
        secret?: string;
        recoveryCodes?: string[];
    };
}
