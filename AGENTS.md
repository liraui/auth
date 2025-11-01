# AGENTS.md

## Laravel/PHP Code Style Guide

### Naming Conventions

This document outlines the recommended naming conventions for Laravel classes and methods. Adhering to these conventions ensures consistency, clarity, and optimal compatibility with development tools.

---

### 1. Controller Classes

Controller class names should be descriptive, end with the `Controller` suffix, and follow `PascalCase`. The name should reflect the primary resource or function the controller manages.

**Good Examples:**
- `UserController`
- `AuthController`
- `ProfileController`

**Bad Examples:**
- `Users` (missing Controller suffix)
- `HandleAuth` (not descriptive)
- `AuthManager` (wrong suffix)

---

### 2. Controller Methods

Method names should be action-oriented, use `camelCase`, and be as descriptive as possible. Follow RESTful conventions where applicable.

**Common Patterns:**
- **Display forms:** `showLoginForm`, `showRegistrationForm`, `showResetPasswordForm`
- **Process actions:** `login`, `register`, `logout`, `resetPassword`
- **Resource operations:** `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`

**Good Examples:**
- `login` (process authentication)
- `showLoginForm` (display login form)
- `updateProfile` (update user profile)
- `changePassword` (change user password)

**Bad Examples:**
- `submitLogin` (redundant prefix)
- `doAuthentication` (vague)
- `handleUserUpdate` (verbose)

---

### 3. Action Classes

Action classes encapsulate single business logic operations and should be named using the `VerbNounAction` pattern in `PascalCase`.

**Pattern:** `{Verb}{Noun}Action`

**Good Examples:**
- `AuthenticateUserAction`
- `SendEmailAction`
- `ProcessPaymentAction`
- `RegisterUserAction`

**Bad Examples:**
- `UserAuth` (missing Action suffix, unclear verb)
- `EmailSender` (wrong suffix)
- `PaymentProcessor` (wrong suffix)

---

### 4. Request Classes

Form request classes handle validation and should be named using descriptive patterns in `PascalCase`.

**Patterns:**
- `{Action}Request` for simple actions: `LoginRequest`, `RegisterRequest`
- `{Verb}{Noun}Request` for complex operations: `UpdateProfileRequest`, `ChangePasswordRequest`

**Good Examples:**
- `LoginRequest`
- `UpdateProfileRequest`
- `SendPasswordResetLinkRequest`
- `ShowRecoveryCodesRequest`

**Bad Examples:**
- `UserLoginFormRequest` (too verbose)
- `ProfileUpdate` (missing Request suffix)
- `ForgotPassword` (use `SendPasswordResetLink` for clarity)

---

### 5. Response Classes

Response classes handle HTTP responses and should be named using the `{Verb}{Noun}Response` pattern in `PascalCase`.

**Pattern:** `{Verb}{Noun}Response`

**Good Examples:**
- `AuthenticateUserResponse`
- `SendEmailResponse`
- `UpdateProfileResponse`
- `ChangePasswordResponse`

**Bad Examples:**
- `UserAuthResponse` (noun-first, unclear action)
- `EmailSendResponse` (awkward grammar)
- `UserProfileUpdatedResponse` (too verbose)

---

### 6. Contract Classes (Interfaces)

Contract classes define interfaces and should use clear, descriptive names in `PascalCase`. The pattern depends on the contract's purpose:

**Action Contracts (VerbNoun pattern):**
Define what an action does. Use present tense third-person singular.

- `AuthenticatesUser` (handles user authentication)
- `ChangesUserPassword` (changes user password)
- `SendsUserEmailVerification` (sends verification email)
- `RegistersUser` (registers a new user)
- `DeletesUser` (deletes user account)

**Response Contracts (NounVerb pattern):**
Define responses to events. Use past tense or state.

- `UserAuthenticated` (user was authenticated)
- `UserRegistered` (user was registered)
- `UserLoggedOut` (user logged out)
- `PasswordChanged` (password was changed)
- `EmailVerified` (email was verified)
- `SessionInvalidated` (session was invalidated)

