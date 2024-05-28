@extends('layouts/contentNavbarLayout')

@section('title', 'User List')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Users/</span> List</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <table id="user-list-table" class="table table-striped shadow w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <style>
        table td:first-child {
            width: 100%;
            height: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 100px;
        }
    </style>

    <script src="{{ asset('assets/js/users/user-list.js') }}"></script>
@endsection
