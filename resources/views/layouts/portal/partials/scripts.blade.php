<!-- JAVASCRIPT FILES -->
<script src="{{ asset('portal/js/jquery.min.js') }}"></script>
<script src="{{ asset('portal/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('portal/js/jquery.sticky.js') }}"></script>
<script src="{{ asset('portal/js/click-scroll.js') }}"></script>
<script src="{{ asset('portal/js/counter.js') }}"></script>
<script src="{{ asset('portal/js/custom.js') }}"></script>
<script>
    @if (session()->has('success'))
        alert('{{ session('success') }}');
    @endif

    @if (session()->has('error'))
        alert('{{ session('error') }}');
    @endif
</script>
