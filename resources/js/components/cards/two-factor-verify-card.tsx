import { showRecoveryCodeForm, verifyTwoFactor } from '@/actions/LiraUi/Auth/Http/Controllers/TwoFactorVerificationController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { InputOTP, InputOTPGroup, InputOTPSeparator, InputOTPSlot } from '@/components/ui/input-otp';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

function TwoFactorVerifyCard() {
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Authenticator code</CardTitle>
                        <CardDescription>
                            Enter the authentication code provided by your authenticator application to access your account.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form {...verifyTwoFactor.form()} options={{ preserveScroll: true }} disableWhileProcessing className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col items-center gap-y-4">
                                        <InputOTP maxLength={6} name="code" autoFocus>
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
                                    </div>
                                    {errors.code && (
                                        <span id="code-error" className="text-destructive text-sm" role="alert">
                                            {errors.code}
                                        </span>
                                    )}
                                    <Button type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Continue
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Got a recovery code?{' '}
                            <Link href={showRecoveryCodeForm.url()} className="font-medium underline">
                                Recover
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { TwoFactorVerifyCard };
