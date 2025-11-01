import { sendPasswordResetLink, showLoginForm } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

function ForgotPasswordCard({ status }: { status?: string }) {
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Forgot password</CardTitle>
                        <CardDescription>Enter your email address and we'll send you a link to reset your password.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        {status && <p className="text-center text-sm font-medium">{status}</p>}
                        {!status && (
                            <Form
                                {...sendPasswordResetLink.form()}
                                options={{ preserveScroll: true }}
                                disableWhileProcessing
                                className="flex flex-col gap-y-6"
                            >
                                {({ processing, errors }: { processing: boolean; errors: any }) => (
                                    <>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input
                                                tabIndex={1}
                                                id="email"
                                                type="email"
                                                placeholder="a@example.com"
                                                name="email"
                                                autoFocus
                                                aria-invalid={!!errors.email}
                                                aria-describedby={errors.email ? 'email-error' : undefined}
                                            />
                                            {errors.email && (
                                                <span id="email-error" className="text-sm text-destructive" role="alert">
                                                    {errors.email}
                                                </span>
                                            )}
                                        </div>
                                        <Button tabIndex={2} type="submit" className="w-full" disabled={processing}>
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
                            <Link tabIndex={3} href={showLoginForm.url()} className="text-primary font-medium underline">
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
