<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body>
    <div class="container mx-auto px-4">
    {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>