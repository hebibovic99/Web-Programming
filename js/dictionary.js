$(document).ready(function () {
    function displayDictionaryData(data) {
        var container = $('#cardContainer');

        // Clear any existing data in the container
        container.empty();

        var row; // Variable to store the current row

        // Loop through the dictionary entries and create card components for each entry
        data.forEach(function (entry, index) {
            // Create a new column element for the card
            var column = $('<div class="col-md-3 mb-4"></div>');

            // Create a new card element
            var card = $('<div class="card mt-4"></div>');

            // Create card content based on the entry data
            var signLanguage = $('<h3> Sign Language:' + entry.sign_language + '</h3>');
            var word = $('<p> Word: ' + entry.word + '</p>');
            var phrase = $('<p> Meaning: ' + entry.phrase + '</p>');

            // Create an <img> element for the image
            var image = $('<img class="card-img-top" alt="Dictionary Image">');
            image.attr('src', 'data:image/png;base64,' + entry.image); // Assuming the image is stored as base64 string

            // Create "Edit Image" button for the card
            var editImageButton = $('<button class="btn btn-primary edit-image-btn" data-card-id="' + entry.id + '">Edit Image</button>');

            // Create "Delete" button for the card
            var deleteButton = $('<button class="btn btn-danger delete-btn" data-card-id="' + entry.id + '">Delete</button>');

            // Append the content, image, and buttons to the card element
            card.append(image, signLanguage, word, phrase, editImageButton, deleteButton);

            // Append the card to the column
            column.append(card);

            if (index % 4 === 0) {
                // Create a new row every four cards
                row = $('<div class="row"></div>');
                container.append(row);
            }

            // Append the column to the current row
            row.append(column);
        });

        // Bind click event to "Edit Image" buttons
        container.on('click', '.edit-image-btn', function () {
            var cardId = $(this).data('card-id');
            var fileInput = $('<input type="file">');

            // Trigger file input click event programmatically
            fileInput.click();

            // Event listener for file input change
            fileInput.on('change', function () {
                var file = this.files[0];
                if (file) {
                    var formData = new FormData();
                    formData.append('image', file);

                    // Send the image file to the backend API for updating
                    $.ajax({
                        url: 'http://localhost/Webb-Programming/rest/update_image/' + cardId,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response.message);
                            // Reload the dictionary data after successful update
                            reloadDictionaryData();
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                            // Handle error response
                        }
                    });
                }
            });
        });

        // Bind click event to "Delete" buttons
        container.on('click', '.delete-btn', function () {
            var deleteButton = $(this);
            var cardId = deleteButton.data('card-id');

            // Disable the button to prevent multiple clicks
            deleteButton.prop('disabled', true);

            deleteDictionaryEntry(cardId, function (success) {
                if (success) {
                    // Handle success response
                    // Reload the dictionary data after successful deletion
                    reloadDictionaryData();
                } else {
                    // Handle error response
                    // Re-enable the delete button if the request fails
                    deleteButton.prop('disabled', false);
                }
            });
        });
    }

    // Function to reload the dictionary data
    function reloadDictionaryData() {
        $.ajax({
            type: 'GET',
            url: 'http://localhost/Webb-Programming/rest/dictionary',
            success: function (response) {
                // Process the received data
                console.log(response);
                // Call a function to display the data in the frontend
                displayDictionaryData(response);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    }

    // Function to add a new dictionary entry
    function addDictionaryEntry() {
        var signLanguageInput = $('#signLanguageInput').val();
        var wordInput = $('#wordInput').val();
        var phraseInput = $('#phraseInput').val();
        var fileInput = $('#imageInput').get(0).files[0];

        // Create a FormData object and append the form data
        var formData = new FormData();
        formData.append('sign_language', signLanguageInput);
        formData.append('word', wordInput);
        formData.append('phrase', phraseInput);
        formData.append('image', fileInput);

        // Send the form data to the backend API for adding the entry
        $.ajax({
            url: 'http://localhost/Webb-Programming/rest/add_dictionary',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response.message);
                reloadDictionaryData();

                // Hide the modal
                $('#addEntryModal').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Function to delete a dictionary entry
    function deleteDictionaryEntry(cardId, callback) {
        // Send the delete request to the backend API
        $.ajax({
            url: 'http://localhost/Webb-Programming/rest/delete_dictionary/' + cardId,
            type: 'DELETE',
            success: function (response) {
                alert(response.message);
                // Invoke the callback with success flag
                callback(true);
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Invoke the callback with error flag
                callback(false);
            }
        });
    }

    // Initial loading of the dictionary data
    reloadDictionaryData();

    // Add Entry button click event
    $('#addEntryButton').click(function () {
        // Reset the input fields
        $('#signLanguageInput').val('');
        $('#wordInput').val('');
        $('#phraseInput').val('');
        $('#imageInput').val('');

        // Show the modal
        $('#addEntryModal').modal('show');
    });

    // Save Entry button click event
    $('#saveEntryButton').click(function () {
        addDictionaryEntry();
    });
});
