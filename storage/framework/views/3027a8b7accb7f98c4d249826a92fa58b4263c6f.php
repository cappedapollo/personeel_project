<?php
$today = ($lang=='en') ? date('M d, Y') : date('d M Y');
$_today = date('Y-m-d');
$last_date_year = date('Y-m-d', strtotime('Dec 31'));
$d1 = new DateTime($last_date_year); 
$d2 = new DateTime($_today);                                  
$months = $d2->diff($d1); 
$remaining_months = (($months->y) * 12) + ($months->m);
$remaining_days = $months->days;
$remaining_weeks = ceil($remaining_days / 7);

/* $employee_count = isset($user_counts['employee']) ? $user_counts['employee'] : 0;
$employee_count += isset($user_counts['admin']) ? $user_counts['admin'] : 0; */

# count employees = Total users - Admins - Managers
/* $company_admins = $company_managers = $company_employees = 0;
$company_users = Auth::user()->company_user->company->company_user;
foreach($company_users as $company_user) {
	if($company_user->user) {
    	if($company_user->user->user_role->role_code == 'admin') {
    		$company_admins++;
    	}
    	if($company_user->user->user_role->role_code == 'manager') {
    		$company_managers++;
    	}
    	if($company_user->user->user_role->role_code == 'employee') {
    		$company_employees++;
    	}
	}
}
$total_users = $company_users->count();
$employee_count = $total_users - $company_admins - $company_managers; */

