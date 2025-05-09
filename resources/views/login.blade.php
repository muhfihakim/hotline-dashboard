<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Layanan Hotline Diskominfo | Login</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Layanan Hotline Diskominfo Subang" />
    <meta name="author" content="Bidang TIK dan Persandian" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--end::Primary Meta Tags-->

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-5/assets/css/login-5.css">
    <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="login-page bg-body-secondary">
    <!-- Login 5 - Bootstrap Brain Component -->
    <section class="min-vh-100 d-flex justify-content-center align-items-center p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="card border-light-subtle shadow-sm">
                <div class="row g-0">
                    <div class="col-12 col-md-6 text-bg-primary">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="col-10 col-xl-8 py-3">
                                <h2 class="h1 mb-4">Dashboard Layanan Hotline Dinas Kominfo Kab. Subang</h2>
                                <p class="lead m-0">Dikelola Oleh Bidang TIK dan Persandian.</p>
                                <p>Dibuat Oleh Tim Pusat Data.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h3>Masuk Dashboard</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <div class="row gy-3 gy-md-4 overflow-hidden">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Alamat Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Masukkan Email"
                                            aria-label="Email" value="{{ old('email') }}" id="email" name="email"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" placeholder="Masukkan Password"
                                            aria-label="Password" id="password" name="password" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="remember_me" id="remember_me">
                                            <label class="form-check-label text-secondary" for="remember_me">
                                                Biarkan saya tetap masuk
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-primary" type="submit">Masuk!</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mt-5 mb-4">Infrastruktur Teknologi | Pusat Kendali | Keamanan Informasi |
                                        Persandian</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SweetAlert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tampilkan notifikasi jika ada session flash -->
    @if (session('alert.config'))
        <script>
            Swal.fire({!! session('alert.config') !!});
        </script>
    @endif
</body>
<!--end::Body-->

</html>
