<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
    <title>ユーザー登録</title>

</head>
<body>

<div class="bg-gray-800">
  <div class="p-8 lg:w-1/2 mx-auto">
    <div class="bg-white rounded-t-lg p-4">
      <p class="text-center text-sm text-gray-400 font-light">ユーザー登録</p>

    </div>
    <div class="bg-gray-100 rounded-b-lg py-12 px-4 lg:px-24">

      <form class="mt-6" action="{{ route('register.submit') }}" method="POST">
        @csrf
        <div class="relative">
          <input class="appearance-none border pl-12 border-gray-100 shadow-sm focus:shadow-md focus:placeholder-gray-600  transition  rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" name="name" id="name" value="{{ old('name') }}" type="text" placeholder="名前" required />
          <div class="absolute left-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 p-1" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
            </svg>
          </div>
        </div>
        <div class="relative mt-3">
          <input class="appearance-none border pl-12 border-gray-100 shadow-sm focus:shadow-md focus:placeholder-gray-600  transition  rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" type="text" placeholder="Email" type="email" name="email" id="email" value="{{ old('email') }}" required />
          <div class="absolute left-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 p-1" viewBox="0 0 20 20" fill="currentColor" >
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
          </div>
        </div>
        <div class="relative mt-3">
          <input class="appearance-none border pl-12 border-gray-100 shadow-sm focus:shadow-md focus:placeholder-gray-600  transition  rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" placeholder="Password" type="password" name="password" id="password" required />
          <div class="absolute left-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 p-1" viewBox="0 0 20 20" fill="currentColor" >
              <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />
            </svg>
          </div>
        </div>



        <div class="flex items-center justify-center mt-8">
          <button class="text-white py-2 px-4 uppercase rounded bg-indigo-500 hover:bg-indigo-600 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5" type="submit" >登録</button>
        </div>

        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @foreach ($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
        @endforeach

      </form>
    </div>
  </div>
</div>
</body>
</html>
