"use strict";

// Class definition
var KTModalCreateProjectBudget = function () {
	// Variables
	var nextButton;
	var previousButton;
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
					
					'listening': {
						validators: {
							callback: {
								message: 'Listening is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_ielts"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'Writing': {
						validators: {
							callback: {
								message: 'Writing is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_ielts"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'reading': {
						validators: {
							callback: {
								message: 'Reading is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_ielts"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'speaking': {
						validators: {
							callback: {
								message: 'Speaking is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_ielts"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'txt_toefl': {
						validators: {
							callback: {
								message: 'Toefl is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_toefl"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'txt_pte': {
						validators: {
							callback: {
								message: 'Toefl is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_pte"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'txt_sat': {
						validators: {
							callback: {
								message: 'Toefl is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_sat"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'txt_gre': {
						validators: {
							callback: {
								message: 'Toefl is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_gre"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					},
					'txt_gmat': {
						validators: {
							callback: {
								message: 'Toefl is required',
								callback: function(input) {
									const selectedCheckbox = form.querySelector('[name="have_gmat"]:checked');
									const flag = selectedCheckbox ? selectedCheckbox.value : '';
									return (flag !== '' && (input.value === '' || input.value === '0')) ? false : true;
										
								}
							}
						}
					}
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

		$("#have_ielts").click(function(){
			if($(this).prop("checked"))
			$("#div_ielts").show();
			else
			$("#div_ielts").hide();
		});

		$("#have_toefl").click(function(){
			if($(this).prop("checked"))
			$("#div_toefl").show();
			else
			$("#div_toefl").hide();
		});

		$("#have_pte").click(function(){
			if($(this).prop("checked"))
			$("#div_pte").show();
			else
			$("#div_pte").hide();
		});

		$("#have_sat").click(function(){
			if($(this).prop("checked"))
			$("#div_sat").show();
			else
			$("#div_sat").hide();
		});

		$("#have_gre").click(function(){
			if($(this).prop("checked"))
			$("#div_gre").show();
			else
			$("#div_gre").hide();
		});

		$("#have_gmat").click(function(){
			if($(this).prop("checked"))
			$("#div_gmat").show();
			else
			$("#div_gmat").hide();
		});

		// Revalidate on change
		// KTDialer.getInstance(form.querySelector('#kt_modal_create_project_budget_setup')).on('kt.dialer.changed', function() {
		// 	// Revalidate the field when an option is chosen
        //     validator.revalidateField('budget_setup');
		// });
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
						}, 1500);   						
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

		previousButton.addEventListener('click', function () {
			stepper.goPrevious();
		});
	}

	return {
		// Public functions
		init: function () {
			form = KTModalCreateProject.getForm();
			stepper = KTModalCreateProject.getStepperObj();
			nextButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="budget-next"]');
			previousButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="budget-previous"]');

			initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProjectBudget = module.exports = KTModalCreateProjectBudget;
}
