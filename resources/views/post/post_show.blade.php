@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold">{{ $post->getTitle() }}</h1>
        <p class="text-gray-600">投稿者: {{ $post->getName() }}</p>
        <p class="mt-4">{{ $post->getContent() }}</p>

        <div class="mt-6 flex space-x-4">
            <!-- ホームへ戻るボタン -->
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                ホームへ戻る
            </a>

            <!-- 削除ボタン -->
            <form action="{{ route('post.delete') }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                <input type="hidden" name="id" value="{{ $post->getId() }}">
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    削除
                </button>
            </form>
        </div>
    </div>
@endsection
