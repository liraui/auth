import { showLogin, submitResetPassword } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

interface ResetPasswordCardProps {
    token: string;
    email: string;
}

function ResetPasswordCard({ token, email }: ResetPasswordCardProps) {
    return (
        <div className="w-sm">
            <div className="outline outline-border/50 outline-offset-4 m-4 from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Reset password</CardTitle>
                        <CardDescription>Please enter your new password below.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            {...submitResetPassword.form()}
                            disableWhileProcessing
                            transform={(data) => ({ ...data, token, email })}
                            className="flex flex-col gap-y-6"
                        >
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col items-center gap-y-4">
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input id="email" type="email" placeholder="a@example.com" name="email" disabled />
                                            {errors.email && <span className="text-sm text-red-500">{errors.email}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password">New Password</Label>
                                            <Input tabIndex={1} id="password" type="password" placeholder="•••••••••" name="password" autoFocus />
                                            {errors.password && <span className="text-sm text-red-500">{errors.password}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password_confirmation">Confirm Password</Label>
                                            <Input tabIndex={2} id="password_confirmation" type="password" placeholder="•••••••••" name="password_confirmation" />
                                            {errors.password_confirmation && (
                                                <span className="text-sm text-red-500">{errors.password_confirmation}</span>
                                            )}
                                        </div>
                                    </div>
                                    <Button tabIndex={3} type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Reset password
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto">
                        <p className="text-sm">
                            Remembered your password?{' '}
                            <Link tabIndex={4} className="font-medium underline" href={showLogin()}>
                                Login
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { ResetPasswordCard };
