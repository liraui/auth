import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login as showLogin } from '@/routes/auth';
import { submit as attemptResetPassword } from '@/routes/auth/forgot-password';
import { Form, Link } from '@inertiajs/react';

function ForgotPasswordCard({ status }: { status?: string }) {
    return (
        <div className="flex h-full w-full max-w-sm items-stretch gap-6">
            <div className="from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Forgot password</CardTitle>
                        <CardDescription>Enter your email address and we'll send you a link to reset your password.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        {status && <p className="text-center text-sm font-medium">{status}</p>}
                        {!status && (
                            <Form {...attemptResetPassword.form()} disableWhileProcessing className="flex flex-col gap-y-6">
                                {({ processing, errors }: { processing: boolean; errors: any }) => (
                                    <>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input id="email" type="email" placeholder="a@example.com" name="email" />
                                            {errors.email && <span className="text-sm text-red-500">{errors.email}</span>}
                                        </div>
                                        <Button type="submit" className="w-full" disabled={processing}>
                                            {processing && <Spinner />} Send password reset link
                                        </Button>
                                    </>
                                )}
                            </Form>
                        )}
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Or, return to{' '}
                            <Link href={showLogin()} className="text-primary font-medium underline">
                                Login
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { ForgotPasswordCard };
