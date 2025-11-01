export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
}

export interface PageProps {
    auth: {
        user: User;
    };
    flash?: {
        success?: string;
        error?: string;
        message?: string;
    };
    errors?: Record<string, string>;
}
