<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('asset\image\halodoc.png') }}" type="image/x-icon">
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('dist/assets/css/tailwind.output.css') }}" />

    {{-- Jquary --}}
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    {{-- Toast --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/3d3c70acc6.js" crossorigin="anonymous"></script>

    <!-- Run Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
    {{-- Sidebar --}}
      @include('layouts.sidebar')
      
      <div class="flex flex-col flex-1 w-full">
        
        {{-- Header --}}
        @include('layouts.header')

        {{-- Main --}}
        @yield('content')

      </div>
    </div>

    {{-- Toast --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (Session::has('message'))
      <script>
        toastr.success("{{ Session::get('message') }}");
      </script>
    @endif
    @if (Session::has('info'))
      <script>
        toastr.info("{{ Session::get('info') }}");
      </script>
    @endif
    @if (Session::has('error'))
      <script>
        toastr.error("{{ Session::get('error') }}");
      </script>
    @endif

  </body>
</html>

{{-- Alphine.js --}}
<script src="{{ asset('dist/assets/js/init-alpine.js') }}"></script>
