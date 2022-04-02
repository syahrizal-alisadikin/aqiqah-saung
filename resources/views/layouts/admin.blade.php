<!--
=========================================================
* Soft UI Dashboard - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
@stack('prepend-style')
@include('includes.style')
@stack('addon-style')
<body class="g-sidenav-show  bg-gray-100">
  {{-- Includes Sidebar --}}
    @include('includes.sidebar')
    {{-- End Sidebar --}}
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('includes.navbar')
    <!-- End Navbar -->
    <div class="container-fluid py-4">

        @yield('content')
        {{-- @include('includes.footer') --}}
    </div>
  </main>
  @stack('prepend-script')
 @include('includes.script')
  @stack('addon-script')
</body>

</html>