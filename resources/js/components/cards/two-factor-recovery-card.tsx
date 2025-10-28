import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { verify as showVerify } from '@/routes/two-factor';
import { store as useRecoveryCode } from '@/routes/two-factor/recovery';
import { Form, Link } from '@inertiajs/react';

export function TwoFactorRecoveryCard() {
    return (
        <div className="flex h-full w-full max-w-sm items-stretch gap-6">
            <div className="from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Recovery code</CardTitle>
                        <CardDescription>
                            Enter one of your recovery codes to access your account. Make sure to keep your recovery codes in a safe place.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form {...useRecoveryCode.form()} disableWhileProcessing className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex w-full flex-col gap-y-2">
                                        <Label htmlFor="recover-code">Recovery code</Label>
                                        <Input id="recover-code" type="text" placeholder="Enter your recovery code" name="recovery_code" />
                                        {errors.recovery_code && <span className="text-sm text-red-500">{errors.recovery_code}</span>}
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
                            {'Or, got the authenticator app? '}
                            <Link href={showVerify()} className="font-medium underline">
                                Use code
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}
