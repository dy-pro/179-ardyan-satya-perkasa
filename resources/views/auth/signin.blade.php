<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('/styles.css') }}">
    <title>Login | Vitalog</title>
</head>
<body class="h-full bg-base-100">
    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h1 class="text-center font-omegle text-6xl">Vitalog</h1>
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-base-content">Sign in to your account</h2>
    </div>
  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if(session()->get('error'))
            <p class="text-error">{{ session()->get('error') }}</p>
        @endif
      <form class="space-y-6" action="{{ route('auth.login') }}" method="POST">
        @csrf
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-base-content">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="text" autocomplete="email" required class="nmorphu-sm bg-base-100 block w-full rounded-md border-0 px-3 py-1.5 dark:text-base-content shadow-sm ring-1 ring-inset ring-base-content placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
          </div>
        </div>
  
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-base-content">Password</label>
            {{-- <div class="text-sm">
              <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
            </div> --}}
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="nmorphu-sm bg-base-100 block w-full rounded-md border-0 px-3 py-1.5 text-base-content shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
          </div>
        </div>
  
        <div>
            <button 
                type="submit" 
                class="nmorphn flex w-full justify-center rounded-md bg-base-100 px-3 py-1.5 text-sm font-semibold leading-8 text-base-content dark:hover:text-black hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
            Sign in
            </button>
        </div>
      </form>
  
      <p class="mt-10 text-center text-sm text-gray-500">
        Don't have an account?
        <a href="{{ route('auth.registerPage') }}" class="font-semibold leading-6 text-primary hover:text-base-content">Sign up for free</a>
      </p>
    </div>
  </div>
    
</body>
</html>