**Service Contracts:**
Define services and utilities.

- `Otp` (OTP service)
- `OtpStore` (OTP storage)

**Good Examples:**
- `AuthenticatesUser` (action)
- `UserAuthenticated` (response)
- `ChangesUserPassword` (action)
- `PasswordChanged` (response)

**Bad Examples:**
- `UserAuth` (unclear, missing context)
- `PasswordChange` (use `ChangesUserPassword` for action or `PasswordChanged` for response)
- `Authenticate` (too generic, add context)

---

### 7. Service Providers

Service provider classes should end with `ServiceProvider` and follow `PascalCase`. The name should reflect the module or functionality.

**Good Examples:**
- `AuthServiceProvider`
- `RouteServiceProvider`
- `AppServiceProvider`

**Bad Examples:**
- `AuthProvider` (missing ServiceProvider suffix)
- `RoutesProvider` (inconsistent naming)

---

### General Principles

1. **Be Explicit:** Names should clearly convey purpose without needing additional context
2. **Be Consistent:** Follow established patterns throughout the codebase
3. **Avoid Redundancy:** Don't repeat information already clear from namespace or context
4. **Use Standard Terms:** Stick to common Laravel/PHP terminology
5. **Keep It Concise:** Descriptive doesn't mean verbose

---

## Laravel Wayfinder Routing Guide

### Overview

Laravel Wayfinder automatically generates type-safe route helpers for your frontend based on route attributes in your Laravel controllers. This eliminates manual route management and provides IntelliSense support in TypeScript.

### Controller-Side Setup

#### 1. Route Attributes

Use Spatie Route Attributes to define routes directly in your controllers. Wayfinder reads these attributes to generate frontend route helpers.

**Pattern:**
```php
use Spatie\RouteAttributes\Attributes\{Get, Post, Put, Delete, Patch};

#[{Method}(
    uri: '{route-path}',
    name: '{route.name}',
    middleware: ['{middleware}']
)]
public function {methodName}(): Response
{
    // Controller logic
}
```

**Example:**
```php
<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ProfileController extends Controller
{
    #[Get(
        uri: '/profile/settings',
        name: 'profile.settings',
        middleware: ['web', 'auth', 'verified']
    )]
    public function showProfileSettings(): InertiaResponse
    {
        return Inertia::render('profile/settings');
    }

    #[Post(
        uri: '/profile/update',
        name: 'profile.update',
        middleware: ['web', 'auth', 'verified', 'throttle:6,1']
    )]
    public function submitUpdateProfile(UpdateProfileRequest $request): Response
    {
        // Update logic
        return back()->with('status', 'profile-updated');
    }
}
```

#### 2. Naming Conventions for Route Methods

**GET Routes (Display/Show):**
- Prefix with `show` for pages/forms: `showLogin`, `showProfileSettings`
- Use descriptive nouns: `showDashboard`, `showVerifyEmail`

**POST Routes (Submit/Process):**
- Prefix with `submit` for form submissions: `submitLogin`, `submitUpdateProfile`
- Use action verbs for clarity: `submitEnableTwoFactor`, `submitResetPassword`

**DELETE Routes:**
- Prefix with `delete`: `deleteAccount`, `deleteBrowserSession`

**PUT/PATCH Routes:**
- Prefix with `update`: `updateProfile`, `updatePassword`

#### 3. Route Parameters

For routes with parameters, use standard Laravel syntax:

```php
#[Get(
    uri: '/posts/{post}',
    name: 'posts.show',
    middleware: ['web']
)]
public function showPost(Post $post): InertiaResponse
{
    return Inertia::render('posts/show', ['post' => $post]);
}

#[Put(
    uri: '/posts/{post}/update',
    name: 'posts.update',
    middleware: ['web', 'auth']
)]
public function updatePost(Post $post, UpdatePostRequest $request): Response
{
    // Update logic
}
```

---

### Frontend Integration

#### 1. Vite Configuration

Wayfinder is configured in `vite.config.js`:

