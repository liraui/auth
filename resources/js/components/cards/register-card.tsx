import { showLoginForm, register } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

function RegisterCard() {
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Register</CardTitle>
                        <CardDescription>Enter your information to create an account.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            {...register.form()}
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
                                                <Input tabIndex={1} id="first-name" type="text" placeholder="" name="first_name" autoFocus />
                                                {errors.first_name && <span className="text-sm text-red-500">{errors.first_name}</span>}
                                            </div>
                                            <div className="flex w-full flex-col gap-y-2">
                                                <Label htmlFor="last-name">Last name</Label>
                                                <Input tabIndex={2} id="last-name" type="text" placeholder="" name="last_name" />
                                                {errors.last_name && <span className="text-sm text-red-500">{errors.last_name}</span>}
                                            </div>
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input tabIndex={3} id="email" type="email" placeholder="a@example.com" name="email" />
                                            {errors.email && <span className="text-sm text-red-500">{errors.email}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password">Password</Label>
                                            <Input tabIndex={4} id="password" type="password" placeholder="•••••••••" name="password" />
                                            {errors.password && <span className="text-sm text-red-500">{errors.password}</span>}
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password-confirmation">Confirm password</Label>
                                            <Input
                                                tabIndex={5}
                                                id="password-confirmation"
                                                type="password"
                                                placeholder="•••••••••"
                                                name="password_confirmation"
                                            />
                                        </div>
                                        <div className="items-top flex space-x-2">
                                            <Checkbox tabIndex={6} id="terms" name="terms" className={errors.terms ? 'ring-2 ring-red-500/60' : ''} />
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
                                                        Privacy Policy
                                                    </Link>
                                                    .
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <Button tabIndex={7} type="submit" className="w-full" disabled={processing}>
                                        {processing && <Spinner />} Create an account
                                    </Button>
                                </>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto">
                        <p className="text-sm">
                            Already have an account?{' '}
                            <Link tabIndex={8} className="font-medium underline" href={showLoginForm.url()}>
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
