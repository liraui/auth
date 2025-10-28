import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { InputOTP, InputOTPGroup, InputOTPSeparator, InputOTPSlot } from '@/components/ui/input-otp';
import { Spinner } from '@/components/ui/spinner';
import { recovery as showVerifyRecoveryCode } from '@/routes/two-factor';
import { store as useCode } from '@/routes/two-factor/verify';
import { Form, Link } from '@inertiajs/react';

function TwoFactorVerifyCard() {
    return (
        <div className="flex h-full w-full max-w-sm items-stretch gap-6">
            <div className="from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Authenticator code</CardTitle>
                        <CardDescription>
                            Enter the authentication code provided by your authenticator application to access your account.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form {...useCode.form()} disableWhileProcessing className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
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
                                    <Button type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Continue
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Or, having trouble?{' '}
                            <Link href={showVerifyRecoveryCode()} className="font-medium underline">
                                Use recovery code
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { TwoFactorVerifyCard };
