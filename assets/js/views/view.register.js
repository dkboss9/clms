/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		3.0.0
*/

(function() {

	"use strict";

	var Contact = {

		initialized: false,

		initialize: function() {

			if (this.initialized) return;
			this.initialized = true;

			this.build();
			this.events();

		},

		build: function() {

			// Containers
			var map = $("#googlemaps"),
				contactForm = $("#contactForm");

			// Validations Form Type
			if(contactForm.get(0)) {

				if(contactForm.data("type") == "advanced") {
					this.advancedValidations();
				} else {
					this.basicValidations();
				}

			}

		},

		events: function() {



		},

		advancedValidations: function() {

			var submitButton = $("#contactFormSubmit"),
				contactForm = $("#contactForm");

			submitButton.on("click", function() {
				if(contactForm.valid()) {
					submitButton.button("loading");
				}
			});

			contactForm.validate({
				onkeyup: false,
				onclick: false,
				onfocusout: false,
				rules: {
					fname: {
						required: true
					},
					lname:{
						required: true
					},
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						equalTo: "#password_confirm"
					},
					password_confirm:{
						required: true,
						equalTo: "#password"
					},
					phone: {
						required: true
					},
					mobile: {
						required: true
					},
					address: {
						required: true
					},
					company: {
						required: true
					},
					contactname: {
						required: true
					},
					suburb: {
						required: true
					},
					post_code: {
						required: true
					},
					state:{
						required: true
					},
					country:{
						required: true
					},
					selhow:{
						required: true
					},
					deliver_address:{
						required: true
					},
					deliver_suburb:{
						required: true
					},
					deliver_post_code:{
						required: true
					},
					deliver_state:{
						required: true
					},
					description: {
						required: true
					},
					captcha: {
						required: true,
						captcha: true
					},
					agree: {
						required: true
					}
				},
				highlight: function (element) {
					$(element)
						.parent()
						.removeClass("has-success")
						.addClass("has-error");
				},
				success: function (element) {
					$(element)
						.parent()
						.removeClass("has-error")
						.addClass("has-success")
						.find("label.error")
						.remove();
				}
			});

		},

		basicValidations: function() {

			var contactform = $("#contactForm"),
				url = contactform.attr("action");

			contactform.validate();

		}

	};

	Contact.initialize();

})();