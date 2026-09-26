<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EdTech Pro') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white selection:bg-indigo-500 selection:text-white">
        <div class="flex min-h-screen bg-white">
            
            <!-- Left Side: Form Container -->
            <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="w-full max-w-sm mx-auto lg:w-96">
                    <div>
                        <a href="/" class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <span class="text-2xl font-bold tracking-tight text-gray-900">EdTech <span class="text-indigo-600">Pro</span></span>
                        </a>
                        
                        @if (isset($title))
                            <h2 class="mt-8 text-3xl font-extrabold text-gray-900">
                                {{ $title }}
                            </h2>
                        @endif
                        @if (isset($subtitle))
                            <p class="mt-2 text-sm text-gray-600">
                                {{ $subtitle }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Right Side: Background Image / Branding -->
            <div class="relative hidden w-0 flex-1 lg:block">
                <div class="absolute inset-0 bg-indigo-600">
                    <img class="absolute inset-0 object-cover w-full h-full mix-blend-overlay" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80" alt="Students learning">
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/90 to-indigo-600/60"></div>
                </div>
                <div class="relative flex flex-col justify-center h-full px-12 text-white xl:px-24 z-10">
                    <blockquote class="mt-8">
                        <div class="max-w-3xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            "Education is the passport to the future, for tomorrow belongs to those who prepare for it today."
                        </div>
                        <footer class="mt-4">
                            <p class="text-base font-semibold text-indigo-200">Malcolm X</p>
                        </footer>
                    </blockquote>
                </div>
            </div>

        </div>
    </body>
</html>
