$(document).ready(function () {
    let appointmentId = null;

    // Disable all tabs except the first one on page load
    $('.appointmentTab .nav-link').not('#nav-patient-tab').addClass('disabled').attr('aria-disabled', 'true');

    // Save Patient Info (First Tab)
    $('#save-patient-info').click(function () {
        let formData = $('#form-patient-info').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/admin/save-patient-info",
            method: "POST",
            data: formData,
            success: function (response) {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success) {
                    appointmentId = response.appointment_id; // Store the appointment ID
                    $('.appointment_id').val(appointmentId); // Set the hidden field value for subsequent tabs

                    // Enable the next tab
                    $('#nav-general-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('Patient info saved successfully!');
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
        if (!appointmentId) {
            Swal.fire('Please complete the patient info in the first tab before proceeding.');
            $('#nav-patient-tab').click();
            return;
        }

        let formData = $('#form-general-exam').serialize();
        $.ajax({
            url: "/admin/save-general-exam",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Enable the next tab
                    $('#nav-systemic-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('General examination saved successfully!');
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
        if (!appointmentId) {
            Swal.fire('Please complete the patient info in the first tab before proceeding.');
            $('#nav-patient-tab').click();
            return;
        }

        let formData = $('#form-systemic-exam').serialize();
        $.ajax({
            url: "/admin/save-systemic-exam",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Enable the next tab
                    $('#nav-history-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('Systemic examination saved successfully!');
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
        if (!appointmentId) {
            alert('Please complete the patient info in the first tab before proceeding.');
            $('#nav-patient-tab').click();
            return;
        }

        let formData = $('#form-history-exam').serialize();
        $.ajax({
            url: "/admin/save-history-exam",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Enable the next tab
                    $('#nav-complaint-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('Obstetric Histroy saved successfully!');
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
        if (!appointmentId) {
            Swal.fire('Please complete the patient info in the first tab before proceeding.');
            $('#nav-patient-tab').click();
            return;
        }

        let formData = $('#form-complaint-exam').serialize();
        $.ajax({
            url: "/admin/save-complaint-exam",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Enable the next tab
                    // $('#nav-systemic-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    Swal.fire('Presenting Complaint saved successfully!');
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

    // Prevent disabled tabs from being clicked
    $('.nav-link.disabled').click(function (e) {
        e.preventDefault();
        // alert('Please complete the previous step(s) first.');
    });
});
