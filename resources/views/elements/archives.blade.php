<div class="col-lg-12">
    <div class="card card-custom">
    	<div class="card-body">
    		<div class="table-responsive">
        		<table class="table table-hover kt_datatable">
        			<thead>
        				<tr>
        					<th>{{ trans_choice('menu.review_type', 1) }}</th>
        					<th>{{ __('form.label.year') }}</th>
        					<th>{{ __('form.label.created') }}</th>
        					<th>{{ __('form.label.status') }}</th>
        					<th>{{ __('form.label.status').' '.__('form.label.timestamp') }}</th>
        					@if(in_array($role_code, array('admin', 'employee', 'manager')))
        					<th>{{ trans_choice('form.label.action', 2) }}</th>
        					@endif
        				</tr>
        			</thead>
        			<tbody>
        				@foreach ($archives as $archive)
        					@php
        					//$file_url = getLinkFromBucket($archive->file->file_key);
        					$file_key = ($archive->file) ? urlencode($archive->file->file_key) : '';
        					
        					$review_type = '-';
        					if ($archive->form_data) {
        						$_review_type = company_review_type($archive->form_data->review_type->number);
        						$review_type = $_review_type->name;
        					}
        					@endphp
            				<tr>
            					<td><a href="{{ route('files.show', ['locale' => app()->getLocale(), 'file' => $file_key]) }}" target="_blank">{{ $review_type }}</a></td>
            					<td>{{ ($archive->form_data) ? $archive->form_data->year : '-' }}</td>
            					<td>{{ $archive->created_at }}</td>
            					<td>{{ ($archive->status) ? $status[$archive->status] : '-' }}</td>
            					<td>{{ ($archive->status == 'reviewed') ? $archive->reviewed_on : '-' }}</td>
            					@if(in_array($role_code, array('admin', 'employee', 'manager')))
            					<td>
            						@if(in_array($role_code, array('admin')))
                						@if(in_array($role_code, array('admin')) && ($archive->status == 'pending'))
                						<a href="{{ route('archives.supdate', ['archive' => $archive->id, 'locale'=>app()->getLocale(), 'status'=>'reviewed']) }}" class="btn btn-icon btn-xs btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.approve') }}"><i class="flaticon2-check-mark"></i></a>
                						@endif
                						<!-- Delete -->
                                    	<form id="delete_form_{{ $archive->id }}" name="delete_form" action="{{ route('archives.destroy', ['archive' => $archive->id, 'locale'=>app()->getLocale()]) }}" method="post" class="btn btn-icon btn-xs">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-icon btn-xs btn-outline-danger" type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('form.label.delete_title', ['title'=>trans_choice('form.label.form', 1)]) }}"><i class="flaticon-delete"></i></button>
                                        </form>
                                    	<!-- End: Delete -->
                                	@endif
                                	
                                	{{-- @elseif(in_array($role_code, array('employee'))) --}}
                                		@if($archive->status == 'employee' && $archive->user_id==Auth::id())
                                		<button class="btn btn-icon btn-xs btn-outline-info" 
                                			data-toggle="modal" 
                                			data-target="#status-modal" 
                                			data-review-type="{{ $archive->form_data ? $archive->form_data->review_type->name : '-' }}" 
                                			data-year="{{ ($archive->form_data) ? $archive->form_data->year : '-' }}" 
                                			data-id="{{ $archive->id }}"
                                			data-url = "{{ route('archives.update', ['archive' => $archive->id, 'locale'=>app()->getLocale()]) }}">
                                			
                                			<i class="flaticon2-check-mark"></i>
                            			</button>
                                		@endif
                                	{{-- @endif --}}
        						</td>
        						@endif
            				</tr>
        				@endforeach
        			</tbody>
        		</table>
        	</div>
    	</div>
    </div>
</div>

<!-- start: Modal to add final -->
<div class="modal fade" id="status-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="status-form" class="form" method="POST" action="">
        	@csrf
        	@method('PATCH')
        	<input type="hidden" name="status" value="pending"/>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status-modal-label"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                		<div class="radio-list">
                            <label class="radio read-content">
                                <input type="radio" name="content" value="read" required="required"/>
                                <span></span>
                                <div>{{ __('form.label.read_content') }}</div>
                            </label>
                            <label class="radio note-content">
                                <input type="radio" name="content" value="note" required="required"/>
                                <span></span>
                                <div>{{ __('form.label.note_content') }}</div>
                            </label>
                        </div>
            		</div>
            		<div class="form-group">
						<label class="font-weight-bold">{{ __('form.label.enter_full_name') }}: *</label>
            			<input type="text" class="form-control" name="full_name" required="required"/>
            		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">{{__('form.label.close')}}</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">{{__('form.label.submit')}}</button>
                </div>
            </div>
    	</form>
    </div>
</div>
<!-- end: Modal to add final -->
@push('scripts')
<script type="text/javascript">
$(function() {
	$('#status-modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var review_type = button.data('review-type');
		var year = button.data('year');
		var url = button.data('url');
		
		$('#status-modal .modal-title').html(review_type+' '+year);
		var read_content = "{{ __('form.label.read_content') }}";
		var note_content = "{{ __('form.label.note_content') }}";

		$('#status-modal label.read-content div').html(read_content.replace(/:review_type/g, review_type));
		$('#status-modal label.note-content div').html(note_content.replace(/:review_type/g, review_type));
		$('#status-modal').find('#status-form').attr('action', url);
		$('#status-modal').find('input[name="full_name"]').val('');
		$('#status-modal').find('input[type="radio"]').prop('checked', false);
	});
});
</script>
@endpush