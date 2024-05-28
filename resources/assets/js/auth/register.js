$('#registerForm').submit((event) => {
  event.preventDefault()

  $.ajax({
    url: '/api/register',
    method: 'POST',
    data: $('#registerForm').serialize(),
    dataType: 'json',
    beforeSend: function () {
      $('#signup-btn').html('Registering...').prop('disabled', true);
    },
    success: function (response) {
      if (response.success) {
        Swal.fire({
          title: 'Successfully Registered!',
          text: 'Account successfully registered',
          icon: 'success',
          confirmButtonText: 'Ok',
        }).then(function (is_confirmed) {
          if (is_confirmed) { window.location.href = '/' }
        })
      }
    },
    error: function (xhr) {
      const { responseJSON, status } = xhr
      const errorFields = ['name', 'email', 'password']
      console.log(status, responseJSON)
      switch (status) {
        case 422:
          errorFields.forEach(errorField => {
            if (Object.keys(responseJSON.errors).includes(errorField)) {
              $(`#${errorField}-message`).html(responseJSON.errors[errorField][0]).prop('hidden', false).addClass('text-danger')
            } else {
              $(`#${errorField}-message`).prop('hidden', false).removeClass('text-danger')
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
      $('#signup-btn').html('Sign Up').prop('disabled', false);
    },
    complete: function () {
      $('#signup-btn').val('Sign Up').prop('disabled', false);
    }
  });
})
