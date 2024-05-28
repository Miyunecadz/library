@extends('layouts/contentNavbarLayout')

@section('title', ' Renturn Book List')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Rents/</span> Due for Return Book List</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <table id="rents-list-table" class="table table-striped shadow w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Title</th>
                    <th>Borrower Name</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rents as $rent)
                    <tr>
                        <td>{{ Crypt::encrypt($rent->id) }}</td>
                        <td>{{ $rent->book->title }}</td>
                        <td>{{ $rent->borrower->name }}</td>
                        <td>{{ Carbon\Carbon::parse($rent->due_date)->format('M d, Y') }}</td>
                        <td class="d-flex gap-2">
                            @if (auth()->user()->hasRole(App\Models\User::TYPE_ADMIN) && $rent->status == App\Models\Rent::STATUS_APPROVED)
                                <button id="return-btn" class="btn btn-primary">Mark as Return</button>
                            @endif
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
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

    <script defer>
        var table = new DataTable('#rents-list-table')


        table.on('click', '#return-btn', function(e) {
            let data = table.row(e.target.closest('tr')).data();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rents/${data[0]}/returned`,
                        method: 'PUT',
                        dataType: 'json',
                        success: function(response) {
                            swalWithBootstrapButtons.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success"
                            });
                            window.location.reload()
                        },
                    })
                }
            });
        });
    </script>
@endsection
