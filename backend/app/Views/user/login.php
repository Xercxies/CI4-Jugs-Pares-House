<?php
$session = session();
$success = $session->getFlashdata('success');
$error = $session->getFlashdata('error');

$errors = [];
if (isset($validation) && is_object($validation)) {
    $errors = $validation->getErrors();
} elseif ($session->getFlashdata('errors')) {
    $errors = $session->getFlashdata('errors');
}
?>
<!doctype html>
<html lang="en">

</html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">Sign in to your account</h1>
            <p class="mt-2 text-sm text-gray-600">Enter your credentials to continue</p>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                <?= esc($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 bg-white p-8 rounded shadow-sm" action="<?= site_url('login') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autocomplete="email"
                    value="<?= esc(old('email')) ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    aria-describedby="email-help" />
                <p id="email-help" class="mt-2 text-xs text-gray-500">We'll never share your email.</p>
            </div>

            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10" />
                <button type="button" id="togglePwd" aria-label="Toggle password visibility"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    Show
                </button>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center text-sm">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <span class="ml-2 text-gray-700">Remember me</span>
                </label>
                <div class="text-sm">
                    <a href="<?= site_url('password/forgot') ?>" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="<?= site_url('register') ?>" class="font-medium text-indigo-600 hover:text-indigo-500">Create one</a>
            </p>
        </form>
    </div>

    <script>
        (function() {
            const pwd = document.getElementById('password');
            const btn = document.getElementById('togglePwd');
            if (!pwd || !btn) return;
            btn.addEventListener('click', function() {
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    btn.textContent = 'Hide';
                } else {
                    pwd.type = 'password';
                    btn.textContent = 'Show';
                }
            });
        })();
    </script>
</body>

</html>