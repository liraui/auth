import { changePassword } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { LockKeyholeIcon } from 'lucide-react';
import { useState } from 'react';
import { ChangePasswordDialog } from '../dialogs/change-password-dialog';

export function ChangePasswordButton() {
    const [showDialog, setShowDialog] = useState(false);

    return (
        <>
            <Button variant={'outline'} type="button" onClick={() => setShowDialog(true)}>
                <LockKeyholeIcon /> Change password
            </Button>
            <ChangePasswordDialog
                show={showDialog}
                onOpenChange={setShowDialog}
                form={changePassword.form()}
                success={() => {
                    setShowDialog(false);
                }}
            />
        </>
    );
}
