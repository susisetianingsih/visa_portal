@extends('layouts.app')
@section('title', 'Add Label')
@section('content')
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            Add Label
          </h2>
  
          {{-- Authenticated --}}
          <div
            class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
          >
            <div class="flex flex-col overflow-y-auto">
              <form method="POST" action="{{ route('label_add_post') }}">
                @csrf
              <div class="flex items-center justify-center p-6 sm:p-12 lg:w-1/2">
                <div class="w-full">
                  <label class="block text-sm" for="kode">
                            <span class="text-gray-700 dark:text-gray-400">Kode</span>
                            <input
                            id="kode" 
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="ISP"
                            type="text"
                            name="kode"
                            value="{{ old('kode') }}"
                            />
                            <x-input-error :messages="$errors->get('kode')" class="mt-2" />
                        </label>
                        <label class="block mt-4 text-sm" for="label">
                            <span class="text-gray-700 dark:text-gray-400">Label</span>
                            <input
                            id="kode" 
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Information Security Policy"
                            type="text"
                            name="label"
                            value="{{ old('label') }}"
                            />
                            <x-input-error :messages="$errors->get('label')" class="mt-2" />
                        </label>

                        {{-- Button --}}
                        <button class="btn px-4 py-2 mt-10 mb-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Add label') }}
                        </button> 
                </div>
                
              </div>
              </form>
            </div>
          </div>    
        </div>
      </main>
@endsection