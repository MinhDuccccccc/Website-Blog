@extends('admin.layout.master')

@section('title', 'User')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-users"></i> User
                    <small>List</small>
                </h1>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                <span><i class="fa fa-list"></i> User List</span>
                <a href="{{ route('admin.user.create') }}"
                   class="btn btn-sm btn-primary pull-right">
                    <i class="fa fa-plus"></i> Add User
                </a>
            </div>

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="100">Role</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="text-center">
                            <td>{{ $user->id }}</td>
                            <td class="text-left">{{ $user->name }}</td>
                            <td class="text-left">{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="label label-danger">Admin</span>
                                @else
                                    <span class="label label-info">User</span>
                                @endif
                            </td>
                            <td>
                                {{-- CHỈ USER THƯỜNG MỚI ĐƯỢC THAO TÁC --}}
                                @if(!$user->is_admin)
                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                       class="btn btn-xs btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    {{-- DELETE (GET route) --}}
                                    <a href="{{ route('admin.user.delete', $user->id) }}"
                                       class="btn btn-xs btn-danger"
                                       onclick="return confirm('Delete this user?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No users found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="text-right">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
