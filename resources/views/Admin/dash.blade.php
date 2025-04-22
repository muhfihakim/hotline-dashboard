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
                <!--begin::Row-->
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Aduan dan Permohonan Bulan Ini</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" role="menu">
                                            <a href="#" class="dropdown-item">Action</a>
                                            <a href="#" class="dropdown-item">Another action</a>
                                            <a href="#" class="dropdown-item"> Something else here </a>
                                            <a class="dropdown-divider"></a>
                                            <a href="#" class="dropdown-item">Separated link</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                                        </p>
                                        <div id="sales-chart"></div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <p class="text-center"><strong>Goal Completion</strong></p>
                                        <div class="progress-group">
                                            Aduan Layanan
                                            <span class="float-end"><b>160</b>/200</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            Virtual Meeting
                                            <span class="float-end"><b>310</b>/400</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            <span class="progress-text">Virtual Private Server</span>
                                            <span class="float-end"><b>480</b>/800</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            Bandwidth On Demand
                                            <span class="float-end"><b>250</b>/500</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Infrastruktur Baru
                                            <span class="float-end"><b>250</b>/500</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div> --}}
                <!--end::Row-->
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

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                            Place New Order
                        </a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                            View All Orders
                        </a>
                    </div> --}}
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
