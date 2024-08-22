@extends('layouts.app')
@section('title', 'Form')
@section('content')
    <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            @php
                if (Auth::user()->role_id == 1) {
                  $overview = route('admin_form_overview');
                  $visa = route('admin_form_visa');
                  $visa_feedback = route('admin_form_visa_feedback');
                } elseif (Auth::user()->role_id == 2) {
                  $overview = route('vendor_form_overview');
                  $visa = route('vendor_form_visa');
                  $visa_feedback = route('vendor_form_visa_feedback');
                }
            @endphp

            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Form
            </h2>
            <div class="grid gap-6 mb-8 md:grid-cols-2">
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Overview Form
                </h4>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                  Contains questions related to vendor identity.
                </p>
                @if ($user_overview)
                <span class="px-2 py-1 font-semibold leading-tight text-teal-700 bg-teal-100 rounded-full dark:text-white dark:bg-teal-600">
                  Finished Work!
                </span>
                @else
                <a href="{{ $overview }}" class="block">
                  <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  >
                    Start &RightArrow;
                  </button>
                </a>
                @endif
                
              </div>
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  VISA Form
                </h4>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                  Contains questions related to vendor's information security.
                </p>
                @if ($user_visa_feedback)
                <span class="px-2 py-1 font-semibold leading-tight text-teal-700 bg-teal-100 rounded-full dark:text-white dark:bg-teal-600">
                  Finished Work & Feedback Sent!
                </span>
                @elseif ($user_visa_comment)
                <a href="{{ $visa_feedback }}" class="block">
                  <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                  >
                    See the comment &RightArrow;
                  </button>
                </a>
                @elseif ($user_visa)
                <span class="px-2 py-1 font-semibold leading-tight text-teal-700 bg-teal-100 rounded-full dark:text-white dark:bg-teal-600">
                  Finished Work!
                </span>
                @else
                <a href="{{ $visa }}" class="block">
                  <button
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  >
                    Start &RightArrow;
                  </button>
                </a>
                @endif
              </div>
            </div>
            
            @if ($user_overview && $user_visa)
              <div
                class="min-w-0 p-4 mb-8 text-white bg-purple-600 rounded-lg shadow-xs"
              >
                <h3 class="text-lg mb-2 font-semibold uppercase" >
                    Attention!
                </h3>
                <h5 class="mb-1">
                    Please, check your email periodically to see if there is any comments or completion. Thank you!
                </h5>
              </div>              
            @endif
          </div>

        </main>
@endsection