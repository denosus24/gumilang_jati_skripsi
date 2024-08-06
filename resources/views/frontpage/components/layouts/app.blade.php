<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title . ' - ' . env('APP_NAME') ?? env('APP_NAME') }}</title>

    @filamentStyles

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <x-frontpage::topbar></x-frontpage::topbar>

    <main>
        {{ $slot }}
    </main>

    <x-frontpage::footbar></x-frontpage::footbar>
</body>

@stack('scripts')
@livewire('notifications')
@filamentScripts

</html>
