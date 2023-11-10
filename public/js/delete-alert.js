var KTSweetAlert2Demo = function () {
  var _init = function _init() {
    $('form[name=delete_form]').submit(function (e) {
    	var id = $(this).attr('id');
    	var delete_title_text = $('#delete_title_text').val();
    	var delete_conf_text = $('#delete_conf_text').val();
    	var cancel_text = $('#cancel_text').val();
    	var icon_url = $('#icon_url').val();
    	
	    Swal.fire({
			title: delete_title_text,
			//icon: 'warning',
			imageUrl: icon_url,
			showCancelButton: true,
			buttonsStyling: false,
			confirmButtonText: delete_conf_text,
			cancelButtonText: cancel_text,
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-secondary"
			}
		}).then(function (result) {
		    if (result.value) {
		    	document.getElementById(id).submit();
		    }
		});
	    e.preventDefault();
    });
  };

  return {
    // Init
    init: function init() {
      _init();
    }
  };
}(); // Class Initialization


jQuery(document).ready(function () {
  KTSweetAlert2Demo.init();
});