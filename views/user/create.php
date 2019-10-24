<?php

use App\Core\Layout;

/**
 * @var Layout $this
 * @var array $data
 */

?>
<form action="/users/store" method="POST">

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control"/>
    </div>

    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" class="form-control"/>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control"/>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>