{{-- Nav --}}
<ul class="navi navi-hover py-4">
    {{-- Item --}}
    @php
	$path = '';
	if(!in_array(Request::path(), array('en', 'du'))) {
    	$pos = strpos(Request::path(), '/');
   		$path = substr(Request::path(), $pos+1);
	}
    @endphp
    <li class="navi-item">
        <a href="{{url('en/'.$path)}}" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset(config('layout.resources.lang-flag-en')) }}" alt=""/>
            </span>
            <span class="navi-text">English</span>
        </a>
    </li>

    {{-- Item --}}
    <li class="navi-item active">
        <a href="{{url('du/'.$path)}}" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset(config('layout.resources.lang-flag-du')) }}" alt=""/>
            </span>
            <span class="navi-text">Nederlands</span>
        </a>
    </li>
</ul>
