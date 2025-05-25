$(document).ready(function () {
    // Custom method for email validation
    $.validator.addMethod("customEmail", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
    }, "Please enter a valid email address");

    $("#loginForm").validate({
        rules: {
            loginEmail: {
                required: true,
                customEmail: true
            },
            loginPassword: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            loginEmail: {
                required: "Please enter your email address"
            },
            loginPassword: {
                required: "Please enter your password",
                minlength: "Password must be at least 6 characters long"
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
        submitHandler: function (form) {
            alert("Login successful!");
            form.submit(); // Uncomment for actual form submission
        }
    });
});