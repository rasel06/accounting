<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div style="background-image: url('{{ url('/images/main_bg.jpg') }}')" class="bg-gray-50 bg-center">

        <div class=" min-h-screen flex flex-col justify-between  w-4/5 mx-auto">

            <header class="px-4 py-3  bg-slate-500/50 rounded-lg mt-2 text-cyan-500">
                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </header>

            {{-- <main class="mt-6 self-start   bg-slate-600">
                ok
            </main> --}}

            <footer class="py-3 mb-3 bg-white/50 rounded-lg mt-4 text-center">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>

        </div>
    </div>
</body>

</html>
