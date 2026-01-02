@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">
                    User <small>Edit</small>
                </h1>
            </div>

            @if(count($errors))
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user"></i> Edit User
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control"
                                       name="name"
                                       value="{{ $user->name }}">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control"
                                       type="email"
                                       value="{{ $user->email }}"
                                       readonly>
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input class="form-control"
                                       name="password"
                                       type="password"
                                       placeholder="Leave blank if unchanged">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input class="form-control"
                                       name="confirm"
                                       type="password">
                            </div>

                            <div class="form-group">
                                <label>Role</label><br>
                                <label class="radio-inline">
                                    <input type="radio"
                                           name="is_admin"
                                           value="0"
                                           {{ !$user->is_admin ? 'checked' : '' }}>
                                    User
                                </label>
                                <label class="radio-inline" style="margin-left:15px;">
                                    <input type="radio"
                                           name="is_admin"
                                           value="1"
                                           {{ $user->is_admin ? 'checked' : '' }}>
                                    Admin
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.user.index') }}"
                               class="btn btn-default">
                                Cancel
                            </a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
