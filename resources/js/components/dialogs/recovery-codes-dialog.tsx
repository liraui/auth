import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { useState } from 'react';

interface RecoveryCodesDialogProps {
    showRecoveryCodes: boolean;
    setShowRecoveryCodes: (show: boolean) => void;
    recoveryCodes: string[];
}

export function RecoveryCodesDialog({ showRecoveryCodes, setShowRecoveryCodes, recoveryCodes }: RecoveryCodesDialogProps) {
    const [copied, setCopied] = useState(false);

    const copyAllCodes = () => {
        navigator.clipboard.writeText(recoveryCodes.join('\n')).then(() => {
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        });
    };

    return (
        <Dialog open={showRecoveryCodes} onOpenChange={setShowRecoveryCodes}>
            <DialogContent className="max-w-md">
                <DialogHeader>
                    <DialogTitle>Recovery codes</DialogTitle>
                    <DialogDescription>
                        Store these recovery codes in a secure location. They can be used to recover access to your account if your two factor
                        authentication device is lost.
                    </DialogDescription>
                </DialogHeader>
                <pre className="bg-muted overflow-auto rounded-md border p-3 font-mono text-sm whitespace-pre">{recoveryCodes.join('\n')}</pre>
                <div className="flex flex-col justify-end gap-2 sm:flex-row">
                    <Button type="button" variant="outline" onClick={copyAllCodes}>
                        {copied ? 'Copied.' : 'Copy Recovery Codes'}
                    </Button>
                    <Button type="button" onClick={() => setShowRecoveryCodes(false)}>
                        Done
                    </Button>
                </div>
            </DialogContent>
        </Dialog>
    );
}
