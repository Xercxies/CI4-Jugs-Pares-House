<?php
// app/Views/signup.php
// Simple, accessible signup form using Tailwind (CDNJS).
// Expects optional $validation (CodeIgniter\Validation\ValidationInterface)
// and old() helper for repopulation.
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Sign Up</title>
    <!-- Tailwind via CDNJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/3.4.6/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6">
    <main class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-semibold text-slate-800 mb-2">Create an account</h1>
        <p class="text-sm text-slate-500 mb-4">Sign up to access the dashboard and manage your listings.</p>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="mb-4 p-3 text-sm rounded bg-green-50 text-green-800">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-4 p-3 text-sm rounded bg-rose-50 text-rose-800">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif ?>

        <?php if (isset($validation) && $validation->getErrors()) : ?>
            <div class="mb-4 p-3 rounded bg-rose-50 text-rose-800 text-sm">
                <ul class="list-disc list-inside">
                    <?php foreach ($validation->getErrors() as $err) : ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="/signup" method="post" class="space-y-4" novalidate>
            <?= csrf_field() ?>

            <div>
                <label for="full_name" class="block text-sm font-medium text-slate-700">Full name</label>
                <input
                    id="full_name"
                    name="full_name"
                    type="text"
                    value="<?= esc(old('full_name')) ?>"
                    required
                    class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    aria-describedby="full_name_error" />
                <?php if (isset($validation) && $validation->getError('full_name')) : ?>
                    <p id="full_name_error" class="mt-1 text-xs text-rose-600"><?= esc($validation->getError('full_name')) ?></p>
                <?php endif ?>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="<?= esc(old('email')) ?>"
                    required
                    class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    aria-describedby="email_error" />
                <?php if (isset($validation) && $validation->getError('email')) : ?>
                    <p id="email_error" class="mt-1 text-xs text-rose-600"><?= esc($validation->getError('email')) ?></p>
                <?php endif ?>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    aria-describedby="password_error" />
                <?php if (isset($validation) && $validation->getError('password')) : ?>
                    <p id="password_error" class="mt-1 text-xs text-rose-600"><?= esc($validation->getError('password')) ?></p>
                <?php endif ?>
            </div>

            <div>
                <label for="password_confirm" class="block text-sm font-medium text-slate-700">Confirm password</label>
                <input
                    id="password_confirm"
                    name="password_confirm"
                    type="password"
                    required
                    class="mt-1 block w-full rounded-md border-slate-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    aria-describedby="password_confirm_error" />
                <?php if (isset($validation) && $validation->getError('password_confirm')) : ?>
                    <p id="password_confirm_error" class="mt-1 text-xs text-rose-600"><?= esc($validation->getError('password_confirm')) ?></p>
                <?php endif ?>
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        <?= old('terms') ? 'checked' : '' ?>
                        class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        aria-describedby="terms_error" />
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-slate-700">I agree to the <a href="/terms" class="text-indigo-600 underline">terms</a></label>
                    <?php if (isset($validation) && $validation->getError('terms')) : ?>
                        <p id="terms_error" class="mt-1 text-xs text-rose-600"><?= esc($validation->getError('terms')) ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    Sign up
                </button>
            </div>

            <p class="text-center text-sm text-slate-500">
                Already have an account?
                <a href="/login" class="text-indigo-600 underline">Log in</a>
            </p>
        </form>
    </main>
</body>

</html>