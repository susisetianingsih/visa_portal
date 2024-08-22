@extends('layouts.app')
@section('title', 'Overview Form')
@section('content')

      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            @php
                if (Auth::user()->role_id == 1) {
                  $overview = route('admin_form_overview_post');
                } elseif (Auth::user()->role_id == 2) {
                  $overview = route('vendor_form_overview_post');
                }
            @endphp
            
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            Overview
          </h2>
  
          <div class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto">
                <form x-ref="form" method="POST" action="{{ $overview }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label class="block text-sm" for="vendor_information">
                                <span class="text-gray-700 dark:text-gray-400">Vendor Information</span>
                                <textarea name="vendor_information" id="vendor_information"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                rows="3" placeholder="Perusahaan ini bergerak dibidang..."
                                required autofocus autocomplete="vendor_information">{{ old('vendor_information') }}</textarea>
                                <x-input-error :messages="$errors->get('vendor_information')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_name">
                                <span class="text-gray-700 dark:text-gray-400">Vendor's Name</span>
                                <input
                                    id="vendor_name" 
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Company XYZ"
                                    type="text"
                                    name="vendor_name"
                                    value="{{ old('vendor_name') }}"
                                    required autofocus autocomplete="vendor_name"
                                />
                                <x-input-error :messages="$errors->get('vendor_name')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_pic">
                                <span class="text-gray-700 dark:text-gray-400">Vendor's PIC</span>
                                <input
                                    id="vendor_pic" 
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Person in Contact"
                                    type="text"
                                    name="vendor_pic"
                                    value="{{ old('vendor_pic') }}"
                                    required autofocus autocomplete="vendor_pic"
                                />
                                <x-input-error :messages="$errors->get('vendor_pic')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="address">
                                <span class="text-gray-700 dark:text-gray-400">Address</span>
                                <input
                                    id="address" 
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Jl. Rasuna Said"
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    required autofocus autocomplete="address"
                                />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_email_address">
                                <span class="text-gray-700 dark:text-gray-400">Vendor's Email Address</span>
                                <input
                                    id="vendor_email_address" 
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="personincontact@mhealth.tech"
                                    type="email"
                                    name="vendor_email_address"
                                    value="{{ old('vendor_email_address') }}"
                                    required autofocus autocomplete="vendor_email_address"
                                />
                                <x-input-error :messages="$errors->get('vendor_email_address')" class="mt-2" />
                                </label>
                            </div>
                            <div class="sm:col-span-6">
                                <h3 class="mt-5 mb-2 text-xl font-semibold text-gray-600 dark:text-gray-400">
                                    Data Sensitivity
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-4 mb-4">
                            What is the nature of data that vendor will have access to? (Mark at the tickbox all that apply)
                            </p>
                            <div class="text-gray-600 dark:text-gray-400">
                                <input type="radio" id="no-risk" name="data_sensitivty" value="No Risk: No data exchanged, no security impact" {{ old('data_sensitivty') == "No Risk: No data exchanged, no security impact" ? 'checked' : '' }}>
                                No Risk: No data exchanged, no security impact
                                <br>

                                <input type="radio" id="low-risk" name="data_sensitivty" value="Low Risk: Only demographic information and projected financial information" {{ old('data_sensitivty') == "Low Risk: Only demographic information and projected financial information" ? 'checked' : '' }}>
                                Low Risk: Only demographic information and projected financial information
                                <br>

                                <input type="radio" id="medium-risk" name="data_sensitivty" value="Medium Risk: Only names, addresses and phone numbers" {{ old('data_sensitivty') == "Medium Risk: Only names, addresses and phone numbers" ? 'checked' : '' }}>
                                Medium Risk: Only names, addresses and phone numbers
                                <br>

                                <input type="radio" id="high-risk" name="data_sensitivty" value="High Risk: Non‐public private information (NPI), for example SSN, medical, financial, proprietary, and private information about individuals" {{ old('data_sensitivty') == "High Risk: Non‐public private information (NPI), for example SSN, medical, financial, proprietary, and private information about individuals" ? 'checked' : '' }}>
                                High Risk: Non‐public private information (NPI), for example SSN, medical, financial, proprietary, and private information about individuals
                                <br>
                            </div>
                            <x-input-error :messages="$errors->get('data_sensitivty')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-6">
                            <h3 class="mt-5 mb-2 text-xl font-semibold text-gray-600 dark:text-gray-400">
                                Questionnaire Instructions:
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-4">
                            Please complete the following questionnaire. Where details or descriptions are requested, please describe in Comments (or “Additional Information and Comments” section at end of questionnaire), or attach documentation with the requested details. Use N/A for Not Applicable where needed (enter under Comments).
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 sm:px-12 sm:pb-12">
                        {{-- Button --}}
                        <button 
                        @click.prevent="openModal({{ Auth::user()->id }}, '{{ Auth::user()->username  }}')"
                        class="btn px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        aria-label="Confirmation"
                        >
                            {{ __('Submit') }}
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
                                Overview Submission
                                </h2>
                                <!-- Modal description -->
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                Are you sure you want to submit?
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