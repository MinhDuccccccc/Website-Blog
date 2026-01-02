@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    User <small>Add new</small>
                </h1>
            </div>
        </div>

        {{-- ERRORS --}}
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        {{-- FORM --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default shadow-sm">
                    <div class="panel-heading">
                        <strong>Create User</strong>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.user.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       placeholder="Enter full name"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       placeholder="Enter email address"
                                       value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password"
                                       class="form-control"
                                       name="password"
                                       placeholder="Enter password">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       placeholder="Confirm password">
                            </div>

                            <div class="form-group">
                                <label>Role</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="is_admin" value="0" checked>
                                    User
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_admin" value="1">
                                    Admin
                                </label>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-user-plus"></i> Create User
                                </button>
                                <a href="{{ route('admin.user.index') }}" class="btn btn-default">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
