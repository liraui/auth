import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { forgotPassword as showForgotPassword, register as showRegister } from '@/routes/auth';
import { attempt as attemptLogin } from '@/routes/auth/login';
import { Form, Link } from '@inertiajs/react';

function LoginCard() {
    return (
        <div className="flex h-full w-full max-w-sm items-stretch gap-6">
            <div className="from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Login</CardTitle>
                        <CardDescription>Enter your email below to login to your account.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form {...attemptLogin.form()} disableWhileProcessing resetOnSuccess={['password']} className="flex flex-col gap-y-6">
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col items-center gap-y-4">
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input id="email" type="email" placeholder="m@example.com" name="email" />
                                            {errors.email && <span className="text-sm text-red-500">{errors.email}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <div className="flex justify-between">
                                                <Label htmlFor="password">Password</Label>
                                                <Link href={showForgotPassword()} className="text-primary text-sm font-medium">
                                                    Forgot password?
                                                </Link>
                                            </div>
                                            <Input
                                                id="password"
                                                type="password"
                                                placeholder="•••••••••"
                                                name="password"
                                                className={errors.password ? 'ring-2 ring-red-500/60' : ''}
                                            />
                                            {errors.password && <span className="text-sm text-red-500">{errors.password}</span>}
                                        </div>
                                    </div>
                                    <div className="flex flex-col gap-y-6">
                                        <div className="items-top flex space-x-2">
                                            <Checkbox id="remember-me" className={errors.remember_me ? 'ring-2 ring-red-500/60' : ''} />
                                            <div className="grid gap-1.5 leading-none">
                                                <label
                                                    htmlFor="remember-me"
                                                    className="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                                >
                                                    Remember me
                                                </label>
                                                <p className="text-muted-foreground text-sm">
                                                    By checking remember me you will be remembered on this device for 30 days.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <Button type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Login
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Don't have an account?{' '}
                            <Link href={showRegister()} className="text-primary font-medium underline">
                                Register
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { LoginCard };
