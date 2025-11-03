@extends('web.layout.master')

@section('content')
<section class="section wb mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-wrapper">
                    <div class="row">
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
                            <form class="form-wrapper" action="{{ route('web.auth.register') }}" method="post">
                                @csrf
                                <input type="text" name="name" class="form-control" placeholder="Full name" required>
                                <input type="email" name="email" class="form-control" placeholder="Email address" required>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                <button type="submit" class="btn btn-primary">Register</button>
                                <p class="mt-3">Already have an account? <a href="{{ route('web.auth.login') }}">Login here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