```javascript
import { wayfinder } from '@laravel/vite-plugin-wayfinder';

export default defineConfig({
    plugins: [
        wayfinder({
            formVariants: true, // Enable form helper methods
        }),
    ],
    resolve: {
        alias: {
            '@auth': resolve(__dirname, 'vendor/liraui/auth/resources/js'),
        },
    },
});
```

#### 2. Generated Route Helpers

Wayfinder generates route helpers in `resources/js/actions/` organized by namespace and controller:

**File Structure:**
```
resources/js/actions/
├── App/
│   └── Http/
│       └── Controllers/
│           ├── DashboardController.ts
│           ├── HomeController.ts
│           └── index.ts
└── LiraUi/
    └── Auth/
        └── Http/
            └── Controllers/
                ├── AuthController.ts
                ├── ProfileController.ts
                └── index.ts
```

#### 3. Using Route Helpers in React Components

**Basic Usage (Navigation/Links):**

```tsx
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';
import { showLogin, showRegister } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Link } from '@inertiajs/react';

export function Navigation() {
    return (
        <nav>
            <Link href={showDashboard.url()}>Dashboard</Link>
            <Link href={showLogin.url()}>Login</Link>
            <Link href={showRegister.url()}>Register</Link>
        </nav>
    );
}
```

**With Inertia Link (Recommended):**

```tsx
import { showProfileSettings } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Link } from '@inertiajs/react';

<Link href={showProfileSettings.url()}>Profile Settings</Link>
```

**Form Submissions:**

```tsx
import { submitLogin } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { Form } from '@inertiajs/react';

export function LoginForm() {
    return (
        <Form 
            method={submitLogin().method} 
            action={submitLogin.url()}
        >
            {/* Form fields */}
            <button type="submit">Login</button>
        </Form>
    );
}
```

**Using Form Helpers (with formVariants: true):**

```tsx
import { submitUpdateProfile } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';

export function ProfileForm() {
    return (
        <form {...submitUpdateProfile.form()}>
            {/* Form fields */}
            <button type="submit">Update Profile</button>
        </form>
    );
}
```

**Programmatic Navigation:**

```tsx
import { router } from '@inertiajs/react';
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';

// Visit route
router.visit(showDashboard.url());

// GET request
router.get(showDashboard.url());

// POST request with data
router.post(submitLogin.url(), {
    email: 'user@example.com',
    password: 'password',
});
```

#### 4. Route Parameters in Frontend

**Single Parameter:**

```tsx
import { showPost, updatePost } from '@/actions/App/Http/Controllers/PostController';

// Generated helpers accept parameters
const postId = 123;

// Navigation
<Link href={showPost.url({ post: postId })}>View Post</Link>

// Form submission
router.put(updatePost.url({ post: postId }), formData);
```

**Multiple Parameters:**

```tsx
import { showComment } from '@/actions/App/Http/Controllers/CommentController';

// Route: /posts/{post}/comments/{comment}
<Link href={showComment.url({ post: 1, comment: 5 })}>
    View Comment
</Link>
```

#### 5. Query Parameters

Add query strings to any route:

```tsx
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';

// With query option
<Link href={showDashboard.url({ query: { tab: 'settings', sort: 'asc' } })}>
    Dashboard Settings
</Link>
// Generates: /dashboard?tab=settings&sort=asc

// Merge with existing query params
<Link href={showDashboard.url({ mergeQuery: { filter: 'active' } })}>
    Active Items
</Link>
```

#### 6. Method Variants

Each route helper provides method-specific variants:

```tsx
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';

// Default (uses primary method)
showDashboard.url() // GET

// Explicit method
showDashboard.get() // Returns { url: '/dashboard', method: 'get' }
showDashboard.head() // Returns { url: '/dashboard', method: 'head' }

// Form variant (when formVariants: true)
showDashboard.form() // Returns { action: '/dashboard', method: 'get' }
showDashboard.form.get()
```

#### 7. Type Safety

All route helpers are fully typed:

