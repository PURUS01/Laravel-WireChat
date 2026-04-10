<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $currentPanel = \Wirechat\Wirechat\Facades\Wirechat::currentPanel();
    $title = $currentPanel->getHeading() ?? config('app.name', 'Laravel');
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <script>
        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        updateTheme(darkModeMediaQuery.matches);
        darkModeMediaQuery.addEventListener('change', (event) => updateTheme(event.matches));

        document.addEventListener('livewire:navigated', () => {
            updateTheme(window.matchMedia('(prefers-color-scheme: dark)').matches);
        });
    </script>

    @if ($currentPanel->hasFavicon())
        <link rel="icon" href="{{ $currentPanel->getFavicon() }}" />
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @wirechatStyles(panel: $panel)
</head>
<body x-data x-cloak class="font-sans antialiased">
    <div class="min-h-screen bg-[var(--wc-light-primary)] text-gray-900 dark:bg-[var(--wc-dark-primary)] dark:text-gray-100">
        <header class="border-b border-gray-200 bg-white/90 backdrop-blur dark:border-gray-800 dark:bg-[#0b0f1a]/90">
            <div class="mx-auto flex h-14 max-w-screen-2xl items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold tracking-wide">{{ config('app.name', 'Laravel') }}</span>
                    <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ $currentPanel->getId() }}
                    </span>
                </div>

                <div class="flex items-center gap-3 text-sm">
                    <span class="hidden text-gray-600 dark:text-gray-300 sm:inline">{{ auth()->user()?->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded border border-gray-300 px-3 py-1 text-xs hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="h-[calc(100vh-3.5rem)]">
            @yield('content', $slot ?? null)
        </main>
    </div>

    @livewireScripts
    @wirechatAssets(panel: $panel)
</body>
</html>
