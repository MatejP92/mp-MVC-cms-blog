<?php use app\core\Application; ?>

<h1>Home</h1>

<h3>Welcome <?php echo $name ?>

<?php if(Application::isGuest()): ?>

<h6>If you are not registered, you can <a href="register">REGISTER</a> here.</h6>
<h6>If you are already registered, you can <a href="login">LOGIN</a> here.</h6> 

<?php endif;?>
