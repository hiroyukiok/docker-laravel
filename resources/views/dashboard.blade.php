@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">投稿一覧</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <div class="bg-white shadow-md rounded-lg overflow-hidden p-4">
                    <div class="border-b pb-2 mb-2">
                        <a href="{{ route('post.show', ['user_id' => $post->getUserId(), 'post_id' => $post->getId()]) }}" class="text-lg font-semibold text-blue-600 hover:underline">
                            {{ $post->getTitle() }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ページネーション -->
        <div class="mt-6">
            {{ $posts->links() }} 
        </div>
    </div>
@endsection
