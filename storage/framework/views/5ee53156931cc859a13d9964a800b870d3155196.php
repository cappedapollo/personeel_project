<?php $__env->startSection('content'); ?>
<p>Dear <?php echo e($data['name']); ?>,</p>
<p>You have requested the setup of the setup verification link. You need to have the google authenticator smartphone app, which then will allow you to scan the QR code and access <?php echo e(config('app.name')); ?>.</p>
<p>Click on the button for your unique setup.</p>
<p><a href="<?php echo e($data['register_url']); ?>" class="btn btn-primary">SETUP</a></p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\@apollo\@work\@laravel\API_project\public_html\resources\views/emails/en/gfa_setup.blade.php ENDPATH**/ ?>