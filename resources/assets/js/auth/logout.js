
$('#logout-btn').click((event) => {
  $.ajax({
      url: '/api/logout',
      method: 'get',
      dataType: 'json',
      success: function (response) {
        if(response.success) { window.location.href = '/login' }
      },
      error: function (xhr) {
        const {responseJSON} = xhr

        Swal.fire({
          title: 'Error!',
          text: responseJSON.message,
          icon: 'error',
          confirmButtonText: 'Ok'
        })

      },
    });
})
