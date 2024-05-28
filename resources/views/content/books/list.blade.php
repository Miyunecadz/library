@extends('layouts/contentNavbarLayout')

@section('title', ' Book List')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Books/</span> List</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <table id="book-list-table" class="table table-striped shadow w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Book Number</th>
                    <th>Is Available</th>
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

    <script src="{{ asset('assets/js/books/book-list.js') }}"></script>
@endsection
