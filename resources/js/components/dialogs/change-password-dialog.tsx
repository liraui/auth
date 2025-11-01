import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form } from '@inertiajs/react';

interface ChangePasswordDialogProps {
    show: boolean;
    onOpenChange: (open: boolean) => void;
    form: any;
    success: () => void;
}

export function ChangePasswordDialog({ show, onOpenChange, form, success }: ChangePasswordDialogProps) {
    return (
        <Dialog open={show} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Change password</DialogTitle>
                    <DialogDescription>Enter your current password and your new password to update your account.</DialogDescription>
                </DialogHeader>
                <Form {...form} options={{ preserveScroll: true }} onSuccess={success} className="flex flex-col gap-y-6">
                    {({ processing, errors }) => (
                        <>
                            <div className="flex flex-col gap-y-4">
                                <div className="flex flex-col gap-y-2">
                                    <Label htmlFor="current_password">Current password</Label>
                                    <Input id="current_password" type="password" name="current_password" autoComplete="current-password" />
                                    {errors.current_password && <div className="text-sm text-red-500">{errors.current_password}</div>}
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="flex flex-col gap-y-2">
                                        <Label htmlFor="password">New password</Label>
                                        <Input id="password" type="password" name="password" autoComplete="new-password" />
                                        {errors.password && <div className="text-sm text-red-500">{errors.password}</div>}
                                    </div>
                                    <div className="flex flex-col gap-y-2">
                                        <Label htmlFor="password_confirmation">Confirm new password</Label>
                                        <Input id="password_confirmation" type="password" name="password_confirmation" autoComplete="new-password" />
                                        {errors.password_confirmation && <div className="text-sm text-red-500">{errors.password_confirmation}</div>}
                                    </div>
                                </div>
                            </div>
                            <DialogFooter>
                                <DialogClose asChild>
                                    <Button type="button" variant="outline">
                                        Cancel
                                    </Button>
                                </DialogClose>
                                <Button type="submit" disabled={processing}>
                                    {processing && <Spinner />} Change password
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
