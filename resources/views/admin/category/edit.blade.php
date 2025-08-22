@extends('admin.layout.master')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Category
                        <small>Edit</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                @if (count($errors))
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $err)
                            {{ $err }}
                        @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form id="category-form" action="{{ route('admin.category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>Category Name</label>
                            <input id="name" class="form-control" name="name" value="{{ $category->name }}"
                                placeholder="Please Enter Category Name" />
                        </div>

                        <button id="update-btn" type="submit" class="btn btn-default" disabled>Update</button>
                    </form>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const originalName = @json($category->name);
                            const nameInput = document.getElementById("name");
                            const updateBtn = document.getElementById("update-btn");

                            function checkChanged() {
                                if (nameInput.value.trim() !== originalName.trim()) {
                                    updateBtn.disabled = false;
                                } else {
                                    updateBtn.disabled = true;
                                }
                            }

                            nameInput.addEventListener("input", checkChanged);

                            // Gọi kiểm tra 1 lần lúc load để thiết lập trạng thái ban đầu
                            checkChanged();
                        });
                    </script>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    </div>
@endsection