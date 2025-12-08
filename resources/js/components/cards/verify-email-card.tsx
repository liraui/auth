import { resendVerification, verifyEmail } from '@/actions/LiraUi/Auth/Http/Controllers/EmailVerificationController';
import { showProfile } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { InputOTP, InputOTPGroup, InputOTPSeparator, InputOTPSlot } from '@/components/ui/input-otp';
import { Spinner } from '@/components/ui/spinner';
import { SharedData } from '@/types';
import { Form, Link, usePage } from '@inertiajs/react';

function VerifyEmailCard({ email }: { email: string }) {
    const { flash } = usePage<SharedData>().props;

    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Verify your email address</CardTitle>
                        <CardDescription>
                            Before continuing, could you verify your email address by clicking on the link we just emailed to you?
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="flex flex-col gap-4">
                        <Form {...verifyEmail.form()} options={{ preserveScroll: true }} className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col items-center gap-y-4">
                                        <InputOTP maxLength={6} name="code">
                                            <InputOTPGroup>
                                                <InputOTPSlot aria-invalid={!!errors.code} index={0} />
                                                <InputOTPSlot aria-invalid={!!errors.code} index={1} />
                                                <InputOTPSlot aria-invalid={!!errors.code} index={2} />
                                            </InputOTPGroup>
                                            <InputOTPSeparator className="text-muted" />
                                            <InputOTPGroup>
                                                <InputOTPSlot aria-invalid={!!errors.code} index={3} />
                                                <InputOTPSlot aria-invalid={!!errors.code} index={4} />
                                                <InputOTPSlot aria-invalid={!!errors.code} index={5} />
                                            </InputOTPGroup>
                                        </InputOTP>
                                        {errors.code && (
                                            <span id="code-error" className="text-destructive text-sm" role="alert">
                                                {errors.code}
                                            </span>
                                        )}
                                    </div>
                                    <div className="flex justify-end gap-2">
                                        <Link href={showProfile.url()}>
                                            <Button type="button" variant="outline" className="flex-1">
                                                Settings
                                            </Button>
                                        </Link>
                                        <Button type="submit" disabled={processing}>
                                            {processing && <Spinner />} Verify
                                        </Button>
                                    </div>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-muted-foreground text-sm">
                            Didn't receive an email?{' '}
                            <Link href={resendVerification.url()} method="post" className="text-primary hover:text-primary/80 font-medium underline">
                                Resend
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { VerifyEmailCard };
