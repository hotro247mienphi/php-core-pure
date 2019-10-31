<?php
/**
 * @var App\Core\Layout $this
 * @var stdClass $user
 */
?>
<form action="<?php echo route('users.update', ['id' => $user->id]); ?>" method="POST">

    <input type="hidden" name="_method" value="PATCH"/>

    <?php $this->inc('user/_form');?>

</form>