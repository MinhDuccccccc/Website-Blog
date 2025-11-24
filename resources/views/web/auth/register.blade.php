@extends('web.layout.master')

@section('content')
<section class="section wb mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                {{-- Alert errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                              <div class="mb-1">{{ $error }}</div>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Alert success --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="page-wrapper p-4 shadow-lg bg-white rounded-3" style="border: 1px solid #eee;">
                    <h3 class="mb-4 text-center" style="font-weight: 600;">Register Account</h3>

                    <form action="{{ route('web.auth.register') }}" method="post">
                        @csrf

                        {{-- FULL NAME --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-bold">Full Name</label>
                            <input type="text" name="name"
                                   class="form-control form-control-lg custom-input @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name"
                                   value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

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

                        {{-- CONFIRM PASSWORD --}}
                        <div class="form-group mb-3">
                            <label class="mb-1 fw-bold">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control form-control-lg custom-input"
                                   placeholder="Confirm password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mt-2">
                            Register
                        </button>

                        <p class="mt-4 text-center">
                            Already have an account?
                            <a href="{{ route('web.auth.login') }}" class="text-primary fw-bold">
                                Login here
                            </a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Custom CSS đồng bộ với trang login --}}
<style>
    .custom-input {
        font-size: 16px !important;
        padding: 12px 14px !important;
        border-radius: 8px !important;
    }
</style>
@endsection
