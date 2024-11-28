@extends('./layouts/sidebar_login')

@section('scripts')
    @parent
    <script>
        @if (session('gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Login',
                text: 'Email atau password salah, coba lagi ya',
                confirmButtonText: 'Ok',
            });
        @endif
    </script>
@endsection
@section('container')
    <div class="row justify-content-sm-center h-100 align-items-center">
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <h1 class="fs-4 text-center fw-bold mb-4">Login</h1>
                    <h1 class="fs-6 mb-3">Please enter your email and password to log in.</h1>
                    <form method="POST" aria-label="abdul" data-id="abdul" action="/" class="needs-validation"
                        novalidate="">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="email">Email</label>
                            <div class="input-group input-group-join mb-3">
                                <input id="email" type="email" placeholder="Enter email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    name="email" required autofocus>
                                <span class="input-group-text rounded-end">&nbsp<i class="fa fa-user"></i>&nbsp</span>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-join mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Your password" value="{{ old('password') }}" required>
                                <span class="input-group-text rounded-end password cursor-pointer">&nbsp<i
                                        class="fa fa-eye"></i>&nbsp</span>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="card-footer py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" required>
                            <label for="remember" class="form-check-label">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary ms-auto">
                            Login
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/pages/datatables.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
