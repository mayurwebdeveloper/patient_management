$(document).ready(function () {
    let appointmentId = null;

    // Disable all tabs except the first one on page load
    $('.nav-link').not('#nav-patient-tab').addClass('disabled').attr('aria-disabled', 'true');

    // Save Patient Info (First Tab)
    $('#save-patient-info').click(function () {
        let formData = $('#form-patient-info').serialize();
        $.ajax({
            url: "{{ route('save-patient-info') }}",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    appointmentId = response.appointment_id; // Store the appointment ID
                    $('#appointment_id').val(appointmentId); // Set the hidden field value for subsequent tabs

                    // Enable the next tab
                    $('#nav-general-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    alert('Patient info saved successfully!');
                } else {
                    alert('Error saving patient info.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
    
                    $.each(errors, function (field, messages) {
                        errorMessages += messages.join('<br>') + '<br>';
                    });
    
                    // Display the errors
                    $('#error-messages').html('<div class="alert alert-danger">' + errorMessages + '</div>');
                } else {
                    // Other errors
                    alert('Error: ' + xhr.responseText);
                }
            }
        });
    });

    // Save General Examination (Second Tab)
    $('#save-general-exam').click(function () {
        if (!appointmentId) {
            alert('Please complete the patient info in the first tab before proceeding.');
            $('#nav-patient-tab').click();
            return;
        }

        let formData = $('#form-general-exam').serialize();
        $.ajax({
            url: "{{ route('save-general-exam') }}",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Enable the next tab
                    $('#nav-systemic-tab').removeClass('disabled').removeAttr('aria-disabled').click();
                    alert('General examination saved successfully!');
                } else {
                    alert('Error saving general examination.');
                }
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // Prevent disabled tabs from being clicked
    $('.nav-link.disabled').click(function (e) {
        e.preventDefault();
        alert('Please complete the previous step(s) first.');
    });
});
