import { PasskeyExistsError } from '@laravel/passkeys';
import { usePasskeyRegister } from '@laravel/passkeys/react';
import { confirmPasskeyPassword } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { UserRoundKeyIcon } from 'lucide-react';
import { toast } from 'sonner';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';


export function AddPasskeyButton() {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    const { register, isLoading, error, errorInstance } = usePasskeyRegister({
        onSuccess: () => {
            toast.success('Passkey has been added.', {
                position: 'bottom-center',
            });

            router.reload();
        }
    });

    return (
        <>
            <Button variant="outline" type="button" onClick={() => setShowPasswordDialog(true)} className="mr-auto w-fit" disabled={isLoading}>
                {isLoading ? <Spinner /> : <UserRoundKeyIcon />} Add passkey
            </Button>

            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={setShowPasswordDialog}
                title="Confirm password"
                description="You must confirm your password before adding a new passkey to your account."
                form={confirmPasskeyPassword.form()}
                success={() => {
                    setShowPasswordDialog(false);
                    register(crypto.randomUUID().slice(0, 8));
                }}
                confirmButtonText="Continue"
            />

            {error && (
                <span className="text-destructive text-sm" role="alert">
                    {errorInstance instanceof PasskeyExistsError
                        ? 'A passkey for this account is already registered on this device.'
                        : error}
                </span>
            )}
        </>
    );
}
