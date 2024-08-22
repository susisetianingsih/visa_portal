<div class="w-full overflow-x-auto">
                <table id="table1" class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">No</th>
                      <th class="px-4 py-3">Vendor</th>
                      <th class="px-4 py-3">Overview</th>
                      <th class="px-4 py-3">VISA</th>
                      <th class="px-4 py-3">Status</th>
                      <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                    @foreach ( $results as $data )
                    @php
                    if (Auth::user()->role_id == 1) {
                        $view = route('admin_result_view', $data['user_id']);
                    } else {
                        $view = route('guest_result_view', $data['user_id']);
                    }
                    @endphp
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">{{ $loop->index + $results->firstItem() }}</td>
                      <td class="px-4 py-3 text-sm">{{ $data->user ? $data->user['username'] : '[User was deleted]' }}</td>
                      <td class="px-4 py-3 text-sm">
                        @if ($data['overview'] == 1) 
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-600 bg-green-100 rounded-full dark:text-white dark:bg-green-600"
                        >
                          Completed
                        </span>
                        @else 
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-red-600 bg-red-100 rounded-full dark:text-white dark:bg-red-600"
                        >
                          Not Completed
                        </span>
                        @endif
                      </td>
                      <td class="px-4 py-3 text-sm">
                        @if ($data['visa'] == 1) 
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-600 bg-green-100 rounded-full dark:text-white dark:bg-green-600"
                        >
                          Completed
                        </span>
                        @else 
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-red-600 bg-red-100 rounded-full dark:text-white dark:bg-red-600"
                        >
                          Not Completed
                        </span>
                        @endif
                      </td>
                      <td class="px-4 py-3 text-sm">
                        @foreach ($results_status as $status)
                          @if ($data->result_status_id == $status->id) 
                          <span
                            class="px-2 py-1 font-semibold leading-tight text-{{ $status->color }} bg-red-100 rounded-full dark:text-white dark:bg-{{ $status->color }}"
                          >
                            {{ $status->result_status }}
                          </span>
                          @endif
                        @endforeach
                      </td>
                      <td>
                        <div class="flex items-center justify-center space-x-4 text-sm">
                          <form action="{{ $view }}" method="POST">
                            @method('get')
                            @csrf
                            <button
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Edit"
                            >
                              <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 576 512">
                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                              </svg>
                            </button>
                          </form>
                          @can('admin')                            
                            @if ($data->result_status_id == 2)
                              <form action="{{ route('admin_result_comment', $data['user_id']) }}" method="POST">
                                @method('get')
                                @csrf
                                <button
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                  aria-label="Edit"
                                >
                                  <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 576 512">
                                    <path d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/>
                                  </svg>
                                </button>
                              </form>
                            @endif
                            @if (($data->result_status_id == 3) || ($data->result_status_id == 5))
                              @php
                              if ($data->result_status_id == 3) {
                                  $email = route('admin_email', $data['user_id']);
                              } else {
                                  $email = route('admin_email_finish', $data['user_id']);
                              }
                              @endphp
                              <form action="{{ $email }}" method="POST">
                                @method('get')
                                @csrf
                                <button
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                  aria-label="Edit"
                                >
                                  <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 576 512">                               
                                    <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                                  </svg>
                                </button>
                              </form>                            
                            @endif
                            <button
                              @click="openModal({{ $data['user_id'] }}, '{{ $data->user['username'] }}')"
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Delete"
                            >
                              <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                  clip-rule="evenodd"
                                ></path>
                              </svg>
                            </button>
                          @endcan
                          
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- Pagination -->
              {{ $results->links('pagination::tailwind') }}