$('#bookUpdateForm').submit(function (e) {
  e.preventDefault()

  const book_id = $('[name="book_id"]').val()

  $.ajax({
    url: `/books/${book_id}`,
    method: 'PUT',
    data: $('#bookUpdateForm').serialize(),
    dataType: 'json',
    beforeSend: function () {
      $('#save-btn').html('Updating...').prop('disabled', true);
    },
    success: function (response) {
      if (response.success) {
        Swal.fire({
          title: 'Successfully Updated!',
          text: 'Redirecting to books list',
          icon: 'success',
          confirmButtonText: 'Ok',
        }).then(function (is_confirmed) {
          if (is_confirmed) { window.location.href = '/books' }
        })
      }
    },
    error: function (xhr) {
      const { responseJSON, status } = xhr
      const errorFields = [
        'title',
        'author',
        'genre',
        'book_number',
        'is_available'
      ]
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
            text: responseJSON?.message ?? 'Server error!',
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
