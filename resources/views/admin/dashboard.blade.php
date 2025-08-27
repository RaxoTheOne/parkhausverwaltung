<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                🏢 Parkhaus Admin
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('parkhaus.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Parkhaus
                        </a>
                        <a href="{{ route('admin.admins.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Admins
                        </a>
                        <a href="/" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Home
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistik-Karten -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-blue-800">Parkhäuser</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_parkhaeuser'] }}</p>
                        <p class="text-sm text-blue-600 mt-1">Gesamt</p>
                    </div>

                    <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-green-800">Aktive Tickets</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['active_tickets'] }}</p>
                        <p class="text-sm text-green-600 mt-1">Aktuell geparkt</p>
                    </div>

                    <div class="bg-yellow-100 p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-yellow-800">Heute Einfahrten</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['today_entries'] }}</p>
                        <p class="text-sm text-yellow-600 mt-1">Neue Fahrzeuge</p>
                    </div>

                    <div class="bg-purple-100 p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-purple-800">Gesamt Tickets</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_tickets'] }}</p>
                        <p class="text-sm text-purple-600 mt-1">Alle Zeiten</p>
                    </div>
                </div>

                <!-- Schnellzugriff -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Schnellzugriff</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.parkhaus.index') }}" class="block w-full text-left px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-150 ease-in-out">
                                    🏢 Parkhäuser verwalten
                                </a>
                                <a href="{{ route('admin.admins.index') }}" class="block w-full text-left px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-150 ease-in-out">
                                    👥 Admin-Benutzer verwalten
                                </a>
                                <a href="{{ route('parkhaus.index') }}" class="block w-full text-left px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-150 ease-in-out">
                                    🚗 Ein-/Ausfahrt simulieren
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">System-Status</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Datenbank</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Online
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Schranken</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktiv
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Kassenautomat</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Bereit
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
