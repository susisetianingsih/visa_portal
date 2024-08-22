@extends('layouts.app')
@php
  if (Auth::user()->role_id == 1) {
    $title = 'Dashboard';
  } else {
    $title = 'Home';
  }
@endphp
@section('title', $title)
@section('content')
    <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid" x-data="liveSearch()">
            @can('admin')
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Dashboard
            </h2>
            @endcan

            @can('vendor-guest')
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Home
            </h2>
            @endcan

            {{-- Authenticated --}}
            <div class="min-w-0 p-4 mb-8 text-white bg-purple-600 rounded-lg shadow-xs">
              <h5 class="mb-1">
                  Halo, {{ Auth::user()->role['role'] }}!
              </h5>
              <h2 class="text-2xl font-semibold uppercase" >
                  {{ Auth::user()->username }}
              </h2>
            </div>

            @can('vendor')    
            {{-- English --}}        
            <div
                class="min-w-0 p-10 mb-8 text-gray-600 dark:text-gray-300 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
              <h3 class="mb-4 text-xl font-semibold">
                Welcome to Halodoc's VISA Portal
              </h3>
              <p class="mb-4">We are delighted to collaborate with you to ensure the highest security standards are applied across our partner network.</p>
              <p class="mb-4">The VISA (Vendor Information Security Assessment) Portal represents an evolution of Halodoc's existing assessment system, designed to provide a more comprehensive and efficient evaluation process. This assessment is a crucial step in our efforts to evaluate the Information Security and Privacy controls of our partners. By understanding and strengthening these controls, we aim to protect vital data and information essential to our operations and services. With your participation and cooperation, we are confident in creating a safer and more trustworthy environment for all parties involved.</p>
              
              <div class="mb-4">
                  <h2 class="text-lg font-semibold mb-2">Assessment Details:</h2>
                  <p><strong>Mandatory Forms:</strong> There are two mandatory forms that need to be filled out: the Overview and the VISA Form.</p>
                  <ul class="list-disc pl-4">
                      <li><strong>Overview:</strong> This form contains the partner's identity information.</li>
                      <li><strong>VISA Form:</strong> This form contains 73 evaluation questions that must be completed.</li>
                  </ul>
              </div>

              <div class="mb-4">
                  <p><strong>Instructions for Completion:</strong></p>
                  <ul class="list-disc pl-4">
                      <li>Ensure no input fields are left empty.</li>
                      <li>If the answer is not available, fill in with "-".</li>
                      <li>There is no time limit for completing the form.</li>
                      <li>There is no temporary save option.</li>
                      <li>The form can only be submitted once.</li>
                      <li>If you need to attach a file, please upload it to Google Drive first and then provide the attachment link.</li>
                  </ul>
              </div>

              <p class="mb-4">We hope this assessment process goes smoothly and brings significant benefits to both parties. If you have any questions or need assistance during the process, please do not hesitate to contact our team, who are ready to help.</p>
        
              <p class="mb-4">Thank you for your cooperation.</p>
              <p>Warm regards,</p>
              <p>ISDP Halodoc Team</p>
            </div>
            
            {{-- Indonesia --}}
            <div
                class="min-w-0 p-10 mb-8 text-gray-600 dark:text-gray-300 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
                <h3 class="mb-4 text-xl font-semibold">
                    <i>Selamat Datang di Portal VISA Halodoc</i>
                </h3>
                <p class="mb-4"><i>Kami senang dapat bekerja sama dengan Anda untuk memastikan standar keamanan tertinggi diterapkan di seluruh jaringan mitra kami.</i></p>
                <p class="mb-4"><i>Portal VISA (Vendor Information Security Assessment) ini merupakan evolusi dari sistem penilaian Halodoc yang sudah ada, dirancang untuk memberikan proses evaluasi yang lebih komprehensif dan efisien. Penilaian ini adalah langkah penting dalam upaya kami untuk mengevaluasi kontrol Keamanan Informasi dan Privasi dari mitra kami. Dengan memahami dan memperkuat kontrol ini, kami bertujuan untuk melindungi data dan informasi penting yang esensial untuk operasi dan layanan kami. Atas partisipasi dan kerjasama Anda, kami yakin dapat menciptakan lingkungan yang lebih aman dan terpercaya bagi semua pihak yang terlibat.</i></p>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2"><i>Detail Penilaian:</i></h2>
                    <p><i><strong>Formulir Wajib:</strong> Ada dua formulir wajib yang harus diisi: Overview dan Formulir VISA.</i></p>
                    <ul class="list-disc pl-4">
                        <li><i><strong>Overview:</strong> Formulir ini berisi informasi identitas mitra.</i></li>
                        <li><i><strong>Formulir VISA:</strong> Formulir ini berisi 73 pertanyaan evaluasi yang harus diselesaikan.</i></li>
                    </ul>
                </div>

                <div class="mb-4">
                    <p><i><strong>Instruksi untuk Penyelesaian:</strong></i></p>
                    <ul class="list-disc pl-4">
                        <li><i>Pastikan tidak ada kolom input yang kosong.</i></li>
                        <li><i>Jika jawabannya tidak tersedia, isi dengan "-".</i></li>
                        <li><i>Tidak ada batas waktu untuk menyelesaikan formulir.</i></li>
                        <li><i>Tidak ada opsi simpan sementara.</i></li>
                        <li><i>Formulir hanya dapat disubmisikan sekali.</i></li>
                        <li><i>Jika Anda perlu melampirkan file, silakan unggah terlebih dahulu ke Google Drive dan kemudian berikan tautan lampirannya.</i></li>
                    </ul>
                </div>

                <p class="mb-4"><i>Kami berharap proses penilaian ini berjalan lancar dan membawa manfaat yang signifikan bagi kedua belah pihak. Jika Anda memiliki pertanyaan atau membutuhkan bantuan selama proses ini, jangan ragu untuk menghubungi tim kami yang siap membantu.</i></p>

                <p class="mb-4"><i>Terima kasih atas kerjasama Anda.</i></p>
                <p><i>Salam hangat,</i></p>
                <p><i>Tim ISDP Halodoc</i></p>
            </div>
            @endcan

            @can('admin')
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total User
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                  {{ $count['number_of_user'] }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Admin
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $count['number_of_admin'] }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Vendor
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $count['number_of_vendor'] }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Guest
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $count['number_of_guest'] }}
                  </p>
                </div>
              </div>
            </div>

            {{-- Table Users --}}
            <div class="flex justify-between items-center mb-5">
                <div class="flex flex-col flex-wrap space-y-4 md:flex-row md:items-end md:space-x-4">
                  <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                    Table of Users
                  </h4>
                </div>
                <div class="flex justify-end flex-1">
                  <div class="relative w-full ml-3 md:ml-auto md:w-auto focus-within:text-purple-500">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                      <svg
                        class="w-4 h-4 text-purple-300"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </div>
                    <input x-model="search" @input="fetchData()"
                      class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-400 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                      type="text"
                      placeholder="Search for user"
                      aria-label="Search"
                    />
                  </div>
                </div>
            </div>
            <div class="w-full mb-12 overflow-hidden rounded-lg shadow-xs" id="table-data">
              @include('page.partials.table_user', ['users' => $users])
            </div>
            @endcan
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
                  aria-label="close" @click="closeModal">
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
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                  Delete User
                </p>
                <!-- Modal description -->
                <p class="text-sm text-gray-700 dark:text-gray-400">
                  Are you sure you want to delete <span class="font-bold" x-text="dataName"></span>?
                </p>
              </div>
              <form x-bind:action="`{{ route('user_delete', '') }}/${dataId}`" method="POST">
                @method('delete')
                @csrf
                <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                  <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5  text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                  </button>
                  <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Delete
                  </button>
                </footer>
              </form>
            </div>
          </div>
          <!-- End of modal backdrop -->
        </main>

        <script>
            function liveSearch() {
                return {
                    search: '{{ $search }}',
                    fetchData() {
                        fetch(`{{ route('search_user') }}?search=${this.search}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('table-data').innerHTML = data;
                        });
                    }
                }
            }
        </script>
@endsection