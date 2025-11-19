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
                    {({ processing, errors }: { processing: boolean; errors: any }) => (
                        <>
                            <div className="flex flex-col gap-y-2">
                                <Label htmlFor="password">Password</Label>
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    autoComplete="current-password"
                                    aria-invalid={!!errors.password}
                                    aria-describedby={errors.password ? 'password-error' : undefined}
                                />
                                {errors.password && (
                                    <span id="password-error" className="text-destructive text-sm" role="alert">
                                        {errors.password}
                                    </span>
                                )}
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
