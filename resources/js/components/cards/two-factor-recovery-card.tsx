import { showTwoFactorLogin, submitTwoFactorRecoveryCode } from '@/actions/LiraUi/Auth/Http/Controllers/TwoFactorVerificationController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

export function TwoFactorRecoveryCard() {
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Recovery code</CardTitle>
                        <CardDescription>
                            Enter one of your recovery codes to access your account. Make sure to keep your recovery codes in a safe place.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form {...submitTwoFactorRecoveryCode.form()} disableWhileProcessing className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex w-full flex-col gap-y-2">
                                        <Label htmlFor="recover-code">Recovery code</Label>
                                        <Input
                                            tabIndex={1}
                                            id="recover-code"
                                            type="text"
                                            placeholder="Enter your recovery code"
                                            name="recovery_code"
                                            autoFocus
                                        />
                                        {errors.recovery_code && <span className="text-sm text-red-500">{errors.recovery_code}</span>}
                                    </div>
                                    <Button tabIndex={2} type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Continue
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            {'Or, got the code? '}
                            <Link tabIndex={3} href={showTwoFactorLogin()} className="font-medium underline">
                                Verify
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}
