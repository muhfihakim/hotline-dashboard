<x-layouts.app>
    @section('Css')
    @endsection
    <!--begin::App Main-->

    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard Hotline</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Hotline</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-exclamation-square"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Aduan Layanan</span>
                                <span class="info-box-number">{{ $totalAduanLayanan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm">
                                <i class="bi bi-person-video3"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Virtual Meeting</span>
                                <span class="info-box-number">{{ $totalVirtualMeeting }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm">
                                <i class="bi bi-hdd-stack"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Virtual Private Server</span>
                                <span class="info-box-number">{{ $totalVps }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning shadow-sm">
                                <i class="bi bi-router"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bandwidth On Demand</span>
                                <span class="info-box-number">{{ $totalBandwidthOnDemand }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning shadow-sm">
                                <i class="bi bi-ethernet"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Infrastruktur Baru</span>
                                <span class="info-box-number">{{ $totalInfrastrukturBaru }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm">
                                <i class="bi bi-envelope-at"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Reset Email</span>
                                <span class="info-box-number">{{ $totalResetEmail }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pen-Testing</span>
                                <span class="info-box-number">{{ $totalPentest }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-file-earmark-check"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tanda Tangan Elektronik</span>
                                <span class="info-box-number">{{ $totalTte }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!--begin::Latest Order Widget-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aduan dan Permohonan Layanan Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tiket</th>
                                        <th>Kategori</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestData as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data['tiket'] }}</td>
                                            <td>{{ $data['kategori'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data['waktu'])->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </main>
    <!--end::App Main-->
</x-layouts.app>