$employee_count = isset($user_counts['employee']) ? $user_counts['employee'] : 0;
?>
<div class="col-lg-6 col-xxl-4">
	<!--begin::Mixed Widget 1-->
	<div class="card card-custom bg-gray-100 card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header bg-yellow">
			<h3 class="card-title font-weight-bolder text-bblack"><?php echo e(__('form.label.workforce')); ?></h3>
			<div class="card-toolbar">
				<a href="<?php echo e(url(app()->getLocale().'/users')); ?>" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon">
					<i class="fas fa-external-link-alt text-bblack"></i>
				</a>
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body p-0 position-relative overflow-hidden">
			<!--begin::Chart-->
			<div id="" class="card-rounded-bottom bg-yellow" style="height: 200px; min-height: 200px;"><div id="apexchartsa57x7vnn" class="apexcharts-canvas apexchartsa57x7vnn apexcharts-theme-light" style="width: 385px; height: 200px;"><svg id="SvgjsSvg1265" width="385" height="200" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent none repeat scroll 0% 0%;"><g id="SvgjsG1267" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1266"><clipPath id="gridRectMaska57x7vnn"><rect id="SvgjsRect1270" width="392" height="203" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMaska57x7vnn"><rect id="SvgjsRect1271" width="389" height="204" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter1277" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1278" flood-color="#cdb8a0" flood-opacity="0.5" result="SvgjsFeFlood1278Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1279" in="SvgjsFeFlood1278Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1279Out"></feComposite><feOffset id="SvgjsFeOffset1280" dx="0" dy="5" result="SvgjsFeOffset1280Out" in="SvgjsFeComposite1279Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1281" stdDeviation="3 " result="SvgjsFeGaussianBlur1281Out" in="SvgjsFeOffset1280Out"></feGaussianBlur><feBlend id="SvgjsFeBlend1282" in="SourceGraphic" in2="SvgjsFeGaussianBlur1281Out" mode="normal" result="SvgjsFeBlend1282Out"></feBlend></filter><filter id="SvgjsFilter1284" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1285" flood-color="#cdb8a0" flood-opacity="0.5" result="SvgjsFeFlood1285Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1286" in="SvgjsFeFlood1285Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1286Out"></feComposite><feOffset id="SvgjsFeOffset1287" dx="0" dy="5" result="SvgjsFeOffset1287Out" in="SvgjsFeComposite1286Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1288" stdDeviation="3 " result="SvgjsFeGaussianBlur1288Out" in="SvgjsFeOffset1287Out"></feGaussianBlur><feBlend id="SvgjsFeBlend1289" in="SourceGraphic" in2="SvgjsFeGaussianBlur1288Out" mode="normal" result="SvgjsFeBlend1289Out"></feBlend></filter></defs><g id="SvgjsG1290" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1291" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1300" class="apexcharts-grid"><g id="SvgjsG1301" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1303" x1="0" y1="0" x2="385" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1304" x1="0" y1="20" x2="385" y2="20" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1305" x1="0" y1="40" x2="385" y2="40" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1306" x1="0" y1="60" x2="385" y2="60" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1307" x1="0" y1="80" x2="385" y2="80" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1308" x1="0" y1="100" x2="385" y2="100" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1309" x1="0" y1="120" x2="385" y2="120" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1310" x1="0" y1="140" x2="385" y2="140" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1311" x1="0" y1="160" x2="385" y2="160" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1312" x1="0" y1="180" x2="385" y2="180" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1313" x1="0" y1="200" x2="385" y2="200" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG1302" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1315" x1="0" y1="200" x2="385" y2="200" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1314" x1="0" y1="1" x2="0" y2="200" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1272" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1273" class="apexcharts-series" seriesName="NetxProfit" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1276" d="M 0 200L 0 125C 22.458333333333332 125 41.70833333333334 87.5 64.16666666666667 87.5C 86.625 87.5 105.87500000000001 120 128.33333333333334 120C 150.79166666666669 120 170.04166666666669 25 192.5 25C 214.95833333333334 25 234.20833333333334 100 256.6666666666667 100C 279.125 100 298.375 100 320.8333333333333 100C 343.29166666666663 100 362.5416666666667 100 385 100C 385 100 385 100 385 200M 385 100z" fill="transparent" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaska57x7vnn)" filter="url(#SvgjsFilter1277)" pathTo="M 0 200L 0 125C 22.458333333333332 125 41.70833333333334 87.5 64.16666666666667 87.5C 86.625 87.5 105.87500000000001 120 128.33333333333334 120C 150.79166666666669 120 170.04166666666669 25 192.5 25C 214.95833333333334 25 234.20833333333334 100 256.6666666666667 100C 279.125 100 298.375 100 320.8333333333333 100C 343.29166666666663 100 362.5416666666667 100 385 100C 385 100 385 100 385 200M 385 100z" pathFrom="M -1 200L -1 200L 64.16666666666667 200L 128.33333333333334 200L 192.5 200L 256.6666666666667 200L 320.8333333333333 200L 385 200"></path><path id="SvgjsPath1283" d="M 0 125C 22.458333333333332 125 41.70833333333334 87.5 64.16666666666667 87.5C 86.625 87.5 105.87500000000001 120 128.33333333333334 120C 150.79166666666669 120 170.04166666666669 25 192.5 25C 214.95833333333334 25 234.20833333333334 100 256.6666666666667 100C 279.125 100 298.375 100 320.8333333333333 100C 343.29166666666663 100 362.5416666666667 100 385 100" fill="none" fill-opacity="1" stroke="#cdb8a0" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaska57x7vnn)" filter="url(#SvgjsFilter1284)" pathTo="M 0 125C 22.458333333333332 125 41.70833333333334 87.5 64.16666666666667 87.5C 86.625 87.5 105.87500000000001 120 128.33333333333334 120C 150.79166666666669 120 170.04166666666669 25 192.5 25C 214.95833333333334 25 234.20833333333334 100 256.6666666666667 100C 279.125 100 298.375 100 320.8333333333333 100C 343.29166666666663 100 362.5416666666667 100 385 100" pathFrom="M -1 200L -1 200L 64.16666666666667 200L 128.33333333333334 200L 192.5 200L 256.6666666666667 200L 320.8333333333333 200L 385 200"></path><g id="SvgjsG1274" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1321" r="0" cx="64.16666666666667" cy="87.5" class="apexcharts-marker w171489x5 no-pointer-events" stroke="#cdb8a0" fill="#ffe2e5" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1275" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1316" x1="0" y1="0" x2="385" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1317" x1="0" y1="0" x2="385" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1318" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1319" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1320" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1299" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1268" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 100px;"></div><div class="apexcharts-tooltip apexcharts-theme-light" style="left: 75.1667px; top: 90.5px;"><div class="apexcharts-tooltip-title" style="font-family: Poppins; font-size: 12px;">Mar</div><div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: transparent; display: none;"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Net Profit: </span><span class="apexcharts-tooltip-text-value">$45 thousands</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
			<!--end::Chart-->
			<!--begin::Stats-->
			<div class="card-spacer mt-n25">
				<!--begin::Row-->
				<div class="row m-0">
					<div class="col bg-primary px-6 py-8 rounded-xl text-primary mr-7 mb-7 text-white">
						<span class="d-block my-2">
							<i class="fas fa-users icon-2x text-white"></i>
							<span class="font-size-h3 font-weight-bolder ml-3"><?php echo e($employee_count); ?></span>
						</span>
						<span class="font-weight-bold font-size-h6 mt-2"><?php echo e($employee_text->$field.'s'); ?></span>
					</div>
					<div class="col bg-warning px-6 py-8 rounded-xl text-white mb-7">
						<span class="d-block my-2">
							<i class="fas fa-user-check icon-2x text-white"></i>
							<span class="font-size-h3 font-weight-bolder ml-3"><?php echo e(isset($user_counts['manager']) ? $user_counts['manager'] : 0); ?></span>
						</span>
						<span class="font-weight-bold font-size-h6"><?php echo e($manager_text->$field.'s'); ?></span>
					</div>
				</div>
				<!--end::Row-->
				<!--begin::Row-->
				<div class="row m-0">
					<div class="col bg-bblack px-6 py-8 rounded-xl mr-7 text-white">
						<span class="d-block my-2">
							<i class="flaticon-event-calendar-symbol icon-2x text-white"></i>
						</span>
						<span class="font-weight-bold font-size-h6 mt-2"><?php echo e(__('form.label.date_today')); ?></span>
						<div class="font-weight-bold font-size-h6 mt-2"><?php echo e($today); ?></div>
					</div>
					<div class="col bg-dark-yellow px-6 py-8 rounded-xl text-white">
						<span class="d-block my-2">
							<i class="flaticon2-hourglass-1 icon-2x text-white"></i>
						</span>
						<span class="font-weight-bold font-size-h6 mt-2"><?php echo e(__('form.label.until_eoy')); ?></span>
						<div class="font-weight-bold font-size-h6 mt-2"><?php echo e(trans_choice('form.label.week', 2).': '.$remaining_weeks); ?></div>
					</div>
				</div>
				<!--end::Row-->
			</div>
			<!--end::Stats-->
		<div class="resize-triggers"><div class="expand-trigger"><div style="width: 386px; height: 463px;"></div></div><div class="contract-trigger"></div></div></div>
		<!--end::Body-->
	</div>
	<!--end::Mixed Widget 1-->
</div><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/elements/workforce.blade.php ENDPATH**/ ?>