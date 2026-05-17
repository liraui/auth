import { deletePasskey } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { XIcon } from 'lucide-react';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';
import { Passkey } from '../../types';

interface DeletePasskeyButtonProps {
    passkey: Passkey;
}

export function DeletePasskeyButton({ passkey }: DeletePasskeyButtonProps) {
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    return (
        <>
            <button
                type="button"
                onClick={() => setShowPasswordDialog(true)}
                className="text-muted-foreground hover:text-primary transition-colors"
                aria-label={`Delete passkey ${passkey.name}`}
                title="Remove passkey"
            >
                <XIcon size={16} />
            </button>

            <PasswordConfirmationDialog
                show={showPasswordDialog}
                onOpenChange={setShowPasswordDialog}
                title="Delete passkey"
                description={`Please confirm your password to delete the passkey ${passkey.name}. You will need to register a new passkey or use another authentication method to sign in again.`}
                form={deletePasskey.form({ passkey: passkey.id })}
                success={() => {
                    setShowPasswordDialog(false);
                }}
                confirmButtonText="Delete passkey"
                confirmButtonVariant="destructive"
            />
        </>
    );
}

