"use strict";

// Class definition
var KTUsersAssignAppointment = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_user');
    const form = element.querySelector('#kt_assign_appointment');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddUpdate = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'consultant': {
                        validators: {
                            notEmpty: {
                                consultant: 'Consultant is required'
                            }
                        }
                    },
                    'date': {
                        validators: {
                            notEmpty: {
                                consultant: 'Booking date is required'
                            }
                        }
                    },
                    'time': {
                        validators: {
                            notEmpty: {
                                consultant: 'Booking Time is required'
                            }
                        }
                    },
                    'status': {
                        validators: {
                            notEmpty: {
                                consultant: 'Status is required'
                            }
                        }
                    },
                  
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );


        // Submit button handler
        const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();
            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');
                  //  alert(status);

                    if (status == 'Valid') {
                       
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click 
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                           // form.submit();

                            // Show popup confirmation 
                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    modal.hide();
                                    $("#kt_assign_appointment").submit();
                                }
                            });

                            // Submit form
                        }, 2000);
                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) { 
                if (result.value) {
                    form.reset(); // Reset form			
                    //modal.hide();	
                    location.reload();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        // Close button handler
        const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form			
                  //  modal.hide();	
                  location.reload();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });
    }

    const initializeFields = () => {
        $("#date").flatpickr({
            enableTime: false,
            dateFormat: "d-m-Y",
            autoclose: true 
        });

        $("#time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i K",
        });


        $("#booking_date").flatpickr({
            startDate: '-0d',
            enableTime: false,
            dateFormat: "d-m-Y",
            autoclose: true ,
            onChange: function(selectedDates, dateStr, instance) {
                var consultant = $("#consultant").val();
                get_appointmentTime(consultant,dateStr);
            },
        });
    }
   

    return {
        // Public functions
        init: function () { 
            initAddUpdate();
            initializeFields();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAssignAppointment.init();
});


$(document).on("click",".link_edit",function(){
    $(this).parent().parent().find(".form_update").show();
    $(this).parent().hide();
});

$(document).on("click",".link_lead_update",function(){
    $(this).parent().parent().find(".txt_update").show();
    $(this).parent().hide();

    var id = $(this).parent().parent().attr("leadid");
    var content = $(this).parent().find(".update_history").val();
    //  alert(content);
    var newDiv = $(this).parent().prev().find(".span_content");
    // alert(newDiv);
    var jsonData = {id:id,content:content};
    $.ajax({
        url: hostUrl+'lms/edit_update',
        type: "post",
        data: jsonData,
        success: function (msg) {
            // location.reload();
            newDiv.html(content);
        }
    });
    
});

$(document).on("click",".link_lead_delete",function(){
    $(this).parent().parent().find(".txt_update").show();
    $(this).parent().hide();
});
