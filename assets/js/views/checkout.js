/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		3.0.0
*/
var contactForm = '';
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
				contactForm = $("#proceed_cart");

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

			var submitButton = $("#cartFormSubmit"),
				contactForm = $("#proceed_cart");

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
					txtbillingaddress: {
						required: true
					},
					txtbillingsuburb: {
						required: true
					},
					txtbillingpostalcode: {
						required: true
					},
					selbillingstate:{
						required: true
					},					
					txtdeliveryaddress: {
						required: true
					},
					txtdeliverysuburb: {
						required: true
					},
					txtdeliverypostalcode: {
						required: true
					},
					seldeliverystate:{
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

			var contactform = $("#proceed_cart"),
				url = contactform.attr("action");

			contactform.validate();

		}

	};

	Contact.initialize();

})();