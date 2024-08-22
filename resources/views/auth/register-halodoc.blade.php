@extends('layouts.app')
@section('title', 'Registrasi')
@section('content')
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            Registrasi
          </h2>
  
          {{-- Authenticated --}}
          <div
            class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
          >
            <div class="flex flex-col overflow-y-auto">
              <form method="POST" action="{{ route('register_post') }}">
                @csrf
              <div class="flex items-center justify-center p-6 sm:p-12 lg:w-1/2">
                <div class="w-full">
                  <label class="block text-sm" for="username">
                            <span class="text-gray-700 dark:text-gray-400">Username</span>
                            <input
                            id="username" 
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="CompanyXYZ"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            required autofocus autocomplete="username"
                            />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </label>
                        <label class="block mt-4 text-sm" for="password">
                            <span class="text-gray-700 dark:text-gray-400">Password</span>
                            <input
                            id="password"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="***************"
                            type="password"
                            name="password"
                            value="{{ old('password') }}"
                            required autofocus autocomplete="password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </label>
                        <label class="block mt-4 text-sm" for="role_id">
                              <span class="text-gray-700 dark:text-gray-400">
                                Role
                              </span>
                              <select
                              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                              name="role_id"
                              id="role_id"
                              >
                                <option value="" selected disabled>Select role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role['id'] }}" {{ old('role_id') == $role['id'] ? 'selected' : '' }}>{{ $role['role'] }}</option>
                                @endforeach
                              </select>
                            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                        </label>



                        {{-- Button --}}
                        <button class="btn px-4 py-2 mt-10 mb-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Register') }}
                        </button> 
                </div>
              </div>
              </form>
            </div>
          </div>    
        </div>
      </main>
@endsection