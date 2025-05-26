<x-pimpinan.app>
    @section('Css')
        <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/buttons.bootstrap4.min.css') }}">
    @endsection

    <main class="app-main">
        <div class="app-content container-fluid">
            {{-- 1. Aduan Layanan --}}
            @include('Pimpinan.partials._table_aduan', ['data' => $aduanLayanan])

            {{-- 2. Virtual Meeting --}}
            @include('Pimpinan.partials._table_vm', ['data' => $virtualMeeting])

            {{-- 3. VPS --}}
            @include('Pimpinan.partials._table_vps', ['data' => $vps])

            {{-- 4. Bandwidth On Demand --}}
            @include('Pimpinan.partials._table_bod', ['data' => $bod])

            {{-- 5. Infrastruktur --}}
            @include('Pimpinan.partials._table_infrastruktur', ['data' => $infrastruktur])

            {{-- 6. Reset Email --}}
            @include('Pimpinan.partials._table_reset_email', ['data' => $resetEmail])

            {{-- 7. Pentest --}}
            @include('Pimpinan.partials._table_pentest', ['data' => $pentest])

            {{-- 8. TTE --}}
            @include('Pimpinan.partials._table_tte', ['data' => $tte])
        </div>
    </main>

    @section('Scripts')
        <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('dist/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.colVis.min.js') }}"></script>

        <script>
            $(function() {
                $('table.data-table').each(function() {
                    $(this).DataTable({
                        responsive: true,
                        lengthChange: false,
                        autoWidth: false,
                        pageLength: 5
                    }).buttons().container().appendTo($(this).closest('.card').find('.card-header'));
                });
            });
        </script>

        <script>
            // Saat modal surat dibuka, baru load iframe
            $('div.modal').on('show.bs.modal', function(e) {
                let iframe = $(this).find('iframe.surat-frame');
                let dataSrc = iframe.attr('data-src');
                if (iframe.attr('src') !== dataSrc) {
                    iframe.attr('src', dataSrc);
                }
            });

            // Opsional: Kosongkan src saat modal ditutup untuk menghemat memori
            $('div.modal').on('hidden.bs.modal', function(e) {
                let iframe = $(this).find('iframe.surat-frame');
                iframe.removeAttr('src');
            });
        </script>
    @endsection
</x-pimpinan.app>
