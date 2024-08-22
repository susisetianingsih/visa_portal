@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            @php
            if (Auth::user()->role_id == 1) {
                $profile_post = route('admin_profile_post', $user->id );
            } elseif (Auth::user()->role_id == 2) {
                $profile_post = route('vendor_profile_post', $user->id);
            } else {
                $profile_post = route('guest_profile_post', $user->id);
            }
            @endphp
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Hallo! This is your profil page, <span class="uppercase">{{ $user->username }}</span>! 😁
            </h2>
            <div class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto">
                <form method="POST" action="{{ $profile_post }}">
                    @method('put')
                    @csrf
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                        <div class="sm:col-span-6 text-white rounded-lg">
                            <label class="block" for="question">
                                <p class="text-gray-700 dark:text-gray-400">
                                    You can change your password here!
                                </p>
                                <p class="text-gray-700 dark:text-gray-400">
                                    <i>Kamu bisa mengganti passwordmu disini!</i>
                                </p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block mt-4 text-sm" for="password">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="***************"
                                type="password"
                                name="password"
                                value="{{ old('password', $user['password']) }}"
                                required autofocus autocomplete="password"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </label>
                        </div>
                    </div>
                    <div class="px-6 pb-6 sm:px-12 sm:pb-12">
                        {{-- Button --}}
                        <button class="btn px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Submit') }}
                        </button> 
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection