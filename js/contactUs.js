$(document).ready(function () {
    $('#contact-form').submit(function (event) {
        event.preventDefault(); // Prevent form submission

        // Gather the form data
        var name = $('#name').val();
        var email = $('#email').val();
        var number = $('#number').val();
        var message = $('#message').val();

        // Validate email format
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#msgSubmit').removeClass('hidden');
            $('#msgSubmit').text('Please enter a valid email address');
            return; // Stop further processing
        }

        // Validate number format
        var numberRegex = /^[0-9]{10}$/;
        if (!numberRegex.test(number)) {
            $('#msgSubmit').removeClass('hidden');
            $('#msgSubmit').text('Please enter a valid 10-digit number');
            return; // Stop further processing
        }

        // Create an object with the form data
        var formData = {
            name: name,
            email: email,
            number: number,
            subject: message
        };

        // Send the AJAX request
        $.ajax({
            type: 'POST',
            url: 'http://localhost/Webb-Programming/rest/contact',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Handle the response from the server
                $('#msgSubmit').removeClass('hidden');
                $('#msgSubmit').text(response.message);
                $('#contact-form')[0].reset();
            },
            error: function (xhr, status, error) {
                // Handle any errors that occurred during the AJAX request
                console.error(error);
            }
        });
    });
});