<div class="w-1/4 bg-gray-800 text-white p-5">
    <h2 class="text-xl font-bold mb-4">メニュー</h2>
    <ul>
        <li class="mb-2"><a href="{{ route('post.form') }}" class="block p-2 rounded hover:bg-gray-700">投稿</a></li>
        <li class="mb-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full p-2 text-left rounded hover:bg-gray-700">ログアウト</button>
            </form>
        </li>
    </ul>
</div>
