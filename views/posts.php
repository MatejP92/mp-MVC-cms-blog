<?php
/** @var $this \app\core\View */
$this->title = " - Posts"; 
?>

<h2>POSTS</h2>
<hr>
<?php if(!empty($posts)): ?>

    <?php foreach($posts as $post): ?>

        <!-- POST TITLE GOES HERE -->
    <h3>
        <a href="/post?id=<?php echo $post->id ?>"><?php echo $post->title ?></a>
    </h3>
    <!-- POST AUTHOR GOES HERE -->
    <p class="lead">
        by <a href=""><?php echo $post->author ?></a>
    </p>
    <!-- POST CREATION DATE GOES HERE -->
    <p><?php echo $post->created ?></p>
    <hr>
    <!-- POST CONTENT GOES HERE -->
    <p><?php echo $post->content ?></p>  
    <small><a class="btn btn-secondary" href="/post?id=<?php echo $post->id ?>">Read More</a></small> <!-- Read More takes us to the full post -->
    <hr><hr>

    <?php endforeach; ?>

<?php else: ?>
    <p>There is no published posts!</p>

<?php endif; ?>