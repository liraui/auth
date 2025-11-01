export interface LoginFormData {
    email: string;
    password: string;
    remember?: boolean;
}

export interface RegisterFormData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

export interface ResetPasswordFormData {
    email: string;
    password: string;
    password_confirmation: string;
    token: string;
}

export interface ForgotPasswordFormData {
    email: string;
}

export interface TwoFactorCodeFormData {
    code: string;
}

export interface TwoFactorRecoveryFormData {
    recovery_code: string;
}

export interface UpdateProfileFormData {
    name: string;
    email: string;
}

export interface ChangePasswordFormData {
    current_password: string;
    password: string;
    password_confirmation: string;
}

export interface TwoFactorFlash {
    qrCodeUrl?: string;
    secret?: string;
    recoveryCodes?: string[];
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

export interface FormErrors {
    [key: string]: string | undefined;
}

export interface LoginFormErrors extends FormErrors {
    email?: string;
    password?: string;
    remember_me?: string;
}

export interface RegisterFormErrors extends FormErrors {
    name?: string;
    first_name?: string;
    last_name?: string;
    email?: string;
    password?: string;
    password_confirmation?: string;
    terms?: string;
}

export interface RegisterFormRenderProps {
    processing: boolean;
    errors: RegisterFormErrors;
}

export interface ResetPasswordFormErrors extends FormErrors {
    email?: string;
    password?: string;
    password_confirmation?: string;
    token?: string;
}

export interface LoginFormRenderProps {
    processing: boolean;
    errors: LoginFormErrors;
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
    flash?: TwoFactorFlash;
}
