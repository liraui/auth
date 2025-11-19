import { resendVerification } from '@/actions/LiraUi/Auth/Http/Controllers/EmailVerificationController';
import { showProfile } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Spinner } from '@/components/ui/spinner';
import { SharedData } from '@/types';
import { Form, Link, usePage } from '@inertiajs/react';

function VerifyEmailCard({ email }: { email: string }) {
    const {flash} = usePage<SharedData>().props;
    
    return (
        <div className="w-sm">
            <div className="outline-border/50 from-border/70 to-border/70 relative m-4 h-full w-full overflow-hidden rounded-2xl bg-linear-to-br via-transparent via-50% p-px outline outline-offset-4">
                <Card className="bg-primary-foreground h-full w-full rounded-2xl border-0 shadow-none">
                    <CardHeader className="gap-3">
                        <CardTitle className="text-2xl">Verify your email address</CardTitle>
                        <CardDescription>
                            Before continuing, could you verify your email address by clicking on the link we just emailed to you?
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="flex flex-col gap-4">
                        <div>
                            {flash && flash.type === 'success' ? (
                                <p className="text-center text-sm font-medium">{flash.message}</p>
                            ) : (
                                <p className="text-muted-foreground text-center text-sm">
                                    We've sent a verification link to <strong>{email}</strong>
                                </p>
                            )}
                        </div>
                        <Form {...resendVerification.form()} options={{ preserveScroll: true }}>
                            {({ processing, errors }: { processing: boolean; errors: any }) => (
                                <Button type="submit" className="w-full" disabled={processing}>
                                    {processing && <Spinner />} Resend email
                                </Button>
                            )}
                        </Form>
                    </CardContent>
                    <CardFooter className="mx-auto flex justify-between">
                        <p className="text-sm">
                            Verify your email?{' '}
                            <Link href={showProfile.url()} className="text-primary font-medium underline">
                                Profile settings
                            </Link>
                        </p>
                    </CardFooter>
                </Card>
            </div>
        </div>
    );
}

export { VerifyEmailCard };
