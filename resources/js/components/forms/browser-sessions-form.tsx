import { deleteInvalidateBrowserSession } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Badge } from '@/components/ui/badge';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { XIcon } from 'lucide-react';
import { useState } from 'react';
import { PasswordConfirmationDialog } from '../dialogs/password-confirmation-dialog';

interface BrowserSession {
    id: string;
    agent: {
        platform: string;
        browser: string;
    };
    ip_address: string;
    is_current_device: boolean;
    last_active: string;
}

function BrowserSessionsForm() {
    const { auth, sessions } = usePage<
        SharedData & {
            sessions: BrowserSession[];
            [key: string]: any;
        }
    >().props;

    const [sessionToInvalidate, setSessionToInvalidate] = useState<BrowserSession | null>(null);
    const [showPasswordDialog, setShowPasswordDialog] = useState(false);

    const confirmSessionToInvalidate = (session: BrowserSession) => {
        setSessionToInvalidate(session);
        setShowPasswordDialog(true);
    };

    const form = sessionToInvalidate ? deleteInvalidateBrowserSession.form({ session_id: sessionToInvalidate.id }) : null;

    return (
        <div className="flex flex-col gap-6 md:flex-row">
            <div className="flex w-full flex-col gap-2 md:w-1/2">
                <h1 className="text-xl leading-6 font-semibold md:text-2xl">Browser sessions</h1>
                <p className="text-muted-foreground leading-5">Manage and log out your active sessions on other browsers and devices.</p>
            </div>
            <div className="flex w-full flex-col gap-8 md:w-1/2">
                <div className="flex flex-col gap-4">
                    <h4 className="text-sm md:text-base">
                        If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions
                        are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also
                        update your password.
                    </h4>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-16"></TableHead>
                                <TableHead className="text-muted-foreground">Name</TableHead>
                                <TableHead></TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {sessions.map((session) => (
                                <TableRow key={session.id}>
                                    <TableCell>
                                        <img src={auth.user.avatar} width={62} alt="Avatar" className="rounded-md" />
                                    </TableCell>
                                    <TableCell className="flex flex-col text-sm font-medium">
                                        <span>
                                            {session.agent.platform} - {session.agent.browser}
                                        </span>
                                        <span className="text-muted-foreground">{session.ip_address}</span>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant={session.is_current_device ? 'default' : 'outline'}>
                                            {session.is_current_device ? 'This device' : session.last_active}
                                        </Badge>
                                    </TableCell>
                                    <TableCell className="text-right">
                                        {!session.is_current_device && (
                                            <button
                                                type="button"
                                                onClick={() => confirmSessionToInvalidate(session)}
                                                className="text-muted-foreground hover:text-primary transition-colors"
                                                title="Log out this session"
                                            >
                                                <XIcon size={16} />
                                            </button>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                    {form && (
                        <PasswordConfirmationDialog
                            show={showPasswordDialog}
                            onOpenChange={(open: boolean) => {
                                setShowPasswordDialog(open);
                                if (!open) {
                                    setSessionToInvalidate(null);
                                }
                            }}
                            title="Invalidate browser session"
                            description={
                                sessionToInvalidate
                                    ? `Please confirm your password before logging out your session on ${sessionToInvalidate.agent.platform} - ${sessionToInvalidate.agent.browser} (${sessionToInvalidate.ip_address}).`
                                    : 'Please confirm your password to continue.'
                            }
                            form={form}
                            success={() => {
                                setShowPasswordDialog(false);
                                setSessionToInvalidate(null);
                            }}
                            confirmButtonText="Log out"
                            confirmButtonVariant="destructive"
                        />
                    )}
                </div>
            </div>
        </div>
    );
}

export { BrowserSessionsForm };
