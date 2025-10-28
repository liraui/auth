import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login as showLogin } from '@/routes/auth';
import { submit as attemptRegister } from '@/routes/auth/register';
import { Form, Link } from '@inertiajs/react';

function RegisterCard() {
    return (
        <div className="flex h-full w-full max-w-sm items-stretch gap-6">
            <div className="from-border/70 to-border/70 relative h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Register</CardTitle>
                        <CardDescription>Enter your information to create an account.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            {...attemptRegister.form()}
                            disableWhileProcessing
                            resetOnSuccess={['password', 'password_confirmation']}
                            className="flex flex-col gap-y-6"
                        >
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <>
                                    <div className="flex flex-col gap-y-4">
                                        <div className="flex gap-4 *:flex-1">
                                            <div className="flex w-full flex-col gap-y-2">
                                                <Label htmlFor="first-name">First name</Label>
                                                <Input id="first-name" type="text" placeholder="" name="first_name" />
                                                {errors.first_name && <span className="text-sm text-red-500">{errors.first_name}</span>}
                                            </div>
                                            <div className="flex w-full flex-col gap-y-2">
                                                <Label htmlFor="last-name">Last name</Label>
                                                <Input id="last-name" type="text" placeholder="" name="last_name" />
                                                {errors.last_name && <span className="text-sm text-red-500">{errors.last_name}</span>}
                                            </div>
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input id="email" type="email" placeholder="a@example.com" name="email" />
                                            {errors.email && <span className="text-sm text-red-500">{errors.email}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password">Password</Label>
                                            <Input id="password" type="password" placeholder="•••••••••" name="password" />
                                            {errors.password && <span className="text-sm text-red-500">{errors.password}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password-confirmation">Confirm password</Label>
                                            <Input id="password-confirmation" type="password" placeholder="•••••••••" name="password_confirmation" />
                                        </div>
                                        <div className="items-top flex space-x-2">
                                            <Checkbox id="terms" name="terms" className={errors.terms ? 'ring-2 ring-red-500/60' : ''} />
                                            <div className="grid gap-1.5 leading-none">
                                                <label
                                                    htmlFor="terms"
                                                    className="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                                >
                                                    Accept terms and conditions
                                                </label>
                                                <p className="text-muted-foreground text-sm">
                                                    By registering, you agree to our{' '}
                                                    <Link href="/terms" className="text-blue-400 underline">
                                                        Terms of Service
                                                    </Link>
                                                    {' and '}
                                                    <Link href="/privacy" className="text-blue-400 underline">
                                                        Privacy policy
                                                    </Link>
                                                    .
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <Button type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Create an account
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto">
                        <p className="text-sm">
                            Already have an account?{' '}
                            <Link className="font-medium underline" href={showLogin()}>
                                Login
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { RegisterCard };
