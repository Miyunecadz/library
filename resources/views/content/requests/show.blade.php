@extends('layouts/contentNavbarLayout')

@section('title', ' Create Rent - Form')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Rents/</span> Show</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rent Information</h5>
                </div>
                <div class="card-body">
                    <div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Book Title</label>
                            <input type="text" value="{{ $rent->book->title }}" class="form-control" readonly>

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Borrower Name</label>
                            <input type="text" value="{{ $rent->borrower->name }}" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="genre">Due Date</label>
                            <input type="text" name="due_date" id="due_date" class="form-control"
                                value="{{ Carbon\Carbon::parse($rent->due_date)->format('M D, Y') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="genre">Issued Date</label>
                            <input type="text" name="return_date" id="return_date" class="form-control"
                                value="{{ Carbon\Carbon::parse($rent->created_at)->format('M D, Y') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="genre">Return Date</label>
                            <input type="text" name="return_date" id="return_date" class="form-control"
                                value="{{ Carbon\Carbon::parse($rent->return_date)->format('M D, Y') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
