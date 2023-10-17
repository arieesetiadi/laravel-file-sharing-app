@stack('before-scripts')

{{-- Local --}}
<script type="application/javascript" src="{{ asset('assets/cms/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/plugins/datatables/datatables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/js/pages/datatables.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/plugins/pace/pace.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/js/main.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('assets/cms/js/custom.js') }}"></script>

{{-- Sweet Alert 2 --}}
<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- JS Validation --}}
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>

@stack('after-scripts')
