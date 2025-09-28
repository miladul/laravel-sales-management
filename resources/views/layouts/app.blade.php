<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sales Management System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @yield('head')
</head>
<body class="bg-gray-100 font-sans">
<nav class="bg-blue-600 text-white p-4 shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">Sales Management System</h1>
        <div class="space-x-4">
            <a href="{{ route('sales.index') }}" class="hover:underline">Sales List</a>
            <a href="{{ route('sales.create') }}" class="hover:underline">Create Sale</a>
            <a href="{{ route('sales.trash') }}" class="hover:underline">Trash</a>
        </div>
    </div>
</nav>
<main class="max-w-6xl mx-auto mt-6">
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</main>
@yield('scripts')
</body>
</html>
