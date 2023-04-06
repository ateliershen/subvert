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
        <div class="max-w-2xl p-4 mx-auto mb-12 text-left border border-gray-200 rounded">
            <h3 class="mb-4 text-lg font-bold">How to use?</h3>
            <ul class="pl-4 list-disc list-outside">
                <li>You can upload audio and video files to this server, and we will transcribe it for you.</li>
                <li>However, you will get the result much faster When your file is smaller.</li>
                <li>It's still in beta, please expect errors form time to time (and let us know!)</li>
                <li>Most importantly, let us know how to make this tool more helpful :-)</li>
            </ul>
        </div>
        <p class="text-sm text-gray-500">Build with love by @ateliershen. Any feedback? Let's talk: shenwc@sph.com.sg</p>
    </footer>
</body>