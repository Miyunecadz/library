@extends('layouts/contentNavbarLayout')

@section('title', ' Rent List')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Rents/</span> List</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <table id="rents-list-table" class="table table-striped shadow w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Title</th>
                    <th>Borrower Name</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
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
                        <td>{{ Carbon\Carbon::parse($rent->return_date)->format('M d, Y') }}</td>
                        <td>{{ $rent->status }}</td>
                        <td>{{ $rent->reason }}</td>
                        <td class="d-flex gap-2">

                            <a href="{{ route('rents.show', ['id' => Crypt::encrypt($rent->id)]) }}"
                                class="btn btn-primary">Show</a>

                            @if (auth()->user()->hasRole(App\Models\User::TYPE_CLIENT) && $rent->status == App\Models\Rent::STATUS_PENDING)
                                <button id="cancel-btn" class="btn btn-danger">Cancel</button>
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


        table.on('click', '#cancel-btn', function(e) {
            let data = table.row(e.target.closest('tr')).data();

            Swal.fire({
                    title: "Are you sure you want to cancel? Tell us your reason.",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    showLoaderOnConfirm: true,
                    preConfirm: async (reason) => {
                        try {
                            const response = await new Promise((resolve, reject) => {
                                $.ajax({
                                    url: `/rents/${data[0]}`,
                                    method: 'PUT',
                                    data: {
                                        'reason': reason
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        resolve(data);
                                    },
                                    error: function(error) {
                                        reject(error);
                                    }
                                })
                            })

                            if (!response.success) {
                                return Swal.showValidationMessage(`Request failed: ${error}`);
                            }
                            return response;
                        } catch (error) {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: result.value.message
                        });

                        window.location.reload();
                    }
                });
        })
    </script>
@endsection
