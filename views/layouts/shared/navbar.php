<?php use app\core\Application; ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Matej's Blog Page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-4" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-1">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="/posts">Posts</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                    <?php  if(Application::isGuest()): ?>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item mx-1">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?php echo Application::$app->user->getDisplayName() ?></a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/profile">Profile</a>
                        </li>
                        <?php if(Application::$app->UserRole() == "admin"): ?>
                            <li class="nav-item mx-1">
                                <a class="nav-link" href="/admin">Admin Dashboard</a>
                            </li>
                        <?php elseif(Application::$app->UserRole() == "subscriber"): ?>
                            <li class="nav-item mx-1">
                                <a class="nav-link" href="/admin">Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>