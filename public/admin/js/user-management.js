$(function () {
    // Show modal and populate form
    $('.btn-view').click(function () {
        const btn = $(this);
        $('#userId').val(btn.data('iduser') || btn.data('id'));
        $('#firstName').val(btn.data('first_name') || btn.data('first'));
        $('#lastName').val(btn.data('last_name') || btn.data('last'));
        $('#email').val(btn.data('email'));
        $('#telephone').val(btn.data('telephone'));
        $('#address').val(btn.data('address'));

        const row = btn.closest('tr');

        $('#userModal').modal('show');
    });

    // Submit update form
    $('#userForm').submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const saveBtn = form.find('button[type="submit"]');
        const originalHtml = saveBtn.html();

        const id = $('#userId').val(); // hidden input
        const token = localStorage.getItem('token'); // if using JWT auth

        const formData = {
            iduser: id,
            first_name: $('#firstName').val(),
            last_name: $('#lastName').val(),
            email: $('#email').val(),
            telephone: $('#telephone').val(),
            address: $('#address').val(),
        };

        saveBtn.prop('disabled', true).html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`
        );

        $.ajax({
            url: '../api/admin/user.php',
            type: 'PUT',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function (response) {
                console.log('Update successful:', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Update failed:', status, error);
                console.error('XHR response:', xhr.responseText);
                alert('Failed to update user. Check console for details.');
            },
            complete: function () {
                saveBtn.prop('disabled', false).html(originalHtml);
                console.log('PUT request completed.');
            }
        });
    });


    // Delete user 
    $('#deleteUser').click(function () {
        if (!confirm('Are you sure you want to delete this user?')) return;

        const btn = $(this);
        const originalHtml = btn.html();
        const id = $('#userId').val();
        const token = localStorage.getItem('token');

        btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...`);

        $.ajax({
            url: '../api/admin/user.php',
            type: 'DELETE',
            data: JSON.stringify({
                id: id
            }),
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            beforeSend: function () {
                console.log('Sending DELETE request for user ID:', id);
            },
            success: function (response) {
                console.log('Delete successful:', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Delete failed:', status, error);
                console.error('XHR response:', xhr);
                alert('Failed to delete user.');
            },
            complete: function () {
                btn.prop('disabled', false).html(originalHtml);
                console.log('DELETE request completed.');
            }
        });
    });
});