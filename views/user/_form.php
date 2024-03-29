<?php

/**
 * @var App\Core\Layout $this
 * @var stdClass $user
 */

$validateErrors = session('validate_error');
?>

<?php if ($validateErrors): ?>
    <div class="alert alert-danger">
        <ul>
            <li><?php echo join('</li><li>', $validateErrors); ?></li>
        </ul>
    </div>
<?php endif; ?>

<input type="hidden" name="_csrf" value="<?php echo csrf(); ?>"/>

<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control"/>
</div>

<div class="form-group">
    <label>Email address</label>
    <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control"/>
</div>

<?php if (!property_exists($user, 'id') || empty($user->id)): ?>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $user->password; ?>" class="form-control"/>
    </div>
<?php endif; ?>

<button type="submit" class="btn btn-primary">Submit</button>
<a href="<?php echo route('users.index'); ?>" class="btn btn-secondary">Back</a>