@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">
                    Profile <small>Edit</small>
                </h1>
            </div>

            {{-- Errors --}}
            @if(count($errors))
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            <p class="mb-1">{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Success --}}
            @if(session('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="col-lg-6">
                <div class="panel panel-default shadow-sm">
                    <div class="panel-heading">
                        <i class="fa fa-user-circle"></i> Update Profile
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control"
                                       name="name"
                                       value="{{ auth()->user()->name }}"
                                       placeholder="Enter your name">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control"
                                       type="email"
                                       value="{{ auth()->user()->email }}"
                                       readonly>
                            </div>

                            <hr>

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
                                       type="password"
                                       placeholder="Confirm new password">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
