import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePage } from '@inertiajs/react';
import { ClockFadingIcon, KeyRoundIcon } from 'lucide-react';
import type { Passkey, TwoFactorPageProps } from '../../types';
import { AddPasskeyButton } from '../buttons/add-passkey-button';
import { DeletePasskeyButton } from '../buttons/delete-passkey-button';

export function PasskeysForm() {
    const { passkeys } = usePage().props as unknown as TwoFactorPageProps;

    return (
        <div className="flex flex-col gap-6 md:flex-row">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-xl leading-6 font-semibold md:text-2xl">Passkeys</h1>
                <p className="text-muted-foreground leading-5">Use passkeys for fast, secure, passwordless sign-in.</p>
            </div>
            <div className="flex w-full flex-col gap-8 md:w-1/2">
                <div className="flex flex-col gap-4">
                    <div className="flex flex-col gap-4">
                        <h4 className="text-sm font-bold md:text-base">
                            {passkeys.length === 0 ? 'You have not registered any passkeys.' : 'You have passkeys enabled.'}
                        </h4>
                        <p className="text-sm md:text-base">
                            When a passkey is registered, you can sign in quickly and securely without a password using your device's biometrics or a
                            hardware security key.
                        </p>
                    </div>
                    {passkeys.length > 0 && (
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="w-10"></TableHead>
                                    <TableHead className="text-muted-foreground">Name</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {passkeys.map((passkey: Passkey) => (
                                    <TableRow key={passkey.id}>
                                        <TableCell>
                                            <KeyRoundIcon className="text-muted-foreground" />
                                        </TableCell>
                                        <TableCell className="flex flex-col text-sm font-medium">
                                            <span>{passkey.name}</span>
                                            <span className="text-muted-foreground flex items-center gap-1">
                                                <ClockFadingIcon size={14} />{' '}
                                                {passkey.last_used_at ? `${passkey.last_used_at}` : 'This key has never been used'}
                                            </span>
                                        </TableCell>
                                        <TableCell className="text-right">
                                            <DeletePasskeyButton passkey={passkey} />
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    )}
                    <AddPasskeyButton />
                </div>
            </div>
        </div>
    );
}
