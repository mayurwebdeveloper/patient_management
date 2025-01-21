$(document).ready(function () {
    let appointmentId = null;

   
    // Save Patient Info (First Tab)
    $('#save-patient-info').click(function () {
        let formData = $('#form-patient-info').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: $('#form-patient-info').attr('action'),
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    appointmentId = response.appointment_id; // Store the appointment ID
                    Swal.fire('Patient info updated successfully!');
                } else {
                    Swal.fire('Error saving patient info.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $.each(errors, function (field, messages) {
                        // Find the field
                        let inputField = $('[name="' + field + '"]');
                        console.log(inputField);
    
                        // Add the is-invalid class to the input field
                        inputField.addClass('is-invalid');
    
                        // Insert the error message after the input field
                        inputField.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    // Other errors
                    Swal.fire('Error: ' + xhr.responseText);
                }
            }
        });
    });

    // Save General Examination (Second Tab)
    $('#save-general-exam').click(function () {
        let formData = $('#form-general-exam').serialize();
        $.ajax({
            url: $('#form-general-exam').attr('action'),
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    Swal.fire('General examination Updated successfully!');
                } else {
                    Swal.fire('Error saving general examination.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $.each(errors, function (field, messages) {
                        // Find the field
                        let inputField = $('[name="' + field + '"]');
                        console.log(inputField);
    
                        // Add the is-invalid class to the input field
                        inputField.addClass('is-invalid');
    
                        // Insert the error message after the input field
                        inputField.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    // Other errors
                    Swal.fire('Error: ' + xhr.responseText);
                }
            }
        });
    });


    $('#save-systemic-exam').click(function () {
        let formData = $('#form-systemic-exam').serialize();
        $.ajax({
            url: $('#form-systemic-exam').attr('action'),
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    Swal.fire('Systemic examination updated successfully!');
                } else {
                    Swal.fire('Error saving Systemic examination.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $.each(errors, function (field, messages) {
                        // Find the field
                        let inputField = $('[name="' + field + '"]');
                        console.log(inputField);
    
                        // Add the is-invalid class to the input field
                        inputField.addClass('is-invalid');
    
                        // Insert the error message after the input field
                        inputField.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    // Other errors
                    Swal.fire('Error: ' + xhr.responseText);
                }
            }
        });
    });

    $('#save-history-exam').click(function () {
        let formData = $('#form-history-exam').serialize();
        $.ajax({
            url: $('#form-history-exam').attr('action'),
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    Swal.fire('Obstetric Histroy updated successfully!');
                } else {
                    Swal.fire('Error saving Obstetric Histroy.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $.each(errors, function (field, messages) {
                        // Find the field
                        let inputField = $('[name="' + field + '"]');
                        console.log(inputField);
    
                        // Add the is-invalid class to the input field
                        inputField.addClass('is-invalid');
    
                        // Insert the error message after the input field
                        inputField.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    // Other errors
                    Swal.fire('Error: ' + xhr.responseText);
                }
            }
        });
    });

    $('#save-complaint-exam').click(function () {

        let formData = $('#form-complaint-exam').serialize();
        $.ajax({
            url: $('#form-complaint-exam').attr('action'),
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    // Enable the next tab
                    // $('#nav-systemic-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('Presenting Complaint updated successfully!');
                    setTimeout(function () {
                        window.location.href = "/admin/appointments";
                    }, 5000);
                } else {
                    Swal.fire('Error saving Presenting Complaint.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $.each(errors, function (field, messages) {
                        // Find the field
                        let inputField = $('[name="' + field + '"]');
                        console.log(inputField);
    
                        // Add the is-invalid class to the input field
                        inputField.addClass('is-invalid');
    
                        // Insert the error message after the input field
                        inputField.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    // Other errors
                    Swal.fire('Error: ' + xhr.responseText);
                }
            }
        });
    });
});
