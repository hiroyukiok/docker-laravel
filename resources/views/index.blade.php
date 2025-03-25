<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
    @vite(['resources/css/app.css']) {{-- Viteを使用している場合 --}}
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-800"">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6">Welcome!</h1>

        <div class="flex flex-col space-y-4">
            <a href="{{ route('register') }}" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 text-center">
                新規ユーザー登録
            </a>
            <a href="{{ route('login') }}" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600 text-center">
                ログイン
            </a>
        </div>
    </div>
</body>
</html>
