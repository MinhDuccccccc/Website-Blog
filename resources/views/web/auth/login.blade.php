@extends('web.layout.master')

@section('content')

<style>
    /* ===== AUTH SHARED ===== */
    .auth-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(circle at 20% 20%, rgba(37,99,235,.08), transparent 40%),
            radial-gradient(circle at 80% 80%, rgba(14,165,233,.08), transparent 40%);
    }

    .auth-card {
        background: #fff;
        border-radius: 20px;
        padding: 36px 38px;
        box-shadow: 0 25px 60px rgba(15,23,42,.15);
        border: 1px solid #eef2ff;
    }

    .auth-title h3 {
        font-weight: 700;
        color: #0f172a;
    }

    .auth-title p {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px;
    }

    .auth-input {
        height: 48px;
        border-radius: 12px;
        font-size: 15px;
        border: 1px solid #c7d2fe;
    }

    .auth-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,.18);
    }

    .btn-auth {
        height: 48px;
        border-radius: 999px;
        font-weight: 600;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border: none;
    }

    .btn-auth:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
        transform: translateY(-1px);
    }

    .auth-link {
        font-weight: 600;
        color: #2563eb;
    }
</style>

<section class="section auth-section mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                {{-- Alerts --}}
                @if(session('error'))
                    <div class="alert alert-danger rounded-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success rounded-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="auth-card">

                    <div class="auth-title text-center mb-4">
                        <h3>Welcome Back</h3>
                        <p>Login to continue reading & commenting</p>
                    </div>

                    <form action="{{ route('web.auth.login') }}" method="post">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-semibold">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control auth-input @error('email') is-invalid @enderror"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-semibold">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control auth-input @error('password') is-invalid @enderror"
                                   placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-auth w-100 mt-2" type="submit">
                            Login
                        </button>

                        <p class="mt-4 text-center">
                            Don’t have an account?
                            <a href="{{ route('web.auth.register.form') }}" class="auth-link">
                                Register here
                            </a>
                        </p>
                    </form>

                </div>

            </div>
        </div>
    </div>
</section>

@endsection
