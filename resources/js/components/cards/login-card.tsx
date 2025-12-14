import { login, showForgotPasswordForm, showRegistrationForm } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

export function LoginCard() {
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Login</CardTitle>
                        <CardDescription>Enter your email below to login to your account.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            {...login.form()}
                            options={{ preserveScroll: true }}
                            disableWhileProcessing
                            resetOnSuccess={['password']}
                            className="flex flex-col gap-y-6"
                        >
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col items-center gap-y-4">
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
                                                <span id="email-error" className="text-destructive text-sm" role="alert">
                                                    {errors.email}
                                                </span>
                                            )}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <div className="flex justify-between">
                                                <Label htmlFor="password">Password</Label>
                                                <Link href={showForgotPasswordForm.url()} className="text-primary text-sm font-medium underline">
                                                    Forgot password?
                                                </Link>
                                            </div>
                                            <Input
                                                tabIndex={2}
                                                id="password"
                                                type="password"
                                                placeholder="•••••••••"
                                                name="password"
                                                aria-invalid={!!errors.password}
                                                aria-describedby={errors.password ? 'password-error' : undefined}
                                            />
                                            {errors.password && (
                                                <span id="password-error" className="text-destructive text-sm" role="alert">
                                                    {errors.password}
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                    <div className="flex flex-col gap-y-6">
                                        <div className="items-top flex space-x-2">
                                            <Checkbox tabIndex={3} id="remember-me" name="remember_me" aria-invalid={!!errors.remember_me} />
                                            <div className="grid gap-1.5 leading-none">
                                                <label
                                                    htmlFor="remember-me"
                                                    className="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                                >
                                                    Remember me
                                                </label>
                                                <p className="text-muted-foreground text-sm">
                                                    By checking remember me you will be remembered on this device.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <Button tabIndex={4} type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Login
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Don't have an account?{' '}
                            <Link tabIndex={5} href={showRegistrationForm.url()} className="text-primary font-medium underline">
                                Register
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}
