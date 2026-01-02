@extends('admin.layout.master')

@section('title', 'Contact')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        {{-- Page header --}}
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-envelope"></i> Contact
                    <small>List</small>
                </h1>
            </div>
        </div>

        {{-- Success alert --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Panel --}}
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-list"></i> Contact Messages
            </div>

            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th width="120">Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($contacts as $contact)
                        <tr class="text-center">
                            <td>{{ $contact->id }}</td>

                            <td class="text-left">
                                {{ $contact->name }}
                            </td>

                            <td class="text-left">
                                {{ $contact->address }}
                            </td>

                            <td>
                                {{ $contact->phone }}
                            </td>

                            <td class="text-left">
                                <strong>{{ $contact->subject }}</strong>
                            </td>

                            <td class="text-left" style="max-width: 300px;">
                                {{ \Illuminate\Support\Str::limit($contact->message, 120) }}
                            </td>

                            <td>
                                <a href="{{ route('admin.contact.delete', $contact->id) }}"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Delete this contact message?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="text-right">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
