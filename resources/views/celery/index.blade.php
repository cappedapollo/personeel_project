@extends('layout.app')
@push('styles')
@foreach(config('layout.resources.index_css') as $style)
    <link href="{{asset($style)}}" rel="stylesheet" type="text/css"/>
@endforeach
@endpush
@push('scripts')
@foreach(config('layout.resources.index_js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
@endforeach
@endpush
@section('content')
<div class="card card-custom">
    <div class="position-absolute top-0 bottom-0 left-0 right-0 d-none justify-content-center align-items-center" id="loader" style="z-index: 100; background: rgba(255, 255, 255, 0.5)">
        Processing...
    </div>
	<div class="card-body">
        <div class="row mb-5 align-items-end">
			<div class="col-lg-5">
				<label class="font-weight-bold">
					Contexts:
					<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="Please select context.">
    					<i class="fas fa-info-circle"></i>
    				</a>
				</label>
				<select name="context_id" class="form-control datatable-input"  data-col-index="1" onchange="GetEmployers()">
                   
    			</select>
			</div>

            <div class="col-lg-5">
				<label class="font-weight-bold">
					Employers:
					<a href="#" class="btn btn-icon btn-xs btn-light-primary btn-circle" data-toggle="tooltip" data-placement="right" title="Please select employer.">
    					<i class="fas fa-info-circle"></i>
    				</a>
				</label>
				<select name="employer_id" class="form-control datatable-input"  data-col-index="2" onchange="GetEmployees()">
                   
    			</select>
			</div>
            <div class="col-lg-2">
                <button class="btn btn-primary btn-block" onclick="SaveEmployees()">Save</button>
            </div>
		</div>

        <div class="table-responsive">
    		<table class="table table-hover" id="employee_table">
    		</table>
    	</div>
	</div>
</div>
@endsection

@push('scripts')
<script>

    const ACCESS_TOKEN = '{{ $access_token }}';
    const BASE_URL = '{{ url(app()->getLocale()) }}';
    const CONTEXT_EL = $("[name=context_id]");
    const EMPOYER_EL = $("[name=employer_id]");
    const LOADER_EL = $("#loader");
    let DataTableEl = null;
    let tableData = [];

    function GetContexts() {
        
		$.ajax({
            beforeSend: function() {
                LOADER_EL.removeClass("d-none").addClass("d-flex");
                CONTEXT_EL.prop("disabled", true)
            },
			url: BASE_URL + '/celery/contexts?access_token=' + ACCESS_TOKEN,
			method: 'GET',
			success: function(data) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                CONTEXT_EL.prop("disabled", false)
                CONTEXT_EL.html("");
                if(data && data.length > 0) {
                    data.forEach((item) => {
                        CONTEXT_EL.append(
                            '<option value="' + item.id + '">' + item.id + '</option>'
                        );
                    })
                }
                CONTEXT_EL.trigger("change");
			},
			error: function(xhr, status, error) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                CONTEXT_EL.prop("disabled", false)
				console.error(error);
			}
		});
	}

	function GetEmployers() {
		const CONTEXT_ID = CONTEXT_EL.val();
		$.ajax({
            beforeSend: function() {
                LOADER_EL.removeClass("d-none").addClass("d-flex");
                EMPOYER_EL.prop("disabled", true)
            },
			url: BASE_URL + '/celery/employers?access_token=' + ACCESS_TOKEN + '&context_id=' + CONTEXT_ID,
			method: 'GET',
			success: function(data) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                EMPOYER_EL.prop("disabled", false)
				EMPOYER_EL.html("");
                if(data && data.length > 0) {
                    data.forEach((item) => {
                        EMPOYER_EL.append(
                            '<option value="' + item.id + '">' + item.company_name + '(' + item.official_name + ')' + '</option>'
                        );
                    })
                }
                EMPOYER_EL.trigger("change");
			},
			error: function(xhr, status, error) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                EMPOYER_EL.prop("disabled", false)
				console.error(error);
			}
		});
	}

    function GetEmployees() {
		const CONTEXT_ID = CONTEXT_EL.val();
		const EMPLOYER_ID = EMPOYER_EL.val();
		$.ajax({
            beforeSend: () => {
                LOADER_EL.removeClass("d-none").addClass("d-flex");
            },
			url: BASE_URL + '/celery/employees?access_token=' + ACCESS_TOKEN + '&context_id=' + CONTEXT_ID + '&employer_id=' + EMPLOYER_ID,
			method: 'GET',
			success: function(data) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                tableData = data.filter(({contact: {email}})=>!!email);
                DataTableEl.clear();
                if(tableData && tableData.length > 0) {
                    data = tableData.map(({
                        first_name,
                        surname,
                        position,
                    })=> ({
                        first_name,
                        surname,
                        position,
                    }));
                    
                } else {
                    data = [];
                }
                DataTableEl.rows.add(data);
                DataTableEl.draw();
                // if(data.length > 0) SaveEmployees();
			},
			error: function(xhr, status, error) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
				console.error(error);
			}
		});
	}

    function SaveEmployees() {
        if(tableData.length === 0) {
            swal.fire({
                text: "There is no data to import.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            });
            return;
        };
        $.ajax({
            beforeSend: () => {
                LOADER_EL.removeClass("d-none").addClass("d-flex");
            },
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}',
                'Content-Type': 'application/json'
            },
			url: BASE_URL + '/celery/save_employees',
            method: 'POST',
            data: JSON.stringify({
                employees: tableData
            }),
			success: function(data) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
                swal.fire({
                    text: "Import the employees from celery successfully.",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
			},
			error: function(xhr, status, error) {
                LOADER_EL.removeClass("d-flex").addClass("d-none");
				swal.fire({
                    text: "Sorry, looks like there are some errors detected, please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
			}
		});
    }

    $(function() {
        DataTableEl = $('#employee_table').DataTable({
            "columns": [
                { "title": "First Name", "data": "first_name" },
                { "title": "Last Name", "data": "surname" },
                { "title": "Position", "data": "position" }
            ]
        });
        GetContexts()
    });
</script>
@endpush