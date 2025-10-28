import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { InputOTP, InputOTPGroup, InputOTPSeparator, InputOTPSlot } from '@/components/ui/input-otp';
import { Form } from '@inertiajs/react';

interface AccessCodeConfirmationDialogProps {
    show: boolean;
    onOpenChange: (open: boolean) => void;
    title: string;
    description: string;
    form: any;
    success: () => void;
    confirmButtonText?: string;
    confirmButtonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
}

export function AccessCodeConfirmationDialog({
    show,
    onOpenChange,
    title,
    description,
    form,
    success,
    confirmButtonText = 'Continue',
    confirmButtonVariant = 'default',
}: AccessCodeConfirmationDialogProps) {
    return (
        <Dialog open={show} onOpenChange={onOpenChange}>
            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>{title}</DialogTitle>
                    <DialogDescription>{description}</DialogDescription>
                </DialogHeader>
                <Form {...form} options={{ preserveScroll: true }} onSuccess={success} className="flex flex-col gap-y-6">
                    {({ processing, errors }) => (
                        <>
                            <div className="flex flex-col items-center gap-y-4">
                                <InputOTP maxLength={6} name="code">
                                    <InputOTPGroup>
                                        <InputOTPSlot index={0} />
                                        <InputOTPSlot index={1} />
                                        <InputOTPSlot index={2} />
                                    </InputOTPGroup>
                                    <InputOTPSeparator className="text-muted" />
                                    <InputOTPGroup>
                                        <InputOTPSlot index={3} />
                                        <InputOTPSlot index={4} />
                                        <InputOTPSlot index={5} />
                                    </InputOTPGroup>
                                </InputOTP>
                                {errors.code && <span className="text-sm text-red-500">{errors.code}</span>}
                            </div>
                            <DialogFooter className="flex gap-2">
                                <DialogClose asChild>
                                    <Button type="button" variant="outline">
                                        Cancel
                                    </Button>
                                </DialogClose>
                                <Button type="submit" variant={confirmButtonVariant} disabled={processing}>
                                    {confirmButtonText}
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
