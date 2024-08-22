@extends('layouts.app')
@section('title', 'Update Assessment')
@section('content')
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            Update Assessment
          </h2>
  
          <div class="flex-1 h-full w-full mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto">
                <form method="POST" action="{{ route('assessment_update_post', $assessment['id']) }}">
                    @method('put')
                    @csrf
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:p-12 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="no_urut">
                                <span class="text-gray-700 dark:text-gray-400">Soal ke</span>
                                <input
                                    id="no_urut" 
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-500 dark:focus:shadow-outline-gray form-input"
                                    placeholder="No. urut setiap label"
                                    type="number"
                                    name="no_urut"
                                    value="{{ $count }}"
                                    required autofocus autocomplete="no_urut"
                                    disabled
                                />
                                <x-input-error :messages="$errors->get('no_urut')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                           <label class="block text-sm" for="label_id">
                               <span class="text-gray-700 dark:text-gray-400">
                                   Label
                               </span>
                               <select
                                   class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                   name="label_id"
                                   id="label_id"
                               >
                                   <option value="" selected disabled>Select label</option>
                                   @foreach ($labels as $label)
                                    @if (old('label_id', $assessment['label_id']) == $label['id'])
                                    <option value="{{ $label['id'] }}" selected>{{ $label['label'] }}</option>
                                    @else
                                    <option value="{{ $label['id'] }}">{{ $label['label'] }}</option>
                                    @endif
                                   @endforeach
                               </select>
                               <x-input-error :messages="$errors->get('label_id')" class="mt-2" />
                           </label>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="block text-sm" for="question">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Question
                                </span>
                                <textarea
                                    name="question"
                                    id="question"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    rows="3"
                                    placeholder="Enter some long form content."
                                >{{ old('question', $assessment['question']) }}</textarea>
                                <x-input-error :messages="$errors->get('question')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="halodoc_expectation">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Halodoc Expectation
                                </span>
                                <textarea
                                    name="halodoc_expectation"
                                    id="halodoc_expectation"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    rows="3"
                                    placeholder="Enter some long form content."
                                >{{ old('halodoc_expectation', $assessment['halodoc_expectation']) }}</textarea>
                                <x-input-error :messages="$errors->get('halodoc_expectation')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm" for="expected_evidence">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Expected Evidence
                                </span>
                                <textarea
                                    name="expected_evidence"
                                    id="expected_evidence"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    rows="3"
                                    placeholder="Enter some long form content."
                                >{{ old('expected_evidence', $assessment['expected_evidence']) }}</textarea>
                                <x-input-error :messages="$errors->get('expected_evidence')" class="mt-2" />
                            </label>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="inline-flex items-center" for="visibility">
                                <input type="checkbox" name="visibility" value="1" class="form-checkbox" {{ $assessment->visibility ? 'checked' : '' }}>
                                <span class="ml-2 mt-1 text-sm text-gray-700 dark:text-gray-400">Visibility</span>
                            </label>
                        </div>
                    </div>
                    <div class="px-6 pb-6 sm:px-12 sm:pb-12">
                        {{-- Button --}}
                        <button class="btn px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Update Assessment') }}
                        </button> 
                    </div>
                </form>
            </div>
          </div>

  
        </div>
      </main>
@endsection