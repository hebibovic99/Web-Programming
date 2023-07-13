$(document).ready(function () {
    // Get the user ID from localStorage
    var userId = localStorage.getItem('userId');

    // Retrieve the existing user data from the server
    $.ajax({
        url: 'http://localhost/Webb-Programming/rest/get_user/' + userId,
        type: 'GET',
        success: function (response) {
            // Retrieve the existing user data from the response

            // Populate the form fields with the user data
            $('#firstName').val(response.first_name);
            $('#lastName').val(response.last_name);
            $('#email').val(response.email);
            $('#password').val(response.password);

            // Handle form submission
            $('#settingsForm').submit(function (event) {
                event.preventDefault();

                // Get the form values
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var password = $('#password').val();

                // Create an object with the updated user information
                var updatedUserData = {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    password: password
                };

                // Validate the form
                if (!validationMessage.validateForm(this)) {
                    // Form is not valid, return without submitting
                    return;
                }

                // Send the AJAX request to update the user information
                $.ajax({
                    url: 'http://localhost/Webb-Programming/rest/edit_user/' + userId,
                    type: 'POST',
                    data: JSON.stringify(updatedUserData),
                    contentType: 'application/json',
                    success: function (response) {
                        console.log(response.message);
                        // Redirect to index.html after successful edit
                        window.location.href = 'index.html';
                    },
                    error: function (xhr, status, error) {
                        // Handle the error response
                        console.error(error);
                    }
                });
            });
        }
    });

    $('#cancelButton').on('click', function () {
        // Redirect to index.html
        window.location.href = 'index.html';
    });
});
