function handleCredentialResponse(response) {
  $.ajax({
    url: '/api/login/google',
    method: 'POST',
    dataType: 'json',
    data: { 'credential': response.credential },
    success: function (response) {
      if (response.success) { window.location.href = '/' }
    },
    error: function (xhr) {
      const { responseJSON, status } = xhr
      const errorFields = ['attempts']

      switch (status) {
        case 401:
          errorFields.forEach(errorField => {
            if (Object.keys(responseJSON.errors).includes(errorField)) {
              $(`#${errorField}-message`).html(responseJSON.errors[errorField]).prop('hidden', false).addClass('text-danger')
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
    }
  })
}

$('#formAuthentication').submit((event) => {
  event.preventDefault()

  $.ajax({
    url: '/api/login',
    method: 'POST',
    data: $('#formAuthentication').serialize(),
    dataType: 'json',
    beforeSend: function () {
      $('#signin-btn').html('Authenticating...').prop('disabled', true);
    },
    success: function (response) {
      if (response.success) { window.location.href = '/' }
    },
    error: function (xhr) {
      const { responseJSON, status } = xhr
      const errorFields = ['attempts', 'email']

      switch (status) {
        case 401:
          errorFields.forEach(errorField => {
            if (Object.keys(responseJSON.errors).includes(errorField)) {
              $(`#${errorField}-message`).html(responseJSON.errors[errorField]).prop('hidden', false).addClass('text-danger')
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
      $('#signin-btn').html('Sign In').prop('disabled', false);
    },
    complete: function () {
      $('#signin-btn').val('Sign In').prop('disabled', false);
    }
  });
})
