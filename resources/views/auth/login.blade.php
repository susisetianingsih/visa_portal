@extends('layouts.guest')
@section('title', 'Login')
@section('content')
<div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="https://images.unsplash.com/photo-1491472253230-a044054ca35f?q=80&w=1784&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="https://images.unsplash.com/photo-1491472253230-a044054ca35f?q=80&w=1784&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto" src="{{ asset('asset/image/halodoc-logo.png') }}" alt="Your Company">
                    <h1 class="mb-10 text-2xl text-center font-semibold text-gray-700 dark:text-gray-200">VISA PORTAL</h1>
                </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login_post') }}">
                    @csrf
                    <label class="block text-sm" for="username">
                        <span class="text-gray-700 dark:text-gray-400">Username</span>
                        <input
                        id="username" 
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="CompanyXYZ"
                        type="text"
                        name="username"
                        :value="old('username')"
                        required autofocus autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('login')" class="mt-2" />

                    </label>
                    <label class="block mt-4 text-sm" for="password">
                        <span class="text-gray-700 dark:text-gray-400">Password</span>
                        <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="***************"
                        type="password"
                        name="password"
                        :value="old('password')"
                        required autofocus autocomplete="password"
                        />
                        <x-input-error :messages="$errors->get('login')" class="mt-2" />
                    </label>

                    {{-- Button --}}
                    <button class="btn block w-full px-4 py-2 mt-10 mb-8 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        {{ __('Log in') }}
                    </button>
                </form>              
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection