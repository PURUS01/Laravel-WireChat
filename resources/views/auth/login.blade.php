<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Wirechat') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="relative isolate min-h-screen overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_#312e81_0%,_#0f172a_40%,_#020617_100%)]"></div>
        <div class="absolute -left-28 top-20 -z-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute -right-28 bottom-16 -z-10 h-72 w-72 rounded-full bg-cyan-500/20 blur-3xl"></div>

        <main class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-10">
            <section class="grid w-full overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur md:grid-cols-2">
                <div class="hidden md:flex flex-col justify-between border-r border-white/10 bg-gradient-to-b from-indigo-600/30 to-cyan-600/10 p-10">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.2em] text-indigo-200/90">WELCOME</p>
                        <h1 class="mt-3 text-3xl font-semibold leading-tight">
                            {{ config('app.name', 'Wirechat') }}
                        </h1>
                        <p class="mt-4 text-sm text-slate-300">
                            Continue to your conversations, manage groups, and chat in real time.
                        </p>
                    </div>
                    <p class="text-xs text-slate-300/80">Secure login powered by Laravel Auth</p>
                </div>

                <div class="p-6 sm:p-10">
                    <div class="mx-auto w-full max-w-md">
                        <h2 class="text-2xl font-semibold text-white">Sign in to your account</h2>
                        <p class="mt-2 text-sm text-slate-300">Use your email and password to access chats.</p>

                        @if ($errors->any())
                            <div class="mt-5 rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    class="w-full rounded-xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm text-white placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                                    placeholder="admin@example.com"
                                >
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="w-full rounded-xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm text-white placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                                    placeholder="Enter your password"
                                >
                            </div>

                            <label class="flex items-center gap-2 text-sm text-slate-300">
                                <input type="checkbox" name="remember" class="rounded border-white/20 bg-transparent text-indigo-500 focus:ring-indigo-400">
                                Remember me
                            </label>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/70"
                            >
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
