import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form } from '@inertiajs/react';

interface PasswordConfirmationDialogProps {
    show: boolean;
    onOpenChange: (open: boolean) => void;
    title: string;
    description: string;
    form: any;
    success: (page?: any) => void;
    confirmButtonText: string;
    confirmButtonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
}

export function PasswordConfirmationDialog({
    show,
    onOpenChange,
    title,
    description,
    form,
    success,
    confirmButtonText,
    confirmButtonVariant = 'default',
}: PasswordConfirmationDialogProps) {
    return (
        <Dialog open={show} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>{title}</DialogTitle>
                    <DialogDescription>{description}</DialogDescription>
                </DialogHeader>
                <Form {...form} options={{ preserveScroll: true }} onSuccess={success} className="flex flex-col gap-y-6">
                    {({ processing, errors }) => (
                        <>
                            <div className="flex flex-col gap-y-2">
                                <Label htmlFor="password">Password</Label>
                                <Input id="password" type="password" name="password" autoComplete="current-password" />
                                {errors.password && <div className="text-sm text-red-500">{errors.password}</div>}
                            </div>
                            <DialogFooter>
                                <DialogClose asChild>
                                    <Button type="button" variant="outline">
                                        Cancel
                                    </Button>
                                </DialogClose>
                                <Button type="submit" variant={confirmButtonVariant} disabled={processing}>
                                    {processing && <Spinner />} {confirmButtonText}
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
