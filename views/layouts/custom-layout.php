<?php

/**
 * @var App\Core\Layout $this
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $this->title; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <?php echo $this->generalStyle(); ?>
    <?php echo $this->generateScriptHeader(); ?>

    <link rel="stylesheet" href="<?php echo asset_path('bootstrap/bootstrap.min.css'); ?>">
</head>
<body>

<div class="container">

    <?php $this->inc('layouts/header'); ?>

    <h1 class="pt-5 pb-5">Custom layout</h1>

    <?php echo $this->content; ?>

</div>

<script src="<?php echo asset_path('bootstrap/jquery-3.3.1.slim.min.js'); ?>"></script>
<script src="<?php echo asset_path('bootstrap/popper.min.js'); ?>"></script>
<script src="<?php echo asset_path('bootstrap/bootstrap.min.js'); ?>"></script>

<?php echo $this->generateScriptFooter(); ?>
</html>
