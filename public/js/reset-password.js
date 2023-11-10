var KTLogin = function () {
	var _handleResetForm = function _handleResetForm() {
		var form = document.getElementById('kt_login_reset_form');
		var validation; // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
	    validation = FormValidation.formValidation(KTUtil.getById('kt_login_reset_form'), {
	      fields: {
	        email: {
	          validators: {
	            notEmpty: {
	              message: 'Email is required'
	            }
	          }
	        },
	        password: {
	          validators: {
	            notEmpty: {
	              message: 'Password is required'
	            },
	            regexp: {
                    regexp: /^(?=.*[A-Z])(?=.*\W).{8,}$/,
                    message: 'Password should contain minimum 8 characters with minimimum 1 Capital and 1 symbol',
                }
	          }
	        },
	        confirm_password: {
	          validators: {
	            notEmpty: {
	              message: 'Confirm Password is required'
	            },
	            identical: {
                    compare: function() {
                        return form.querySelector('[name="password"]').value;
                    },
                    message: 'The password and its confirm are not the same'
                }
	          }
	        }
	      },
	      plugins: {
	        trigger: new FormValidation.plugins.Trigger(),
	        submitButton: new FormValidation.plugins.SubmitButton(),
	        defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
	        bootstrap: new FormValidation.plugins.Bootstrap()
	      }
	    });
	    $('#kt_login_reset_submit').on('click', function (e) {
	      e.preventDefault();
	      validation.validate().then(function (status) {
	        if (status == 'Valid') {
	          /*swal.fire({
	            text: "All is cool! Now you submit this form",
	            icon: "success",
	            buttonsStyling: false,
	            confirmButtonText: "Ok, got it!",
	            customClass: {
	              confirmButton: "btn font-weight-bold btn-light-primary"
	            }
	          }).then(function () {
	            KTUtil.scrollTop();
	          });*/
	        } else {
	          swal.fire({
	            text: "Sorry, looks like there are some errors detected, please try again.",
	            icon: "error",
	            buttonsStyling: false,
	            confirmButtonText: "Ok, got it!",
	            customClass: {
	              confirmButton: "btn font-weight-bold btn-light-primary"
	            }
	          }).then(function () {
	            KTUtil.scrollTop();
	          });
	        }
	      });
	    });
	  };

	return {
		// public functions
	    init: function init() {
	    	_handleResetForm();
	    }
	};
}(); // Class Initialization
$(function() {
	KTLogin.init();
});