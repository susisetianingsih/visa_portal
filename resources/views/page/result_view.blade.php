@extends('layouts.app')
@section('title', 'Result View')
@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <div class="flex justify-between items-center my-6">
                @php
                    if (Auth::user()->role_id == 1) {
                        $download = route('admin_download_result', $result->user_id);
                    } else {
                        $download = route('guest_download_result', $result->user_id);
                    }
                @endphp
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Assessment Result of <span class="uppercase">{{ $result->user['username'] }}</span>
                </h2>
                <a href="{{ $download }}" class="px-4 py-2 text-sm ml-3 md:ml-auto font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Download PDF
                </a>
            </div>
            <span class="px-2 inline-block py-1 font-semibold leading-tight text-{{ $result->result_status->color }} bg-red-100 rounded-full dark:text-white dark:bg-{{ $result->result_status->color }}">
            </span>

            @if ($result->overview == true)    
            <div class="min-w-0 p-4 my-6 text-white bg-purple-600 rounded-lg shadow-xs">
              <h2 class="text-2xl font-semibold uppercase">Overview</h2>
            </div>
            <div class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <div class="flex flex-col overflow-y-auto">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 p-6 sm:p-12 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_information">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Vendor Information</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->vendor_information }}</p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_name">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Vendor's Name</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->vendor_name }}</p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_pic">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Vendor's PIC</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->vendor_pic }}</p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="address">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Address</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->address }}</p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_email_address">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Vendor's Email Address</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->vendor_email_address }}</p>
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="vendor_information">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Data Sensitivity</span>
                                <p class="text-gray-700 mt-2 dark:text-gray-400">{{ $user_overview->data_sensitivty }}</p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>            
            @endif 

            @if ($result->visa == true)
            <div class="min-w-0 p-4 my-6 text-white bg-purple-600 rounded-lg shadow-xs">
              <h2 class="text-2xl font-semibold uppercase">VISA</h2>
            </div>
            
            <div class="flex-1 w-full mx-auto bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <div class="flex flex-col">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                        @php
                            $deleteLabelAssessment = [];
                            
                            foreach ($user_visa as $visa){
                                $deleteLabelAssessment[$visa->id] = true;
                            }
                        @endphp
                        
                        @foreach ($labels as $label)
                            <div class="sm:col-span-6 p-3 text-white bg-purple-600 rounded-lg">
                                <label class="block text-sm">
                                    <h2 class="text-xl font-semibold">{{ $label->label }}</h2>
                                </label>
                            </div>
                            @php
                            $num = 1;
                            @endphp
                            @foreach ($user_visa as $visa)
                                @if ($visa->assessment)
                                    @if ($visa->assessment->label_id == $label->id)
                                        @php
                                        unset($deleteLabelAssessment[$visa->id]);
                                        @endphp
                                        <div class="sm:col-span-6 mt-6"> 
                                            <label class="block text-sm" for="question">
                                                <span class="text-xl font-semibold text-gray-700 dark:text-white">Question {{ $num++}}</span>
                                                <p class="text-gray-700 mt-4 dark:text-gray-400">{!! nl2br(e($visa->assessment->question)) !!}</p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-3 border border-purple-500 p-3">
                                            <label class="block text-sm" for="halodoc_expectation">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Halodoc Expectation</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($visa->assessment->halodoc_expectation)) !!}</p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-3 border border-purple-500 p-3">
                                            <label class="block text-sm" for="expected_evidence">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Expected Evidence</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($visa->assessment->expected_evidence)) !!}</p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="implementation_status_id">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Implementation Status</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {{ $visa->implementation_status->status }}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="answer">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Answer</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->answer)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="evidence">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Evidence</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->evidence)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="remarks">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Remarks</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->remarks)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        @if ($visa->halodoc_comment != null || $visa->vendor_feedback != null)
                                        <div class="sm:col-span-6 min-w-0 p-4 bg-white rounded-lg shadow-xs border border-gray-200 bg-opacity-70 backdrop-blur-md">
                                            @if ($visa->halodoc_comment != null)
                                                <label class="block text-sm font-medium dark:text-gray-700" for="halodoc_comment">
                                                    <span class="text-lg font-semibold dark:text-purple-700">Halodoc Comment</span>
                                                    <p class="mt-2 dark:text-gray-700">
                                                    {!! nl2br(e($visa->halodoc_comment)) !!}
                                                    </p>
                                                </label>
                                            @endif  
                                            @if ($visa->vendor_feedback != null)
                                                <label class="block mt-4 text-sm font-medium dark:text-gray-700" for="vendor_feedback">
                                                    <span class="text-lg font-semibold dark:text-purple-700">Vendor Feedback</span>
                                                    <p class="mt-2 dark:text-gray-700">
                                                    {!! nl2br(e($visa->vendor_feedback)) !!}
                                                    </p>
                                                </label>
                                            @endif                            
                                        </div>
                                        @endif
                                    @endif
                                @endif       
                            @endforeach
                            <div class="my-4"></div>
                        @endforeach
                        @if(!empty($deleteLabelAssessment))
                            <div class="sm:col-span-6 p-3 text-white bg-purple-600 rounded-lg">
                                <label class="block text-sm">
                                    <h2 class="text-xl font-semibold">Deleted Label & Assessment</h2>
                                </label>
                            </div>
                            @php
                                $num = 1;
                            @endphp
                            @foreach ($user_visa as $visa)
                                    @if (isset($deleteLabelAssessment[$visa->id]))
                                        @if (isset($visa->assessment))
                                            <div class="sm:col-span-6 mt-6"> 
                                                <label class="block text-sm" for="question">
                                                    <span class="text-xl font-semibold text-gray-700 dark:text-white">Question {{ $num++}}</span>
                                                    <p class="text-gray-700 mt-4 dark:text-gray-400">{!! nl2br(e($visa->assessment->question)) !!}</p>
                                                </label>
                                            </div>
                                            <div class="sm:col-span-3 border border-purple-500 p-3">
                                                <label class="block text-sm" for="halodoc_expectation">
                                                    <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Halodoc Expectation</span>
                                                    <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($visa->assessment->halodoc_expectation)) !!}</p>
                                                </label>
                                            </div>
                                            <div class="sm:col-span-3 border border-purple-500 p-3">
                                                <label class="block text-sm" for="expected_evidence">
                                                    <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Expected Evidence</span>
                                                    <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($visa->assessment->expected_evidence)) !!}</p>
                                                </label>
                                            </div>
                                        @else
                                            <div class="sm:col-span-6 mt-6">
                                                <label class="block text-sm" for="question">
                                                    <span class="text-xl font-semibold text-gray-700 dark:text-white">Question {{ $num++}}</span>
                                                    <p class="text-gray-700 mt-4 dark:text-gray-400">[Assessment has been deleted]</p>
                                                </label>
                                            </div>
                                        @endif                                        
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="implementation_status_id">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Implementation Status</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {{ $visa->implementation_status->status }}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="answer">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Answer</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->answer)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="evidence">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Evidence</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->evidence)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm" for="remarks">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Remarks</span>
                                                <p class="text-gray-700 mt-2 dark:text-gray-400">
                                                {!! nl2br(e($visa->remarks)) !!}
                                                </p>
                                            </label>
                                        </div>
                                        @if ($visa->halodoc_comment != null || $visa->vendor_feedback != null)
                                        <div class="sm:col-span-6 min-w-0 p-4 bg-white rounded-lg shadow-xs border border-gray-200 bg-opacity-70 backdrop-blur-md">
                                            @if ($visa->halodoc_comment != null)
                                                <label class="block text-sm font-medium dark:text-gray-700" for="halodoc_comment">
                                                    <span class="text-lg font-semibold dark:text-purple-700">Halodoc Comment</span>
                                                    <p class="mt-2 dark:text-gray-700">
                                                    {!! nl2br(e($visa->halodoc_comment)) !!}
                                                    </p>
                                                </label>
                                            @endif  
                                            @if ($visa->vendor_feedback != null)
                                                <label class="block mt-4 text-sm font-medium dark:text-gray-700" for="vendor_feedback">
                                                    <span class="text-lg font-semibold dark:text-purple-700">Vendor Feedback</span>
                                                    <p class="mt-2 dark:text-gray-700">
                                                    {!! nl2br(e($visa->vendor_feedback)) !!}
                                                    </p>
                                                </label>
                                            @endif                            
                                        </div>
                                        @endif
                                    @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @can('admin')
                @if ($result->result_status_id == 4)
                <form x-ref="form" x-bind:action="`{{ route('admin_result_comment_enough', '') }}/${dataId}`" method="POST">
                    @csrf
                    <div class="my-6">
                        <button
                            @click.prevent="openModal({{ $result->user_id }}, '{{ $result->username  }}')"
                            type="submit"
                            class="flex items-center justify-center px-4 py-2 ext-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        >
                            End Session
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
                                Finish Confirmation
                                </h2>
                                <!-- Modal description -->
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                Are you sure you want to finished this assesment?
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
                @endif
            @endcan
            @endif
        </div>
    </main>
@endsection