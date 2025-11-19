import { register, showLoginForm } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { Form, Link } from '@inertiajs/react';

export function RegisterCard() {
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
                            options={{ preserveScroll: true }}
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
                                                <Input
                                                    tabIndex={1}
                                                    id="first-name"
                                                    type="text"
                                                    name="first_name"
                                                    autoFocus
                                                    aria-invalid={!!errors.first_name}
                                                    aria-describedby={errors.first_name ? 'first-name-error' : undefined}
                                                />
                                                {errors.first_name && (
                                                    <span id="first-name-error" className="text-destructive text-sm" role="alert">
                                                        {errors.first_name}
                                                    </span>
                                                )}
                                            </div>
                                            <div className="flex w-full flex-col gap-y-2">
                                                <Label htmlFor="last-name">Last name</Label>
                                                <Input
                                                    tabIndex={2}
                                                    id="last-name"
                                                    type="text"
                                                    name="last_name"
                                                    aria-invalid={!!errors.last_name}
                                                    aria-describedby={errors.last_name ? 'last-name-error' : undefined}
                                                />
                                                {errors.last_name && (
                                                    <span id="last-name-error" className="text-destructive text-sm" role="alert">
                                                        {errors.last_name}
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input
                                                tabIndex={3}
                                                id="email"
                                                type="email"
                                                placeholder="a@example.com"
                                                name="email"
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
                                            <Label htmlFor="password">Password</Label>
                                            <Input
                                                tabIndex={4}
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
                                        <div className="flex w-full flex-col gap-y-2">
                                            <Label htmlFor="password-confirmation">Confirm password</Label>
                                            <Input
                                                tabIndex={5}
                                                id="password-confirmation"
                                                type="password"
                                                placeholder="•••••••••"
                                                name="password_confirmation"
                                                aria-invalid={!!errors.password_confirmation}
                                                aria-describedby={errors.password_confirmation ? 'password-confirmation-error' : undefined}
                                            />
                                            {errors.password_confirmation && (
                                                <span id="password-confirmation-error" className="text-destructive text-sm" role="alert">
                                                    {errors.password_confirmation}
                                                </span>
                                            )}
                                        </div>
                                        <div className="items-top flex space-x-2">
                                            <Checkbox tabIndex={6} id="terms" name="terms" aria-invalid={!!errors.terms} />
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
