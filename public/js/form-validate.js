var page = $('#page').val();
var validation;

var KTSubmit = function () {
	var _handleForm = function _handleForm() {
		validation = FormValidation.formValidation(KTUtil.getById('kt_form'), {
	    	plugins: {
                declarative: new FormValidation.plugins.Declarative({
                    html5Input: true,
                }),
                trigger: new FormValidation.plugins.Trigger(),
    	        submitButton: new FormValidation.plugins.SubmitButton(),
    	        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
    	        bootstrap: new FormValidation.plugins.Bootstrap()
            }
	    });
		
		$('button[type=submit]').on('click', function (e) {
			e.preventDefault();
			validation.validate().then(function (status) {
		        if (status == 'Valid') {
	        		$('#kt_form').submit();
		        }else{
		        	KTUtil.scrollTop();
		        	/*swal.fire({
		        		title: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
		        	}).then(function () {
		        		KTUtil.scrollTop();
		        	});*/
		        }
		    });
		});
	};
	return {
		// public functions
	    init: function init() {
	    	_handleForm();
	    }
	};
}(); // Class Initialization
$(function() {
	KTSubmit.init();
});