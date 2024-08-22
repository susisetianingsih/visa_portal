@extends('layouts.app')
@section('title', 'Visa Form')
@section('content')
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid grid-cols-1 md:grid-cols-4 gap-4" x-data="{ currentQuestion: 0, totalQuestions: {{ $assessments->count() }}, currentLabelId: {{ $assessments->first()->label_id }},assessments: {{ $assessments->map(function ($assessment) { return ['label_id' => $assessment->label_id]; }) }}
}" x-init="$watch('currentQuestion', value => currentLabelId = assessments[value].label_id)">
    <!-- Main Content -->
    <div class="col-span-1 md:col-span-3">
      @php
      if (Auth::user()->role_id == 1) {
          $visa = route('admin_form_visa_post');
      } elseif (Auth::user()->role_id == 2) {
          $visa = route('vendor_form_visa_post');
      }
      @endphp
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">VISA Form</h2>
      <form x-ref="form" method="POST" action="{{ $visa }}">
        @csrf
          @foreach ($labels as $label)
            @foreach ($assessments->where('label_id', $label->id) as $index => $assessment)
            <div x-show="currentQuestion === {{ $index }}" id="question-{{ $assessment->id }}">
              <div id="label-{{ $label->id }}" class="min-w-0 p-4 my-6 text-white bg-purple-600 rounded-lg shadow-xs">
                <h2 class="text-2xl font-semibold uppercase">{{ $assessment->label['label'] }}</h2>
              </div>
              <div class="flex-1 w-full mx-auto bg-white rounded-lg shadow-xl dark:bg-gray-800">
                  <div class="flex flex-col">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                      <input type="hidden" name="assessment_id[]" value="{{ $assessment->id }}">
                      <div class="sm:col-span-6">
                        <label class="block text-sm" for="question">
                          <span class="text-xl font-semibold text-gray-700 dark:text-white">Question {{ $loop->iteration }}</span>
                          <p class="text-gray-700 mt-4 dark:text-gray-400">{!! nl2br(e($assessment->question)) !!}</p>
                        </label>
                      </div>
                      <div class="sm:col-span-3 border border-purple-500 p-3">
                        <label class="block text-sm" for="halodoc_expectation">
                          <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Halodoc Expectation</span>
                          <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($assessment->halodoc_expectation)) !!}</p>
                        </label>
                      </div>
                      <div class="sm:col-span-3 border border-purple-500 p-3">
                        <label class="block text-sm" for="expected_evidence">
                          <span class="text-lg font-semibold text-gray-700 dark:text-gray-400">Expected Evidence</span>
                          <p class="text-gray-700 mt-2 dark:text-gray-400">{!! nl2br(e($assessment->expected_evidence)) !!}</p>
                        </label>
                      </div>
                      <div class="sm:col-span-6">
                        <label class="block text-sm" for="implementation_status_id">
                          <span class="text-gray-700 dark:text-gray-400">Implementation Status</span>
                          <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            name="implementation_status_id[]" id="implementation_status_id">
                              <option value="" selected disabled>Select status</option>
                              @foreach ($implementation_status as $data)
                              <option value="{{ $data['id'] }}" {{ old('implementation_status_id.' . $index) == $data['id'] ? 'selected' : '' }}>{{ $data['status'] }}</option>
                              @endforeach
                          </select>
                          <x-input-error :messages="$errors->get('implementation_status_id' . $index)" class="mt-2" />
                        </label>
                      </div>
                      <div class="sm:col-span-6">
                        <label class="block text-sm" for="answer">
                          <span class="text-gray-700 dark:text-gray-400">Answer</span>
                          <textarea name="answer[]" id="answer"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            rows="3" placeholder="Enter some long form content.">{{ old('answer.' . $index) }}</textarea>
                          <x-input-error :messages="$errors->get('answer.' . $index)" class="mt-2" />
                        </label>
                      </div>
                      <div class="sm:col-span-6">
                        <label class="block text-sm" for="evidence">
                          <span class="text-gray-700 dark:text-gray-400">Evidence</span>
                          <textarea name="evidence[]" id="evidence"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            rows="3" placeholder="Enter some long form content.">{{ old('evidence.' . $index) }}</textarea>
                          <x-input-error :messages="$errors->get('evidence.' . $index)" class="mt-2" />
                        </label>
                      </div>
                      <div class="sm:col-span-6">
                        <label class="block text-sm" for="remarks">
                          <span class="text-gray-700 dark:text-gray-400">Remarks</span>
                          <textarea name="remarks[]" id="remarks"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            rows="3" placeholder="Enter some long form content.">{{ old('remarks.' . $index) }}</textarea>
                          <x-input-error :messages="$errors->get('remarks.' . $index)" class="mt-2" />
                        </label>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            @endforeach
          @endforeach
          <div class="flex justify-between my-6">
            <button type="button" x-show="currentQuestion > 0" @click="currentQuestion--" class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700">
              Previous
            </button>
            <button type="button" x-show="currentQuestion < totalQuestions - 1" @click="currentQuestion++" class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700">
              Next
            </button>
            <button type="submit" @click.prevent="openModal({{ Auth::user()->id }}, '{{ Auth::user()->username  }}')" x-show="currentQuestion === totalQuestions - 1" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
              Submit
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
                                VISA Submission
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
    <!-- Static Card -->
    <div class="md:block hidden col-span-1">
      <div class="min-w-0 p-6 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-lg text-gray-800 dark:text-gray-300">Total {{ $assessments->count() }} Questions</h4>
        <ul>
          @foreach ($labels as $label)
            <li class="mb-4" :class="{ 'bg-purple-600 dark:text-white p-2 rounded-lg shadow-xs': currentLabelId === {{ $label->id }} }">
              <h5 class="font-medium text-gray-600 dark:text-gray-400" :class="{ 'dark:text-white': currentLabelId === {{ $label->id }} }">{{ $label->label }}</h5>
              <p class="text-sm text-gray-600 dark:text-gray-400" :class="{ 'dark:text-white': currentLabelId === {{ $label->id }} }">Total Questions: {{ $assessments->where('label_id', $label->id)->count() }}</p>
            </li>
          @endforeach
        </ul>
      </div>
      <div x-show="currentQuestion === totalQuestions - 1" class="min-w-0 p-4 my-4 text-white bg-purple-600 rounded-lg shadow-xs">
        <h2 class="text-xl text-center font-semibold uppercase">Attention!</h2>
        <p class="text-sm text-center mt-2">
          Please, make sure your answer is not empty! If any of them are still empty, the assessment will not be sent.
        </p>
      </div>
    </div>
    </div>
  </div>
</main>
@endsection
