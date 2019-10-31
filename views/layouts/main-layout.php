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
    <link rel="shortcut icon" href="<?php echo public_html('favicon.ico')?>" type="image/x-icon" />

    <?php echo $this->generalStyle(); ?>
    <?php echo $this->generateScriptHeader(); ?>

    <link rel="stylesheet" href="<?php echo asset_path('bootstrap/bootstrap.min.css'); ?>">
</head>
<body>

<div class="container-fluid">

    <?php $this->inc('layouts/header'); ?>

    <?php echo $this->content; ?>

</div>

<script src="<?php echo asset_path('bootstrap/jquery-3.3.1.slim.min.js'); ?>"></script>
<script src="<?php echo asset_path('bootstrap/popper.min.js'); ?>"></script>
<script src="<?php echo asset_path('bootstrap/bootstrap.min.js'); ?>"></script>

<?php echo $this->generateScriptFooter(); ?>
</html>
