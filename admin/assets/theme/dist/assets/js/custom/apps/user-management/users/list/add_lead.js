"use strict";

// Class definition
var KTUsersAddUser = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_user');
    const form = element.querySelector('#kt_modal_add_user_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddUser = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'First name is required'
                            }
                        }
                    },
                    'lname': {
                        validators: {
                            notEmpty: {
                                message: 'Last name address is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            }
                        }
                    },  
                    'consultant': {
                        validators: {
                            callback: {
								message: 'Consultant is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="conselling"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
                        }
                    },  
                    'booking_date': {
                        validators: {
                            callback: {
								message: 'Booking date is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="conselling"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
                        }
                    },
                    'booking_time': {
                        validators: {
                            callback: {
								message: 'Booking time is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="conselling"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
                        }
                    },
                    'user': {
                        validators: {
                            callback: {
								message: 'Referral is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="referral"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
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
                                    $("#kt_modal_add_user_form").submit();
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
                   // modal.hide();	
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
            initAddUser();
            initializeFields();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddUser.init();
});

$(document).on("click","#conselling",function(){
    if($(this).prop("checked")){
        $(".div_consultant").show();
    }else{
        $(".div_consultant").hide();
    }
});

$(document).on("click","#referral",function(){
    if($(this).prop("checked")){
        $(".div_referral").show();
    }else{
        $(".div_referral").hide();
    }
});

$(document).on("change","#customer",function(){
    var first_name = $('option:selected', this).attr('firstname');
    var last_name = $('option:selected', this).attr('lastname');
    var email = $('option:selected', this).attr('email');
    var phone = $('option:selected', this).attr('phone');
    var address = $('option:selected', this).attr('address');

    $("#firstname").val(first_name);
    $("#lastname").val(last_name);
    $("#lemail").val(email);
    $("#phone").val(phone);
  });


  $(document).on("change","#consultant",function(){
    var appointment_date = $('#booking_date').val();
  var consultant = $(this).val();
  get_appointmentTime(consultant,appointment_date);
  });





  $(document).ready(function(){
	$(".link_edit").click(function(){
  
    var leadid = $(this).attr("leadid");

    //alert(leadid);

		$.ajax({
			method: "POST",
			url: hostUrl + "lms/lead_detail",
			data: { leadid: leadid }
		  })
			.done(function( msg ) {
			  $("#popup_lead_edit").html(msg);
              //KTUsersAddUser.init();
			});

  });

  $(".link_add_update").click(function(){
  
    var leadid = $(this).attr("leadid");

    //alert(leadid);

		$.ajax({
			method: "POST",
			url: hostUrl + "lms/lead_update_form",
			data: { leadid: leadid }
		  })
			.done(function( msg ) {
			  $("#popup_lead_edit").html(msg);
              //KTUsersAddUser.init();
			});

  });

  $(".link_assign").click(function(){
  
    var leadid = $(this).attr("leadid");

    //alert(leadid);

		$.ajax({
			method: "POST",
			url: hostUrl + "lms/assign_appointment_form",
			data: { leadid: leadid }
		  })
			.done(function( msg ) {
			  $("#popup_lead_edit").html(msg);
              //KTUsersAddUser.init();
			});

  });

  $(document).on("click",".link_email",function(){
    var leadid = $(this).attr("leadid");


		$.ajax({
			method: "POST",
			url: hostUrl + "lms/mail_preview",
			data: { leadid: leadid }
		  })
			.done(function( msg ) {
			  $("#popup_lead_edit").html(msg); 
              //KTUsersAddUser.init();
			});

  });
});


function get_appointmentTime(consultant,appointment_date){ 
    $.ajax({
      method: "POST",
      url: hostUrl+'lms/get_appointment_time_list',
      data: { consultant: consultant, appointment_date: appointment_date }
    })
    .done(function( msg ) {
      $("#booking_time").html(msg);
    
    });
  }