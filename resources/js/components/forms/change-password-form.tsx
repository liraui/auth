import { ChangePasswordButton } from '../buttons/change-password-button';

function ChangePasswordForm() {
    return (
        <div className="flex flex-col gap-4 md:flex-row md:gap-8">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-xl leading-6 font-semibold md:text-2xl">Change password</h1>
                <p className="text-muted-foreground leading-5">Update your password to keep your account secure.</p>
            </div>
            <div className="flex items-center md:w-1/2">
                <div className="flex flex-col gap-4">
                    <h4 className="text-sm md:text-base">
                        If you think your account has been compromised, you can change your password here. Use a strong password that you haven't used
                        elsewhere, and consider enabling two-factor authentication for added security along with clearing your browser session history
                        below.
                    </h4>
                    <div>
                        <ChangePasswordButton />
                    </div>
                </div>
            </div>
        </div>
    );
}

export { ChangePasswordForm };
