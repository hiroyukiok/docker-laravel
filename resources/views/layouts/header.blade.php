<header class="bg-gray-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- ダッシュボードリンク -->
        <h1 class="text-lg font-bold">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-400">
                ダッシュボード
            </a>
        </h1>

        <!-- ユーザー名表示 -->
        <p class="text-sm">ようこそ、{{ Auth::user()->name }} さん！</p>
    </div>
</header>
