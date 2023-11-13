@php
list($controller, $action) = getActionName();
$role_code = Auth::user()->user_role->role_code;
@endphp
<!-- dashboard -->
<li class="menu-item {{(($controller=='UserController') && $action=='dashboard') ? 'menu-item-active' : ''}}" aria-haspopup="true">
	<a href="{{ config('app.url').app()->getLocale() }}" class="menu-link">
		<i class="menu-icon flaticon-layer icon-lg"></i>
		<span class="menu-text">{{ __('menu.dashboard') }}</span>
	</a>
</li>

<!-- companies -->
@if(in_array($role_code, array('superadmin')))
<li class="menu-item {{(($controller=='CompanyController') && $action=='index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
	<a href="{{ url(app()->getLocale().'/companies') }}" class="menu-link">
		<i class="menu-icon fas fa-building icon-lg"></i>
		<span class="menu-text">{{ trans_choice('menu.company', 2) }}</span>
	</a>
</li>
@endif

@if(in_array($role_code, array('admin', 'manager')))
    <!-- Overview -->
    <li class="menu-item {{(($controller=='UserController') && $action=='index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
    	<a href="{{ url(app()->getLocale().'/users') }}" class="menu-link">
    		<i class="menu-icon flaticon-users-1 icon-lg"></i>
    		<span class="menu-text">{{ __('menu.list') }}</span>
    	</a>
    </li>
    
    <!-- My Employees -->
    <li class="menu-item {{(($controller=='UserController') && $action=='employees') ? 'menu-item-active' : ''}}" aria-haspopup="true">
    	<a href="{{ url(app()->getLocale().'/users/employees') }}" class="menu-link">
    		<i class="menu-icon flaticon-users-1 icon-lg"></i>
    		<span class="menu-text">{{ __('form.label.my').' '.trans_choice('menu.user', 2) }}</span>
    	</a>
    </li>
    
    @if(in_array($role_code, array('admin')))
    <!-- Employees -->
    <li class="menu-item menu-item-submenu {{ (($controller=='UserController' && $action=='create') || ($controller=='UserImportController' && $action=='index'))? 'menu-item-here menu-item-open' : ''}}" aria-haspopup="true" data-menu-toggle="hover">
    	<a href="javascript:;" class="menu-link menu-toggle">
    		<i class="menu-icon flaticon-users-1 icon-lg"></i>
    		<span class="menu-text">{{ __('form.label.new').' '.trans_choice('menu.user', 2) }}</span>
    		<i class="menu-arrow"></i>
    	</a>
    	<div class="menu-submenu">
    		<i class="menu-arrow"></i>
    		<ul class="menu-subnav">
    			<li class="menu-item {{(($controller=='UserController') && $action=='create') ? 'menu-item-active' : ''}}" aria-haspopup="true">
    				<a href="{{ url(app()->getLocale().'/users/create') }}" class="menu-link">
    					<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('menu.add') }}</span>
    				</a>
    			</li>
    			<li class="menu-item {{(($controller=='UserImportController') && $action=='index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
    				<a href="{{ url(app()->getLocale().'/users/import') }}" class="menu-link">
    					<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('menu.import') }}</span>
    				</a>
    			</li>
    		</ul>
    	</div>
    </li>
    @endif
    
    <!-- other -->
    <li class="menu-item menu-item-submenu {{ (($controller=='LogController' && $action=='index') || ($controller=='UserController' && $action=='support') || ($controller=='CategoryController' && $action=='index')) ? 'menu-item-here menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
    	<a href="javascript:;" class="menu-link menu-toggle">
    		<i class="menu-icon flaticon2-list-1 icon-lg"></i>
    		<span class="menu-text">{{ trans_choice('menu.other', 1) }}</span>
    		<i class="menu-arrow"></i>
    	</a>
    	<div class="menu-submenu">
    		<i class="menu-arrow"></i>
    		<ul class="menu-subnav">
    			<li class="menu-item {{ (($controller=='LogController') && $action=='index') ? 'menu-item-active' : '' }}" aria-haspopup="true">
    				<a href="{{ url(app()->getLocale().'/logs') }}" class="menu-link">
    					<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ trans_choice('menu.log', 2) }}</span>
    				</a>
    			</li>
    			@if(in_array($role_code, array('admin')))
    			<li class="menu-item {{ (($controller=='UserController') && $action=='support') ? 'menu-item-active' : ''}}" aria-haspopup="true">
    				<a href="{{ url(app()->getLocale().'/support') }}" class="menu-link">
    					<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ trans_choice('menu.suggestion', 2) }}</span>
    				</a>
    			</li>
    			@endif
    			<!-- competencies -->
                <li class="menu-item {{ (($controller=='CategoryController') && $action=='index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                	<a href="{{ url(app()->getLocale().'/categories') }}" class="menu-link">
                		<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('form.label.competencies') }}</span>
                	</a>
                </li>
                <!-- support -->
                @if(in_array($role_code, array('manager')))
                <li class="menu-item" aria-haspopup="true">
                	<a href="{{ url(app()->getLocale().'/support_pdf') }}" class="menu-link">
                		<i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('menu.support') }}</span>
                	</a>
                </li>
                @endif
    		</ul>
    	</div>
    </li>
@endif

<!-- support -->
@if(in_array($role_code, array('employee')))
<li class="menu-item" aria-haspopup="true">
	<a href="{{ url(app()->getLocale().'/support_pdf') }}" class="menu-link">
		<i class="menu-icon flaticon-questions-circular-button icon-lg"></i>
		<span class="menu-text">{{ __('menu.support') }}</span>
	</a>
</li>
@endif

@if(in_array($role_code, array('admin')))
<!-- support/contact -->
<li class="menu-item" aria-haspopup="true">
	<span class="menu-link">
		<a href="{{ '//'.config('app.main_url').'/support' }}" class="btn btn-light-warning w-100 text-left" target="_blank">
    		<i class="flaticon-chat icon-lg"></i> {{ __('form.label.support') }}
		</a>
	</span>
</li>
@endif