@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Post <small>Add new</small>
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
            <div class="col-lg-8">
                <div class="panel panel-default shadow-sm">
                    <div class="panel-heading">
                        <strong>Create Post</strong>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.post.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                       class="form-control"
                                       name="title"
                                       placeholder="Enter post title"
                                       value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type="text"
                                       class="form-control"
                                       name="description"
                                       placeholder="Short description"
                                       value="{{ old('description') }}">
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="new_post">
                                            New Post
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="highlight_post">
                                            Highlight Post
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file"
                                       class="form-control"
                                       name="image"
                                       accept="image/*">
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content"
                                          name="content"
                                          class="ckeditor"></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Publish
                                </button>
                                <a href="{{ route('admin.post.index') }}" class="btn btn-default">
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
