<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
    <title>ログイン</title>

</head>
<body>



<div class="bg-gray-800">
  <div class="p-8 lg:w-1/2 mx-auto">
    <div class="bg-white rounded-t-lg p-4">
      <p class="text-center text-sm text-gray-400 font-light">ログイン</p>

    </div>
    <div class="bg-gray-100 rounded-b-lg py-12 px-4 lg:px-24">
    <!-- エラーメッセージの表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form class="mt-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="relative">
          <input class="appearance-none border pl-12 border-gray-100 shadow-sm focus:shadow-md focus:placeholder-gray-600  transition  rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" placeholder="Email" type="email" name="email" id="email" value="{{ old('email') }}" required />
          <div class="absolute left-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 p-1" viewBox="0 0 20 20" fill="currentColor" >
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
          </div>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
        </div>
        <div class="relative mt-3">
          <input class="appearance-none border pl-12 border-gray-100 shadow-sm focus:shadow-md focus:placeholder-gray-600  transition  rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" placeholder="Password" type="password" name="password" id="password" required />          <div class="absolute left-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 p-1" viewBox="0 0 20 20" fill="currentColor" >
              <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />
            </svg>
          </div>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        </div>

        <div class="flex items-center justify-center mt-8">
          <button class="text-white py-2 px-4 uppercase rounded bg-indigo-500 hover:bg-indigo-600 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5" >ログイン</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>