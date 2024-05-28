@extends('layouts/contentNavbarLayout')

@section('title', ' Update Book - Form')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Book/</span> Update</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Book Information</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="bookUpdateForm">
                        <input type="hidden" name="book_id" value="{{ Crypt::encrypt($book->id) }}">
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="The Rich Dad and The Poor Dad" value="{{ $book->title }}" />
                            <small id="title-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author"
                                placeholder="Robert Kiyosaki and Sharon Lechter" value="{{ $book->author }}" />
                            <small id="author-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="genre">Genre</label>
                            <input type="text" class="form-control" id="genre" name="genre" placeholder="Finance"
                                value="{{ $book->genre }}" />
                            <small id="genre-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="book_number">Book Number</label>
                            <input type="text" class="form-control" id="book_number" name="book_number"
                                placeholder="*****" value="{{ $book->book_number }}" />
                            <small id="book_number-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="is_available">User Type</label>
                            <select name="is_available" id="is_available" class="form-select">
                                <option value="">Select one</option>
                                @foreach ($status as $key => $stat)
                                    <option value="{{ $key }}" @if ($key == $book->is_available) selected @endif>
                                        {{ $stat }}</option>
                                @endforeach
                            </select>
                            <small id="is_available-message" class=""></small>
                        </div>
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/books/book-update.js') }}" defer></script>
@endsection
