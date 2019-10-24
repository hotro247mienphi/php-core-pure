<?php
/**
 * @var App\Core\Layout $this
 * @var stdClass $user
 */
?>
<form action="<?php echo route('users.update', ['id'=>$user->id]); ?>" method="POST">

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control"/>
    </div>

    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control"/>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>