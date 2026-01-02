@extends('admin.layout.master')

@section('title', 'Category')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-folder"></i> Category
                    <small>List</small>
                </h1>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading d-flex justify-content-between">
                <span><i class="fa fa-list"></i> Category List</span>
                <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-primary pull-right">
                    <i class="fa fa-plus"></i> Add Category
                </a>
            </div>

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="80">ID</th>
                            <th>Name</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr class="text-center">
                            <td>{{ $category->id }}</td>
                            <td class="text-left">{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                   class="btn btn-xs btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a href="{{ route('admin.category.delete', $category->id) }}"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Delete this category?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
