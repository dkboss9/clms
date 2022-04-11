"use strict";

// Class definition
var KTModalCreateProject = function () {
	// Private variables
	var stepper;
	var stepperObj;
	var form;	

	// Private functions
	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);
	}

	return {
		// Public functions
		init: function () {
			stepper = document.querySelector('#kt_modal_create_project_stepper');
			form = document.querySelector('#kt_modal_create_project_form');

			initStepper();
		},

		getStepperObj: function () {
			return stepperObj;
		},

		getStepper: function () {
			return stepper;
		},
		
		getForm: function () {
			return form;
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	if (!document.querySelector('#kt_modal_create_project')) {
		return;
	}

	KTModalCreateProject.init();
	KTModalCreateProjectType.init();
	KTModalCreateProjectBudget.init();
	KTModalCreateProjectSettings.init();
	KTModalCreateProjectTeam.init();
	KTModalCreateProjectTargets.init();
//	KTModalCreateProjectFiles.init();
//	KTModalCreateProjectComplete.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProject = module.exports = KTModalCreateProject;
}


$(document).ready(function(){
	$(".link_edit").click(function(){
		var studentid = $(this).attr("studentid");

		$.ajax({
			method: "POST",
			url: hostUrl + "student/student_detail",
			data: { studentid: studentid }
		  })
			.done(function( msg ) {
			  $("#popup_edit").html(msg);
			  KTModalCreateProject.init();
			KTModalCreateProjectType.init();
			KTModalCreateProjectBudget.init();
			KTModalCreateProjectSettings.init();
			KTModalCreateProjectTeam.init();
			KTModalCreateProjectTargets.init();
			});
	});

	$(document).on("click",".link_add_client",function(){
		var leadid = $(this).attr("leadid");

		$.ajax({
			method: "POST",
			url: hostUrl + "lms/ajax_lead_detail",
			data: { leadid: leadid }
		  })
			.done(function( msg ) {
				const response = JSON.parse(msg);
				console.log(response);
				$("#fname").val(response.lead_name);
				$("#lname").val(response.lead_lname);
				$("#email").val(response.email);
			//	alert(response.phone_number);
				$("#phone_number").val(response.phone_number);
			});
	});
});