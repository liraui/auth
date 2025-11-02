import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { CheckIcon, CopyIcon } from 'lucide-react';
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
                <div className="relative">
                    <pre className="bg-muted/35 overflow-auto rounded-md border p-3 font-mono text-sm whitespace-pre">{recoveryCodes.join('\n')}</pre>
                    <Button type="button" variant="ghost" size="sm" className="absolute top-2 right-2 h-8 w-8 p-0" onClick={copyAllCodes}>
                        {copied ? <CheckIcon className="h-4 w-4" /> : <CopyIcon className="h-4 w-4" />}
                    </Button>
                </div>
                <div className="flex flex-col justify-end gap-2 sm:flex-row">
                    <Button type="button" variant={'outline'} onClick={() => setShowRecoveryCodes(false)}>
                        Done
                    </Button>
                </div>
            </DialogContent>
        </Dialog>
    );
}
