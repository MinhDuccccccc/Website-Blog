@extends('web.layout.master')

@section('content')
<section class="section wb mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-wrapper">
                    <div class="row">
                        {{-- Thông báo lỗi / thành công --}}
                        @if(session('error'))
                            <div class="col-lg-12">
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="col-lg-12">
                                <div class="alert alert-success">{{ session('success') }}</div>
                            </div>
                        @endif

                        <div class="col-lg-12">
                            <form class="form-wrapper" action="{{ route('web.auth.login') }}" method="post">
                                @csrf
                                <input type="email" name="email" class="form-control" placeholder="Email address" required>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <button type="submit" class="btn btn-primary">Login</button>

                                {{-- Liên kết sang trang đăng ký (đặt cùng vị trí với trang register) --}}
                                <p class="mt-3">
                                    Don't have an account?
                                    <a href="{{ route('web.auth.register.form') }}">Register here</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div><!-- end page-wrapper -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
@endsection
