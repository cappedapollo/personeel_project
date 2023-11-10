<input type="hidden" id="page" value="<?php echo e($page); ?>">
<input type="hidden" id="delete_title_text" value="<?php echo e(__('messages.delete_title', ['module'=>strtolower($module)])); ?>">
<input type="hidden" id="delete_conf_text" value="<?php echo e(__('messages.delete_conf')); ?>">
<input type="hidden" id="cancel_text" value="<?php echo e(__('form.label.cancel')); ?>">
<input type="hidden" id="search_text" value="<?php echo e(__('form.label.search')); ?>">
<input type="hidden" id="previous_text" value="<?php echo e(__('form.label.previous')); ?>">
<input type="hidden" id="next_text" value="<?php echo e(__('form.label.next')); ?>">
<input type="hidden" id="no_data_text" value="<?php echo e(__('messages.no_data')); ?>">
<input type="hidden" id="icon_url" value="<?php echo e(asset(config('layout.resources.popup_icon'))); ?>"><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/components/set-titles.blade.php ENDPATH**/ ?>