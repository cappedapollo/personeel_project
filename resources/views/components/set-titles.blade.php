<input type="hidden" id="page" value="{{ $page }}">
<input type="hidden" id="delete_title_text" value="{{ __('messages.delete_title', ['module'=>strtolower($module)]) }}">
<input type="hidden" id="delete_conf_text" value="{{ __('messages.delete_conf') }}">
<input type="hidden" id="cancel_text" value="{{ __('form.label.cancel') }}">
<input type="hidden" id="search_text" value="{{ __('form.label.search') }}">
<input type="hidden" id="previous_text" value="{{ __('form.label.previous') }}">
<input type="hidden" id="next_text" value="{{ __('form.label.next') }}">
<input type="hidden" id="no_data_text" value="{{__('messages.no_data')}}">
<input type="hidden" id="icon_url" value="{{ asset(config('layout.resources.popup_icon')) }}">