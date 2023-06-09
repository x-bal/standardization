<meta charset="utf-8" />
<?php
    $module = Module::find(Request::segment(1));
?>
<title><?php echo $__env->yieldContent('title'); ?> | <?php echo e($module->getName()); ?></title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="shortcut icon" href="<?php echo e(asset('img/logo/fav.ico')); ?>" type="image/x-icon">

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="<?php echo e(asset('/css/vendor.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('/css/apple/app.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('/plugins/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet" />
<!-- ================== END BASE CSS STYLE ================== -->

<?php echo $__env->yieldPushContent('css'); ?>
<?php /**PATH /Users/mac/Documents/tazaka/standardization/Modules/Faceid/Resources/views/includes/head.blade.php ENDPATH**/ ?>