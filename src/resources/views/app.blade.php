<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transcribe.work (Beta)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container py-4 mx-auto antialiased">
        <div class="flex items-center justify-between">
            <a href="/" class="text-xl font-semibold transition-colors duration-200 hover:text-purple-500">Transcribe.work <span class="px-2 py-1 text-xs text-white bg-black rounded">Beta</span></a>
            <a href="https://summarise.work/" target="_blank" class="block px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-black rounded-full hover:bg-purple-500" rel="noopener noreferrer">Try our GPT-4 Beta</a>
        </div>
    </div>
    @yield('content')
    <footer class="mt-12 mb-8 text-center">
        <p class="text-sm text-gray-500">Build with love by @ateliershen</p>
    </footer>
</body>