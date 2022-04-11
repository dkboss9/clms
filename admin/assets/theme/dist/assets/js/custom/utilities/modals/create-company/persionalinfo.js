"use strict";

// Class definition
var KTModalCreateProjectType = function () {
	// Variables
	var nextButton;
	var validator;
	var form;
	var stepper;

	// Private functions
	var initValidation = function() {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'fname': {
						validators: {
							notEmpty: {
								message: 'First name is required'
							}
						}
					},
					'lname': {
						validators: {
							notEmpty: {
								message: 'Last name is required'
							}
						}
					},
					'email': {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							remote: {
								message: 'The Email is not available',
								method: 'POST',
								url: hostUrl+'student/checkEmail',
							},
						}
					},
					'password': {
						validators: {
							notEmpty: {
								message: 'Mobile is required'
							}
						}
					},
					'dob': {
						validators: {
							notEmpty: {
								message: 'DOB is required'
							}
						}
					},
					'passport_no': {
						validators: {
							notEmpty: {
								message: 'Passport is required'
							}
						}
					},
					'sex': {
						validators: {
							notEmpty: {
								message: 'Sex is required'
							}
						}
					},
					'address': {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					'is_married': {
						validators: {
							notEmpty: {
								message: 'Marrital status is required'
							}
						}
					},
					'about_us': {
						validators: {
							notEmpty: {
								message: 'About us is required'
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
	}

	var handleForm = function() {
		nextButton.addEventListener('click', function (e) {
			// Prevent default button action
			e.preventDefault();

			// Disable button to avoid multiple click 
			nextButton.disabled = true;

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');
					e.preventDefault();

					if (status == 'Valid') {
						// Show loading indication
						nextButton.setAttribute('data-kt-indicator', 'on');

						// Simulate form submission
						setTimeout(function() {
							// Simulate form submission
							nextButton.removeAttribute('data-kt-indicator');
							
							// Enable button
							nextButton.disabled = false;
							
							// Go to next step
							stepper.goNext();
						}, 1000);   						
					} else {
						// Enable button
						nextButton.disabled = false;
						
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
	}

	return {
		// Public functions
		init: function () {
			form = KTModalCreateProject.getForm();
			stepper = KTModalCreateProject.getStepperObj();
			nextButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="type-next"]');

			initValidation();
			handleForm();

			var releaseDate = $(form.querySelector('[name="dob"]'));
releaseDate.flatpickr({
	enableTime: true,
	dateFormat: "d-m-Y",
});
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProjectType = module.exports = KTModalCreateProjectType;
}

