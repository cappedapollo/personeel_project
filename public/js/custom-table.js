$(function() {
	var bInfo = false;
	var dom = '<f<t>p>';
	var pageLength = 10;
	var lengthChange = false;
	var search_text = $('#search_text').val();
	var previous_text = $('#previous_text').val();
	var next_text = $('#next_text').val();
	var page = $('#page').val();
	var no_data_text = $('#no_data_text').val();
	var column_defs = [{
		targets: -1,
		orderable: false,
	}];
	var headerCallback = '';
	
	/* page settings */
	if(page=='UserController_index') {
		var role_code = $('#role_code').val();
		pageLength = 50;
		dom = "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-12'p>>";
		if(role_code != 'manager') {
			headerCallback = function(thead, data, start, end, display) {
				thead.getElementsByTagName('th')[0].innerHTML = `
	            <label class="checkbox checkbox-single">
	                <input type="checkbox" value="" class="group-checkable"/>
	                <span></span>
	            </label>`;
			};
			
			column_defs = [{
				targets: 0,
				width: '30px',
				className: 'dt-left',
				orderable: false,
				render: function(data, type, full, meta) {
					return '<label class="checkbox checkbox-single">'+
	                    '<input type="checkbox" value="'+full[1]+'" class="checkable"/>'+
	                    '<span></span></label>';
				},
			},{
				targets: -1,
				orderable: false,
			}];
		}
	}else if(page=='ArchiveController_show') {
		pageLength = 20;
	}
	
	/* initialize datatable */
	var datatable = $('.kt_datatable').DataTable({
		"lengthChange": lengthChange,
		"bInfo": bInfo,
		"order": [],
		"language": {
		    "search": search_text,
		    "info": "Total _TOTAL_ records",
		    "paginate": {
		        "previous": previous_text,
		        "next": next_text
		    },
		    "emptyTable": no_data_text
		},
		"pageLength": pageLength,
		"columnDefs": column_defs,
		"dom": dom,
		"buttons": [
			{
		        extend: 'csvHtml5',
		        exportOptions: {
		            columns: ':not(.notexport)'
		        }
		    }
		],
		"headerCallback": headerCallback,
	});
	
	/* group checkbox logic */
	datatable.on('change', '.group-checkable', function() {
		var set = $(this).closest('table').find('td:first-child .checkable');
		var checked = $(this).is(':checked');

		$(set).each(function() {
			if (checked) {
				$(this).prop('checked', true);
				$(this).closest('tr').addClass('active');
			}
			else {
				$(this).prop('checked', false);
				$(this).closest('tr').removeClass('active');
			}
		});
		
		if(page=='UserController_index') {
			toggleUserAction(set);
		}
	});

	datatable.on('change', 'tbody tr .checkbox', function() {
		$(this).parents('tr').toggleClass('active');
		var set = $(this).closest('table').find('td:first-child .checkable');
		if(page=='UserController_index') {
			toggleUserAction(set);
		}
	});
	/* end: group checkbox logic */
	
	/* actions */
	if(page == 'UserController_index') {
		//setStatus(datatable);
		$('select[name=manager_id]').on('change', function(e) {
			e.preventDefault();
			setUSerSearch(datatable);
		});
		$('select[name=user_role_id]').on('change', function(e) {
			e.preventDefault();
			setUSerSearch(datatable);
		});
	}
});
	
function toggleUserAction(checkboxes) {
	checked_count = 0;
	var checked_ids = [];
	checked_count = checkboxes.filter(':checked').length;
	var btn_text = '', btn = '';
	$.each(checkboxes.filter(':checked'), function() {
		checked_ids.push($(this).val());
    });
	
	$('.dataTables_wrapper').find('div.row:first-child').find('div.col-sm-12:first-child').html('');
	
	if(checked_count > 0) {
		btn_text = $('#mng_btn_text').val();
		btn = '<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#link-mng-modal">'+btn_text+'</button>';
		
		$('.modal #link-mng-form').find('input[name=user_ids]').val(checked_ids.join());
		$('.dataTables_wrapper').find('div.row:first-child').find('div.col-sm-12:first-child').append(btn);
	}
}

function setUSerSearch(datatable) {
	var params = {};
	$('.datatable-input').each(function() {
		var tagname = $(this).prop("tagName");
		var i = $(this).data('col-index');
		var value = '';
		var key = '';
		if(tagname=='SELECT') {
			key = $('option:selected', this).val();
			value = $('option:selected', this).text();
			if(key == '') {
				value = '';
			}
		}
		
		if (params[i]) {
			params[i] += '|' + value;
		} else {
			params[i] = value;
		}
	});
	
	$.each(params, function(i, val) {
		console.log(val);
		/* apply search params to datatable */
		datatable.column(i).search(val ? val : '', false, true, true);
	});
	datatable.table().draw();
}