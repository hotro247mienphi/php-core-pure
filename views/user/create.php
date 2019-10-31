<?php

/**
 * @var App\Core\Layout $this
 * @var stdClass $user
 */

?>
<form action="<?php echo route('users.store'); ?>" method="POST">

    <?php $this->inc('user/_form');?>

</form>