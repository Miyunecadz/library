const table = new DataTable('#book-list-table', {
  ajax: '/books/fetch',
  dataSrc: 'data',
  columnDefs: [{
    data: null,
    defaultContent: `
                <div class="d-flex gap-2">
                  <button class="btn btn-primary btn-sm" id="edit-book-btn">Edit</button>
                  <button class="btn btn-danger btn-sm" id="delete-book-btn">Delete</button>
                </div>
                `,
    targets: -1
  }]
})

table.on('click', '#edit-book-btn', function (e) {
  let data = table.row(e.target.closest('tr')).data();

  window.location.replace(`/books/${data[0]}/edit`)
})


table.on('click', '#delete-book-btn', function (e) {
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
        url: `/books/${data[0]}`,
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
