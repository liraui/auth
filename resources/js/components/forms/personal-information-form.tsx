import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Spinner } from '@/components/ui/spinner';
import { SharedData } from '@/types';
import { Form, usePage } from '@inertiajs/react';
import { VerifyEmailButton } from '../buttons/verify-email-button';
import { submitResendEmailVerification } from '@/actions/LiraUi/Auth/Http/Controllers/EmailVerificationController';
import { submitProfileInformation } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';

function FormField({
    id,
    label,
    placeholder,
    defaultValue,
    error,
    disabled,
}: {
    id: string;
    label: string;
    placeholder: string;
    defaultValue: string;
    error?: string;
    disabled?: boolean;
}) {
    return (
        <div className="flex flex-col gap-y-2">
            <Label htmlFor={id}>{label}</Label>
            <Input
                id={id}
                placeholder={placeholder}
                defaultValue={defaultValue}
                name={id.replace('-', '_')} // Convert id to name (e.g., 'first-name' -> 'first_name')
                className={error ? 'ring-2 ring-red-500/60' : ''}
                disabled={disabled}
            />
            {error && <p className="text-sm text-red-500">{error}</p>}
        </div>
    );
}

function PersonalInformationForm() {
    const { auth, emailChangedTo } = usePage<
        SharedData & {
            emailChangedTo: { newEmail: string; expiresIn: string };
        }
    >().props;

    return (
        <div className="flex flex-col gap-4 md:flex-row md:gap-8">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-2xl leading-6 font-semibold">Personal information</h1>
                <p className="text-muted-foreground leading-5">Update your account's profile information and email address.</p>
            </div>
            <div className="flex w-full flex-col gap-4 md:w-1/2">
                <div className="flex flex-col gap-2">
                    <img src={auth.user.avatar} width={62} alt="Avatar" className="rounded-md" />
                    <div>
                        <h4 className="text-sm leading-4 font-medium">{auth.user.name}</h4>
                        <p className="text-muted-foreground text-sm leading-5 font-medium">{auth.user.email}</p>
                    </div>
                </div>
                {emailChangedTo.newEmail && (
                    <div>
                        <div className="flex gap-6">
                            <p className="text-destructive mt-1">
                                We have sent a verification code to <u>{emailChangedTo.newEmail}</u>. This request will expire in{' '}
                                {emailChangedTo.expiresIn}.
                            </p>
                            <VerifyEmailButton email={emailChangedTo.newEmail} />
                        </div>
                        <Separator className="my-4" />
                    </div>
                )}
                {!auth.user.email_verified_at && !emailChangedTo.newEmail && (
                    <div>
                        <div className="flex gap-6">
                            <p className="text-destructive mt-1">
                                Your email address is unverified. Would you like to resend email verification for <u>{auth.user.email}</u>?
                            </p>
                            <Form {...submitResendEmailVerification.form()} options={{ preserveScroll: true }} className="flex flex-col gap-y-6">
                                {({ processing, errors }) => (
                                    <Button type="submit" variant="ghost" className="cursor-pointer">
                                        {processing && <Spinner />} Resend
                                    </Button>
                                )}
                            </Form>
                        </div>
                        <Separator className="my-4" />
                    </div>
                )}
                <div>
                    <Card className="border-0 bg-transparent py-0 shadow-none">
                        <CardContent className="px-0">
                            <Form {...submitProfileInformation.form()} options={{ preserveScroll: true }} className="flex flex-col gap-y-6">
                                {({ processing, errors }) => (
                                    <>
                                        <div className="flex flex-col gap-y-4">
                                            <div className="flex flex-col gap-4 *:w-full sm:flex-row">
                                                <div className="flex w-full flex-col gap-y-2">
                                                    <Label htmlFor="first-name">First name</Label>
                                                    <Input
                                                        id="first-name"
                                                        type="text"
                                                        placeholder=""
                                                        name="first_name"
                                                        defaultValue={auth.user.first_name}
                                                    />
                                                    {errors.first_name && <span className="text-sm text-red-500">{errors.first_name}</span>}
                                                </div>
                                                <div className="flex w-full flex-col gap-y-2">
                                                    <Label htmlFor="last-name">Last name</Label>
                                                    <Input
                                                        id="last-name"
                                                        type="text"
                                                        placeholder=""
                                                        name="last_name"
                                                        defaultValue={auth.user.last_name}
                                                    />
                                                    {errors.last_name && <span className="text-sm text-red-500">{errors.last_name}</span>}
                                                </div>
                                            </div>
                                            <div className="flex flex-col gap-y-2">
                                                <Label htmlFor="email">Email</Label>
                                                <Input
                                                    id="email"
                                                    type="email"
                                                    defaultValue={emailChangedTo.newEmail ?? auth.user.email}
                                                    name="email"
                                                    className="mt-1 block w-full"
                                                    disabled={processing || emailChangedTo.newEmail !== null}
                                                />
                                                {errors.email && <p className="text-destructive mt-1 text-sm">{errors.email}</p>}
                                            </div>
                                        </div>
                                        <div className="flex w-full items-center gap-2 self-start sm:w-auto sm:self-end">
                                            <Button type="submit" disabled={processing}>
                                                {processing && <Spinner />} Update
                                            </Button>
                                        </div>
                                    </>
                                )}
                            </Form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
}

export { PersonalInformationForm };
