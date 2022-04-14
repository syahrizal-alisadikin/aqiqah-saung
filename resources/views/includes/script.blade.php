
  <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
   
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.5') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script
type="text/javascript"
src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
></script>
<script
type="text/javascript"
src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
></script>

  <script>
    //flash message
    @if (session()->has('success'))
      swal({
      type: "success",
      icon: "success",
      title: "BERHASIL!",
      text: "{{ session('success') }}",
      timer: 5000,
      showConfirmButton: false,
      showCancelButton: false,
      buttons: false,
      });
  @elseif(session()->has('error'))
      swal({
      type: "error",
      icon: "error",
      title: "GAGAL!",
      text: "{{ session('error') }}",
      timer: 5000,
      showConfirmButton: false,
      showCancelButton: false,
      buttons: false,
      });
      @elseif(session()->has('info'))
      swal({
      type: "info",
      icon: "info",
      title: "INFO!",
      text: "{{ session('info') }}",
      timer: 5000,
      showConfirmButton: false,
      showCancelButton: false,
      buttons: false,
      });
  @endif
</script>