$('#userCreateForm').submit(function (e) {
  e.preventDefault()

  const user_id = $('[name="user_id"]').val()

  $.ajax({
    url: `/users`,
    method: 'POST',
    data: $('#userCreateForm').serialize(),
    dataType: 'json',
    beforeSend: function () {
      $('#save-btn').html('Updating...').prop('disabled', true);
    },
    success: function (response) {
      if (response.success) {
        Swal.fire({
          title: 'Successfully Created!',
          text: 'Redirecting to users list',
          icon: 'success',
          confirmButtonText: 'Ok',
        }).then(function (is_confirmed) {
          if (is_confirmed) { window.location.href = '/users' }
        })
      }
    },
    error: function (xhr) {
      const { responseJSON, status } = xhr
      const errorFields = ['name', 'email', 'user_type', 'password']
      switch (status) {
        case 422:
          errorFields.forEach(errorField => {
            if (Object.keys(responseJSON.errors).includes(errorField)) {
              $(`#${errorField}-message`).html(responseJSON.errors[errorField][0]).prop('hidden', false).addClass('text-danger')
            } else {
              $(`#${errorField}-message`).html('').prop('hidden', true).removeClass('text-danger')
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
    complete: function () {
      $('#save-btn').val('Save').prop('disabled', false);
    }
  });
})
