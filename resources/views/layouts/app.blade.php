<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md border-r p-6">
            <div class="mb-6">
                <img src="/img/logo-idcloudhost.png" alt="Logo" class="h-10 mx-auto">
            </div>
            <nav class="space-y-4 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-800 hover:text-blue-600">Dashboard</a>
                <a href="{{ route('admin.absensi') }}" class="block text-gray-800 hover:text-blue-600">Data Absensi</a>
                <a href="{{ route('admin.lokasi') }}" class="block text-gray-800 hover:text-blue-600">Pengaturan Lokasi</a>
                <a href="{{ route('logout') }}" class="block text-red-600 hover:underline">Keluar</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
