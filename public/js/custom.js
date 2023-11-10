$(function() {
	$.fn.datepicker.dates['nl'] = {
        days: ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag", "Zondag"],
        daysShort: ["Zon", "Man", "Din", "Woe", "Don", "Vri", "Zat", "Zon"],
        daysMin: ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za", "Zo"],
        months: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mrt", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
        today: "Vandaag",
        suffix: [],
        meridiem: []
    };
});

function initialize_datepicker() {
	$('.kt-datepicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        orientation: "bottom left",
    });
}

function initialize_file() {
	$('input[type=file]').change(function(){
      	$(this).parent().find('.custom-file-label').text($(this).get(0).files.item(0).name);
   	});
}

function add_more(obj, cont){
	var cloned_ele = $(obj).closest('.'+cont+'-wrapper').find('.'+cont+'-div .'+cont+'-row:first-child').clone();
	cloned_ele.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
	cloned_ele.find('input').prop('value', '');
	cloned_ele.find('select').prop('value', '');
	cloned_ele.find('textarea').prop('value', '');
	cloned_ele.find('label.custom-file-label').removeClass('selected').text('Choose file');
	cloned_ele.find('div.delete_'+cont+' .form-group').html('<a class="btn btn-danger btn-sm" onclick="deletetrow(this, \''+cont+'\');"><i class="flaticon-close"></i></a>');
	cloned_ele.appendTo('.'+cont+'-div');
	initialize_file();
	$('.selectpicker').selectpicker('refresh');
	console.log(cloned_ele);
}

function deletetrow(obj, cont, id=null, type=null) {
	/*type: 
		- module (to delete)
		- file*/
	
	/*if(file_id) {
		var delete_title_text = $('#delete_title_text').val();
    	var delete_conf_text = $('#delete_conf_text').val();
    	var cancel_text = $('#cancel_text').val();
    	
		Swal.fire({
		    title: delete_title_text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: delete_conf_text,
			cancelButtonText: cancel_text
		}).then(function (result) {
		    if (result.value) {
		    	var csrf = $(obj).data('csrf');
		    	$.ajax({
			        url: $(obj).data('url'),
			        type: 'DELETE',
			        data: {
			            "id": file_id,
			            "_token": csrf,
			        },
			        success: function (){
			        	var wrapper = $('.'+cont+'-wrapper').find('.'+cont+'-div');
			        	var child_ele = wrapper.children().length;
			    		if(child_ele > 1) {
			    			$(obj).closest('.'+cont+'-row').remove();
			    		}else {
			    			// reset file upload element
			    			wrapper.children('.'+cont+'-row:first-child').find('input.custom-file-input').prop('value', '');
			    			wrapper.children('.'+cont+'-row:first-child').find('label.custom-file-label').removeClass('selected').html('Choose File');
			    			wrapper.children('.'+cont+'-row:first-child').find('.input-group-append').remove();
			    			// remove delete button
			    			wrapper.children('.'+cont+'-row:first-child').find('.delete_sfiles .form-group').html('');
			    		}
			        }
			    });
		    }
		});
	}*/
	if(type && type=='module') {
		var delete_title_text = $('#delete_title_text').val();
    	var delete_conf_text = $('#delete_conf_text').val();
    	var cancel_text = $('#cancel_text').val();
    	
		Swal.fire({
		    title: delete_title_text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: delete_conf_text,
			cancelButtonText: cancel_text
		}).then(function (result) {
		    if (result.value) {
		    	$.ajax({
			        url: $(obj).data('url'),
			        type: 'DELETE',
			        data: {
			            "id": id,
			            "_token": $(obj).data('csrf'),
			        },
			        success: function (){
			        	var wrapper = $('.'+cont+'-wrapper').find('.'+cont+'-div');
			        	var child_ele = wrapper.children().length;
			    		if(child_ele > 1) {
			    			$(obj).closest('.'+cont+'-row').remove();
			    		}else {
			    			// if only one child, reset elements
			    			reset_cont(cont);
			    		}
			        }
			    });
		    }
		});
	}else{
		var wrapper = $('.'+cont+'-wrapper').find('.'+cont+'-div');
    	var child_ele = wrapper.children().length;
		if(child_ele > 1) {
			$(obj).closest('.'+cont+'-row').remove();
		}else {
			// if only one child, reset elements
			reset_cont(cont);
		}
	}
}

function reset_cont(cont){
	var wrapper = $('.'+cont+'-wrapper');
	var cont = '.'+cont+'-div .'+cont+'-row';
	wrapper.find(cont+':not(:first-child)').remove();
	wrapper.find(cont+' input').prop('value', '');
	wrapper.find(cont+' select').prop('value', '');
	wrapper.find(cont+' textarea').prop('value', '');
	wrapper.find(cont+' .selectpicker').prop('value', '').selectpicker("refresh");;
	wrapper.find(cont+' label.custom-file-label').removeClass('selected').text('Choose file');
}