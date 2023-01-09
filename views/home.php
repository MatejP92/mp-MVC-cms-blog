<?php use app\core\Application; ?>

<h1>Home</h1>

<?php if(Application::isGuest()): ?>

    <h3>Welcome Guest </h3>

    <h6>If you are not registered, you can <a href="register">REGISTER</a> here.</h6>
    <h6>If you are already registered, you can <a href="login">LOGIN</a> here.</h6> 

<?php elseif(!Application::isGuest()): ?>

    <h3>Welcome <?php echo Application::$app->user->getDisplayName() ?> </h3>
    <br>
    <h4>Your published Posts</h4>

    <!-- Display posts from a logged in user -->
    <hr>
    
    <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>

            <!-- POST TITLE GOES HERE -->
        <h2>
            <a href="/post?id=<?php echo $post->id ?>"><?php echo $post->title ?></a>
        </h2>
        <!-- POST AUTHOR GOES HERE -->
        <p class="lead">
            by <a href=""><?php echo $post->author ?></a>
        </p>
        <!-- POST CREATION DATE GOES HERE -->
        <p><span class="glyphicon glyphicon-time"></span><?php echo $post->created ?></p>
        <hr>
        <!-- POST CONTENT GOES HERE -->
        <p><?php echo $post->content ?></p>  
        <small><a class="btn btn-secondary" href="/post?id=<?php echo $post->id ?>">Read More</a></small> <!-- Read More takes us to the full post -->
        <hr><hr>

        <?php endforeach; ?>
    
    <?php else: ?>
        <p>You have no published posts!</p>

    <?php endif; ?>

<?php endif; ?>
