import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { confirm } from '@/routes/profile/two-factor';
import { Form } from '@inertiajs/react';
import { QRCodeSVG } from 'qrcode.react';

interface ConfirmTwoFactorDialogProps {
    showConfirmDialog: boolean;
    setShowConfirmDialog: (show: boolean) => void;
    qrCodeUrl: string | null;
    secret: string | null;
    setShowRecoveryCodes: (show: boolean) => void;
    setRecoveryCodes: (codes: string[]) => void;
}

export function ConfirmTwoFactorDialog({
    showConfirmDialog,
    setShowConfirmDialog,
    qrCodeUrl,
    secret,
    setShowRecoveryCodes,
    setRecoveryCodes,
}: ConfirmTwoFactorDialogProps) {
    const handleSuccess = (page: any) => {
        const { flash } = page.props;

        if (flash.recoveryCodes) {
            setRecoveryCodes(flash.recoveryCodes);
            setShowConfirmDialog(false);
            setShowRecoveryCodes(true);
        }
    };

    return (
        <Dialog open={showConfirmDialog} onOpenChange={setShowConfirmDialog}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Scan QR code</DialogTitle>
                    <DialogDescription>Scan this QR code with your authenticator app, then enter the 6-digit code to confirm.</DialogDescription>
                </DialogHeader>
                <div className="flex flex-col items-center gap-4">
                    {qrCodeUrl && (
                        <div className="rounded bg-white p-4">
                            <QRCodeSVG value={qrCodeUrl} size={256} />
                        </div>
                    )}
                    {secret && (
                        <div className="text-center">
                            <p className="text-muted-foreground mb-2 text-sm">Or enter this code manually:</p>
                            <code className="bg-muted rounded px-3 py-1 font-mono text-sm">{secret}</code>
                        </div>
                    )}
                    <Form {...confirm.form()} options={{ preserveScroll: true }} onSuccess={handleSuccess} className="flex w-full flex-col gap-4">
                        {({ processing, errors }) => (
                            <>
                                <div className="flex flex-col gap-y-2">
                                    <Label htmlFor="code">Authentication Code</Label>
                                    <Input
                                        id="code"
                                        type="text"
                                        inputMode="numeric"
                                        maxLength={6}
                                        placeholder="000000"
                                        name="code"
                                        className={errors.code ? 'ring-2 ring-red-500/60' : ''}
                                    />
                                    {errors.code && <span className="text-sm text-red-500">{errors.code}</span>}
                                </div>
                                <DialogFooter className="flex gap-2">
                                    <DialogClose asChild>
                                        <Button type="button" variant="outline">
                                            Cancel
                                        </Button>
                                    </DialogClose>
                                    <Button type="submit" disabled={processing}>
                                        {processing && <Spinner />} Confirm
                                    </Button>
                                </DialogFooter>
                            </>
                        )}
                    </Form>
                </div>
            </DialogContent>
        </Dialog>
    );
}
