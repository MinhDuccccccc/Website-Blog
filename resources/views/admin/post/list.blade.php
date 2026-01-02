@extends('admin.layout.master')

@section('title', 'Post')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-file-text"></i> Post
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
            <div class="panel-heading">
                <span><i class="fa fa-list"></i> Post List</span>
                <a href="{{ route('admin.post.create') }}" class="btn btn-sm btn-primary pull-right">
                    <i class="fa fa-plus"></i> Add Post
                </a>
            </div>

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="60">ID</th>
                            <th>Title</th>
                            <th width="80">Image</th>
                            <th>Category</th>
                            <th width="120">Highlight</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr class="text-center">
                            <td>{{ $post->id }}</td>
                            <td class="text-left">{{ $post->title }}</td>
                            <td>
                                <img src="{{ $post->imageUrl() }}" width="50">
                            </td>
                            <td>{{ $post->category->name }}</td>
                            <td>
                                @if($post->highlight_post)
                                    <span class="label label-success">YES</span>
                                @else
                                    <span class="label label-default">NO</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.post.edit', $post->id) }}"
                                   class="btn btn-xs btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a href="{{ route('admin.post.delete', $post->id) }}"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Delete this post?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
