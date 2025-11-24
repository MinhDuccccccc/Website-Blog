@extends('web.layout.master')

@section('content')
<section class="section wb mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                {{-- Alerts --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="page-wrapper p-4 shadow-lg bg-white rounded-3" style="border: 1px solid #eee;">
                    <h3 class="mb-4 text-center" style="font-weight: 600;">Login</h3>

                    <form action="{{ route('web.auth.login') }}" method="post">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-bold">Email</label>
                            <input type="email" name="email"
                                class="form-control form-control-lg custom-input @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-bold">Password</label>
                            <input type="password" name="password"
                                class="form-control form-control-lg custom-input @error('password') is-invalid @enderror"
                                placeholder="Enter password">
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 btn-lg mt-2" type="submit">
                            Login
                        </button>

                        {{-- Register link --}}
                        <p class="mt-4 text-center">
                            Don't have an account?
                            <a href="{{ route('web.auth.register.form') }}" class="text-primary fw-bold">
                                Register here
                            </a>
                        </p>

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Custom CSS cho input --}}
<style>
    .custom-input {
        font-size: 16px !important;
        padding: 12px 14px !important;
        border-radius: 8px !important;
    }
</style>
@endsection
