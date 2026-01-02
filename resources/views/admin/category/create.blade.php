@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Category <small>Add new</small>
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
                        <strong>Create Category</strong>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.category.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       placeholder="Enter category name"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Create
                                </button>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-default">
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
