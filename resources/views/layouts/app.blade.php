<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ダッシュボード')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <!-- ヘッダー -->
    @include('layouts.header')

    <div class="flex h-screen">
        <!-- サイドメニュー -->
        @include('layouts.side')

        <!-- メインコンテンツ -->
        <div class="w-3/4 p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
