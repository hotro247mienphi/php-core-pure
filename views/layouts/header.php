<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <a class="navbar-brand" href="/">PHP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo is_url(route('users.index')) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo route('users.index'); ?>">Users <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php echo is_url(route('users.create')) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo route('users.create'); ?>">Create User</a>
            </li>
            <li class="nav-item <?php echo is_url(route('api.json')) ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo route('api.json'); ?>">Api json</a>
            </li>
        </ul>
    </div>
</nav>
