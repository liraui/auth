<?php

namespace LiraUi\Auth\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Spatie\RouteAttributes\Attributes\Get;

class DocsController extends Controller
{
    #[Get(
        uri: '/docs/auth/installation',
        name: 'docs.auth.installation',
        middleware: [
            'web',
        ]
    )]
    public function showInstallation(): InertiaResponse
    {
        if (! config('liraui-auth.docs_enabled', false)) {
            abort(404);
        }

        return Inertia::render('liraui-auth::docs/installation');
    }
}
