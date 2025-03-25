@extends('layouts.app')

@section('title', '記事投稿フォーム')

@section('content')
    <h1 class="text-2xl font-bold">記事投稿フォーム</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-md mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post.store') }}" method="POST" class="mt-6">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-200">
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium">内容</label>
            <textarea name="content" id="content" rows="4" required
                class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-200">{{ old('content') }}</textarea>
        </div>

        <div class="flex justify-center">
            <button type="submit"
                class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-6 py-2 rounded-md shadow-md transition">
                投稿する
            </button>
        </div>
    </form>
@endsection
