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
                <div class="row">
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
                </div>
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
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                        </td>
                                        <td>Call of Duty IV</td>
                                        <td><span class="badge text-bg-success"> Shipped </span></td>
                                        <td>
                                            <div id="table-sparkline-1"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                        </td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="badge text-bg-warning">Pending</span></td>
                                        <td>
                                            <div id="table-sparkline-2"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                        </td>
                                        <td>iPhone 6 Plus</td>
                                        <td><span class="badge text-bg-danger"> Delivered </span></td>
                                        <td>
                                            <div id="table-sparkline-3"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                        </td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="badge text-bg-info">Processing</span></td>
                                        <td>
                                            <div id="table-sparkline-4"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                        </td>
                                        <td>Samsung Smart TV</td>
                                        <td><span class="badge text-bg-warning">Pending</span></td>
                                        <td>
                                            <div id="table-sparkline-5"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                        </td>
                                        <td>iPhone 6 Plus</td>
                                        <td><span class="badge text-bg-danger"> Delivered </span></td>
                                        <td>
                                            <div id="table-sparkline-6"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="pages/examples/invoice.html"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                        </td>
                                        <td>Call of Duty IV</td>
                                        <td><span class="badge text-bg-success">Shipped</span></td>
                                        <td>
                                            <div id="table-sparkline-7"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                            Place New Order
                        </a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                            View All Orders
                        </a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
    @section('Scripts')
        <!-- apexcharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
            integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
        <script>
            // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
            // IT'S ALL JUST JUNK FOR DEMO
            // ++++++++++++++++++++++++++++++++++++++++++

            /* apexcharts
             * -------
             * Here we will create a few charts using apexcharts
             */

            //-----------------------
            // - MONTHLY SALES CHART -
            //-----------------------

            const sales_chart_options = {
                series: [{
                        name: 'Digital Goods',
                        data: [28, 48, 40, 19, 86, 27, 90],
                    },
                    {
                        name: 'Electronics',
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                ],
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                legend: {
                    show: false,
                },
                colors: ['#0d6efd', '#20c997'],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    type: 'datetime',
                    categories: [
                        '2023-01-01',
                        '2023-02-01',
                        '2023-03-01',
                        '2023-04-01',
                        '2023-05-01',
                        '2023-06-01',
                        '2023-07-01',
                    ],
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy',
                    },
                },
            };

            const sales_chart = new ApexCharts(
                document.querySelector('#sales-chart'),
                sales_chart_options,
            );
            sales_chart.render();

            //---------------------------
            // - END MONTHLY SALES CHART -
            //---------------------------

            function createSparklineChart(selector, data) {
                const options = {
                    series: [{
                        data
                    }],
                    chart: {
                        type: 'line',
                        width: 150,
                        height: 30,
                        sparkline: {
                            enabled: true,
                        },
                    },
                    colors: ['var(--bs-primary)'],
                    stroke: {
                        width: 2,
                    },
                    tooltip: {
                        fixed: {
                            enabled: false,
                        },
                        x: {
                            show: false,
                        },
                        y: {
                            title: {
                                formatter: function(seriesName) {
                                    return '';
                                },
                            },
                        },
                        marker: {
                            show: false,
                        },
                    },
                };

                const chart = new ApexCharts(document.querySelector(selector), options);
                chart.render();
            }

            const table_sparkline_1_data = [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54];
            const table_sparkline_2_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 44];
            const table_sparkline_3_data = [15, 46, 21, 59, 33, 15, 34, 42, 56, 19, 64];
            const table_sparkline_4_data = [30, 56, 31, 69, 43, 35, 24, 32, 46, 29, 64];
            const table_sparkline_5_data = [20, 76, 51, 79, 53, 35, 54, 22, 36, 49, 64];
            const table_sparkline_6_data = [5, 36, 11, 69, 23, 15, 14, 42, 26, 19, 44];
            const table_sparkline_7_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 74];

            createSparklineChart('#table-sparkline-1', table_sparkline_1_data);
            createSparklineChart('#table-sparkline-2', table_sparkline_2_data);
            createSparklineChart('#table-sparkline-3', table_sparkline_3_data);
            createSparklineChart('#table-sparkline-4', table_sparkline_4_data);
            createSparklineChart('#table-sparkline-5', table_sparkline_5_data);
            createSparklineChart('#table-sparkline-6', table_sparkline_6_data);
            createSparklineChart('#table-sparkline-7', table_sparkline_7_data);

            //-------------
            // - PIE CHART -
            //-------------

            const pie_chart_options = {
                series: [700, 500, 400, 600, 300, 100],
                chart: {
                    type: 'donut',
                },
                labels: ['Chrome', 'Edge', 'FireFox', 'Safari', 'Opera', 'IE'],
                dataLabels: {
                    enabled: false,
                },
                colors: ['#0d6efd', '#20c997', '#ffc107', '#d63384', '#6f42c1', '#adb5bd'],
            };

            const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
            pie_chart.render();

            //-----------------
            // - END PIE CHART -
            //-----------------
        </script>
    @endsection
</x-layouts.app>
