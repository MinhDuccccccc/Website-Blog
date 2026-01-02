@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">
                    Post <small>Edit</small>
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

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-pencil"></i> Edit Post
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('admin.post.update', $post->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control"
                                       name="title"
                                       value="{{ $post->title }}">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control"
                                       name="description"
                                       value="{{ $post->description }}">
                            </div>

                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="new_post"
                                        {{ $post->new_post ? 'checked' : '' }}>
                                    New Post
                                </label>

                                <label class="checkbox-inline" style="margin-left:15px;">
                                    <input type="checkbox" name="highlight_post"
                                        {{ $post->highlight_post ? 'checked' : '' }}>
                                    Highlight
                                </label>
                            </div>

                            <div class="form-group">
                                <label>Change Image</label>
                                <input type="file"
                                       class="form-control"
                                       name="image"
                                       accept="image/*">
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content"
                                          name="content"
                                          class="ckeditor">{!! $post->content !!}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.post.index') }}"
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
