<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?> - Verify Email</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header"><?php echo e(__('Verify Your Email Address')); ?></div>

            <div class="card-body">
                <?php if(session('status') == 'verification-link-sent'): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(__('A new verification link has been sent to the email address you provided during registration.')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('verification.send')); ?>">
                    <?php echo csrf_field(); ?>

                    <div>
                        <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

                        <?php echo e(__('If you did not receive the email')); ?>,
                    </div>

                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline"><?php echo e(__('click here to request another')); ?></button>.
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\expense_master\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>