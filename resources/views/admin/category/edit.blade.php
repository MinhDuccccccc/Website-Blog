@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Category <small>Edit</small>
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
                        <i class="fa fa-edit"></i> Edit Category
                    </div>

                    <div class="panel-body">
                        <form id="category-form"
                              action="{{ route('admin.category.update', $category->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Category Name</label>
                                <input id="name"
                                       class="form-control"
                                       name="name"
                                       value="{{ $category->name }}"
                                       placeholder="Enter category name">
                            </div>

                            <button id="update-btn"
                                    type="submit"
                                    class="btn btn-primary"
                                    disabled>
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.category.index') }}"
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const originalName = @json($category->name);
    const nameInput = document.getElementById("name");
    const updateBtn = document.getElementById("update-btn");

    function checkChanged() {
        updateBtn.disabled = nameInput.value.trim() === originalName.trim();
    }

    nameInput.addEventListener("input", checkChanged);
    checkChanged();
});
</script>
@endsection
