<div class="w-full overflow-x-auto">
                
                <table id="table1" class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Question</th>
                            <th class="px-4 py-3">Halodoc Expectation</th>
                            <th class="px-4 py-3">Expected Evidence</th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3">Visibility</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ( $assessments as $data )
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm whitespace-normal">{{ $loop->index + $assessments->firstItem() }}</td>
                            <td class="px-4 py-3 text-sm whitespace-normal">{!! nl2br(e($data['question'])) !!}</td>
                            <td class="px-4 py-3 text-sm whitespace-normal">{!! nl2br(e($data['halodoc_expectation'])) !!}</td>
                            <td class="px-4 py-3 text-sm whitespace-normal">{!! nl2br(e($data['expected_evidence'])) !!}</td>
                            <td class="px-4 py-3 text-sm whitespace-normal">{!! nl2br(e($data->label ? $data->label['label'] : '[Label was deleted]')) !!}</td>
                            <td class="px-4 py-3 text-sm whitespace-normal">
                              @if ($data['visibility'] == 1)
                                <svg
                                  class="w-5 h-5 text-green-600"
                                  aria-hidden="true"
                                  fill="currentColor"
                                  xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 576 512">
                                  <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                </svg>
                              @else
                                <svg
                                  class="w-5 h-5 text-red-600"
                                  aria-hidden="true"
                                  fill="currentColor"
                                  xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 576 512">
                                  <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/>
                                </svg>
                              @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-4 text-sm">
                                    <form action="{{ route('assessment_update', $data['id']) }}" method="POST">
                                        @method('get')
                                        @csrf
                                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                        <button @click="openModal({{ $data['id'] }}, '{{ $data['question'] }}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>

              <!-- Pagination -->
              {{ $assessments->links('pagination::tailwind') }}