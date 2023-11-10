<?php if($message = Session::get('success')): ?>
<div class="alert alert-custom alert-success fade show" role="alert">
    <div class="alert-text"><?php echo e($message); ?></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if($message = Session::get('error')): ?>
<div class="alert alert-custom alert-danger fade show" role="alert">
    <div class="alert-text"><?php echo e($message); ?></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if($message = Session::get('warning')): ?>
<div class="alert alert-custom alert-warning fade show" role="alert">
    <div class="alert-text"><?php echo e($message); ?></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if($message = Session::get('info')): ?>
<div class="alert alert-custom alert-info fade show" role="alert">
    <div class="alert-text"><?php echo e($message); ?></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="alert alert-custom alert-danger fade show" role="alert">
    <div class="alert-text">
    	<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   	</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
<?php endif; ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/components/flash-message.blade.php ENDPATH**/ ?>