@extends('layouts.app')
@section('title', 'Email Notification')
@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Email for {{ $user_overview->vendor_name }}
        </h2>
        <div class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto">
                <form method="POST" action="{{ route('admin_email_post', $user_overview->user_id) }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="email">
                                <span class="text-gray-700 dark:text-gray-400">Email to</span>
                                <input
                                    id="email"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="personincontact@gmail.com"
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user_overview->vendor_email_address) }}"
                                    required autofocus autocomplete="email"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="subject">
                                <span class="text-gray-700 dark:text-gray-400">Subject</span>
                                <input
                                    id="subject"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Comments Regarding Halodoc VISA Portal"
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject', $subject) }}"
                                    required autofocus autocomplete="subject"
                                />
                                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="block text-sm" for="message">
                                <span class="text-gray-700 dark:text-gray-400">Message</span>
                                <textarea
                                    name="message"
                                    id="message"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    rows="3"
                                    type="text"
                                    placeholder="Enter some long form content."
                                >{!! e(old('message', $message)) !!}</textarea>
                                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                            </label>
                        </div>
                    </div>
                    <div class="px-6 pb-6 sm:px-12 sm:pb-12">
                        {{-- Button --}}
                        <button @click.prevent="openModal({{ $result->user_id }}, '{{ $result->username  }}')" class="btn px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Sent email') }}
                        </button>
                    </div>
                    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
                        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
                            <!-- Modal -->
                            <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
                            @keydown.escape="closeModal"
                            class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                            role="dialog" id="modal">
                            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                            <header class="flex justify-end">
                                <button
                                    class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                                    aria-label="close" @click.prevent="closeModal">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                                        <path
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </header>
                            <!-- Modal body -->
                            <div class="mt-4 mb-6">
                                <!-- Modal title -->
                                <h2 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Email Notification
                                </h2>
                                <!-- Modal description -->
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                Are you sure you want to sent this email?
                                </p>
                            </div>
                            <footer
                                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                                <button 
                                    @click.prevent="closeModal"
                                    class="w-full px-5 py-3 text-sm font-medium leading-5  text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                    {{ __('No, cancel') }}
                                </button>
                                <button
                                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:px-4 sm:py-2 sm:w-auto active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                                    @click="submitForm()">
                                    {{ __('Yes, submit') }}
                                </button>
                            </footer>
                            </div>
                        </div>
                    <!-- End of modal backdrop -->
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
