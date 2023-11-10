
<ul class="navi navi-hover py-4">
    
    <?php
	$path = '';
	if(!in_array(Request::path(), array('en', 'du'))) {
    	$pos = strpos(Request::path(), '/');
   		$path = substr(Request::path(), $pos+1);
	}
    ?>
    <li class="navi-item">
        <a href="<?php echo e(url('en/'.$path)); ?>" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="<?php echo e(asset(config('layout.resources.lang-flag-en'))); ?>" alt=""/>
            </span>
            <span class="navi-text">English</span>
        </a>
    </li>

    
    <li class="navi-item active">
        <a href="<?php echo e(url('du/'.$path)); ?>" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="<?php echo e(asset(config('layout.resources.lang-flag-du'))); ?>" alt=""/>
            </span>
            <span class="navi-text">Nederlands</span>
        </a>
    </li>
</ul>
<?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/layout/partials/extras/dropdown/languages.blade.php ENDPATH**/ ?>