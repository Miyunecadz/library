@extends('layouts/contentNavbarLayout')

@section('title', ' Create Rent - Form')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Rents/</span> Create</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rent Information</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="rentCreateForm">
                        <div class="mb-3">
                            <label class="form-label" for="title">Book Title</label>
                            <select name="book_id" id="book_id" class="form-select">
                                <option value="">Select one</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                            <small id="book_id-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Borrower Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="genre">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control">
                            <small id="due_date-message" class=""></small>
                        </div>
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script defer>
        $('#rentCreateForm').submit(function(e) {
            e.preventDefault()

            $.ajax({
                url: `/rents`,
                method: 'POST',
                data: $('#rentCreateForm').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#save-btn').html('Creating...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Successfully Created!',
                            text: 'Redirecting to rents list',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then(function(is_confirmed) {
                            if (is_confirmed) {
                                window.location.href = '/rents'
                            }
                        })
                    }
                },
                error: function(xhr) {
                    const {
                        responseJSON,
                        status
                    } = xhr
                    const errorFields = [
                        'book_id',
                        'due_date',
                    ]
                    switch (status) {
                        case 422:
                            errorFields.forEach(errorField => {
                                if (Object.keys(responseJSON.errors).includes(errorField)) {
                                    $(`#${errorField}-message`).html(responseJSON.errors[
                                        errorField][0]).prop('hidden', false).addClass(
                                        'text-danger')
                                } else {
                                    $(`#${errorField}-message`).html('').prop('hidden', true)
                                        .removeClass('text-danger')
                                }
                            })
                            break;

                        default:
                            Swal.fire({
                                title: 'Error!',
                                text: responseJSON.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                            break;
                    }
                    $('#save-btn').html('Save').prop('disabled', false);
                },
                complete: function() {
                    $('#save-btn').val('Save').prop('disabled', false);
                }
            });
        })
    </script>
@endsection
