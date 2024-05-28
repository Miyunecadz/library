const table = new DataTable('#user-list-table', {
  ajax: '/users/fetch',
  dataSrc: 'data',
  columnDefs: [{
    data: null,
    defaultContent: `
                <div class="d-flex gap-2">
                  <button class="btn btn-primary btn-sm" id="edit-user-btn">Edit</button>
                  <button class="btn btn-danger btn-sm" id="delete-user-btn">Delete</button>
                </div>
                `,
    targets: -1
  }]
})

table.on('click', '#edit-user-btn', function (e) {
  let data = table.row(e.target.closest('tr')).data();

  window.location.replace(`/users/${data[0]}/edit`)
})


table.on('click', '#delete-user-btn', function (e) {
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
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `/users/${data[0]}`,
        method: 'DELETE',
        dataType: 'json',
        success: function (response) {
          swalWithBootstrapButtons.fire({
            title: "Deleted!",
            text: response.message,
            icon: "success"
          });
          table.ajax.reload();
        },
      })
    }
  });
});
