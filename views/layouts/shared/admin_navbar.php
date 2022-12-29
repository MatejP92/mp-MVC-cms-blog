<?php use app\core\Application; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?php if(Application::$app->UserRole() == "admin"): ?>
                <a class="navbar-brand" href="/admin">Admin Dashboard</a>
            <?php else: ?>
                <a class="navbar-brand" href="/admin">Content Creator Dashboard</a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-4" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                        <a class="nav-link" href="/admin">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Main page</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Posts
                        </a>                
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if(Application::$app->UserRole() == "admin"): ?>
                            <li><a class="dropdown-item" href="/admin/view_posts">View All Posts</a></li>
                        <?php elseif(Application::$app->UserRole() == "subscriber"): ?>
                            <li><a class="dropdown-item" href="/admin/view_posts">View Your Posts</a></li>
                        <?php endif; ?>
                            <li><a class="dropdown-item" href="/admin/new_post">Create Post</a></li>
                        </ul>
                    </li>
                    <?php if(Application::$app->UserRole() == "admin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/comments">Comments</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Users
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/admin/view_users">View All Users</a></li>
                            <li><a class="dropdown-item" href="/admin/new_user">Create User</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-1">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?php echo Application::$app->user->getDisplayName() ?></a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/profile">Profile</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                </ul>
            </div>
        </div>
    </nav>