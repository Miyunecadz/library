table.on('click', '#cancel-btn', function (e) {
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
            data: JSON.stringify({ 'reason': reason }),
            dataType: 'json',
            success: function (data) {
              resolve(data);
            },
            error: function (error) {
              reject(error);
            }
          })
        })

        return response;
      } catch (error) {
        Swal.showValidationMessage(`
        Request failed: ${error}
      `);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
    .then((result) => {
      if (result.isConfirmed) {
        window.location.reload();
      }
    });
})
