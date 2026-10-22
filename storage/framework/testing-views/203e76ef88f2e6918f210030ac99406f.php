<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/favicon_VITA.png')); ?>">

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <script type="module" src="https://cdn.jsdelivr.net/gh/datvm/material-web@v2.3.0/dist/bundle.esm.min.js"></script>

        <title><?php echo $__env->yieldContent('title'); ?></title>
    </head>
    <body class="m-0 min-h-screen overflow-hidden font-sans text-[#ef5b97]">
        <div class="relative h-screen overflow-hidden">
            <div class="absolute -left-14 -top-28 h-52 w-52 rounded-full bg-linear-to-b from-[#ef5b97] to-transparent md:-left-26 md:-top-44 md:h-100 md:w-100"></div>
            <div class="absolute -bottom-24 -right-22 h-52 w-52 rotate-180 rounded-full bg-linear-to-b from-[#ef5b97] to-transparent md:-right-26 md:h-75 md:w-75"></div>

            <div class="grid h-screen place-items-center px-4 md:grid-cols-[1.5fr_1fr] md:px-8">
                <?php echo $__env->make('components.login.login-logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php echo $__env->yieldContent('content'); ?>
                
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\anjos-do-peito\resources\views/layouts/main-login.blade.php ENDPATH**/ ?>