```tsx
import type { RouteDefinition, RouteQueryOptions } from '@/wayfinder';

// Type-safe route definitions
const route: RouteDefinition<'get'> = showDashboard();

// Query options are typed
const options: RouteQueryOptions = {
    query: { tab: 'settings' },
    mergeQuery: { filter: 'active' },
};
```

---

### Package-Specific Routes (liraui/auth)

For routes defined in vendor packages like `liraui/auth`, routes are namespaced under their package:

**Generated Path:**
```
resources/js/actions/LiraUi/Auth/Http/Controllers/
```

**Usage:**
```tsx
import { 
    showLogin, 
    submitLogin, 
    submitLogout 
} from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';

import { 
    showProfileSettings,
    submitUpdateProfile 
} from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
```

**Note:** Package routes maintain their full namespace to avoid conflicts with application routes.

---

### Best Practices

1. **Always Use Route Helpers:** Never hardcode URLs in your React components
   ```tsx
   // ❌ Bad
   <Link href="/dashboard">Dashboard</Link>
   
   // ✅ Good
   import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';
   <Link href={showDashboard.url()}>Dashboard</Link>
   ```

2. **Import Only What You Need:** Be specific with imports
   ```tsx
   // ✅ Good
   import { showLogin, submitLogin } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
   
   // ❌ Less optimal (imports everything)
   import * as AuthController from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
   ```

3. **Use Type Definitions:** Leverage TypeScript for safety
   ```tsx
   import type { RouteDefinition } from '@/wayfinder';
   
   const handleNavigation = (route: RouteDefinition<'get'>) => {
       router.visit(route.url);
   };
   ```

4. **Consistent Naming:** Match controller method names between backend and frontend usage
   - Backend: `showProfileSettings()` → Frontend: `showProfileSettings.url()`
   - Backend: `submitLogin()` → Frontend: `submitLogin.url()`

5. **Regenerate Routes:** Run `npm run dev` or `npm run build` after adding/modifying routes to regenerate helpers

6. **Use Form Helpers for POST/PUT/DELETE:** Simplifies form handling
   ```tsx
   import { submitUpdateProfile } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
   
   <form {...submitUpdateProfile.form()}>
       {/* Form content */}
   </form>
   ```

---

### Common Patterns

**Navigation Menu:**
```tsx
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';
import { showProfileSettings } from '@/actions/LiraUi/Auth/Http/Controllers/ProfileController';
import { Link } from '@inertiajs/react';

const menuItems = [
    { label: 'Dashboard', href: showDashboard.url() },
    { label: 'Profile', href: showProfileSettings.url() },
];

export function NavigationMenu() {
    return (
        <nav>
            {menuItems.map(item => (
                <Link key={item.label} href={item.href}>
                    {item.label}
                </Link>
            ))}
        </nav>
    );
}
```

**Logout Action:**
```tsx
import { submitLogout } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { router } from '@inertiajs/react';

export function LogoutButton() {
    const handleLogout = () => {
        router.post(submitLogout.url());
    };
    
    return <button onClick={handleLogout}>Logout</button>;
}
```

**Conditional Redirects:**
```tsx
import { showLogin } from '@/actions/LiraUi/Auth/Http/Controllers/AuthController';
import { showDashboard } from '@/actions/App/Http/Controllers/DashboardController';
import { router } from '@inertiajs/react';

const redirectUser = (isAuthenticated: boolean) => {
    const destination = isAuthenticated 
        ? showDashboard.url() 
        : showLogin.url();
    
    router.visit(destination);
};
```

---

### Troubleshooting

**Routes Not Generated:**
- Ensure route attributes are properly formatted in controllers
- Verify `spatie/laravel-route-attributes` is configured in `config/route-attributes.php`
- Run `npm run dev` to regenerate routes
- Check that controllers are in the registered route directory

**Type Errors:**
- Ensure `@laravel/vite-plugin-wayfinder` is up to date
- Regenerate routes with `npm run build`
- Check TypeScript configuration in `tsconfig.json`

**Missing Routes from Packages:**
- Verify package routes are registered in service provider
- Check alias configuration in `vite.config.js`
- Ensure package controllers use route attributes

---
