$(document).ready(function () {
    function setTokenCookie(token) {
        const days = 7; // valid for 7 days
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `token=${encodeURIComponent(token)}; path=/; SameSite=Lax`;
    }

    $("#loginForm").validate({
        rules: {
            loginIdentifier: {
                required: true,
            },
            loginPassword: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            loginIdentifier: {
                required: "Please enter your email or username"
            },
            loginPassword: {
                required: "Please enter your password",
                minlength: "Password must be at least 4 characters long"
            }
        },
        errorElement: "div",
        errorClass: "text-danger mt-1",
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function () {
            const identifier = $('#loginIdentifier').val().trim();
            const password = $('#loginPassword').val().trim();

            const $loginBtn = $('#loginButton');

            $loginBtn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Logging in...
            `);

            $.ajax({
                url: '../../api/auth.php?action=login-admin',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ email: identifier, password }),
                success: function (response) {
                    localStorage.setItem('token', response.token);
                    setTokenCookie(response.token);
                    alert('Login successful as admin!');
                    window.location.href = '../index.php';
                },
                error: function (xhr) {
                    let msg = 'Invalid email/username or password.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        msg = xhr.responseJSON.error;
                    }
                    alert(msg);

                    $loginBtn.prop('disabled', false).html('LOG IN');
                }
            });
        }
    });
});
