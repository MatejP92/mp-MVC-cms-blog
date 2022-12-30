<?php
/** @var $this \app\core\View */
$this->title = " - Posts"; 
?>

<h2>POSTS</h2>
<hr>

<?php foreach($posts as $post): ?>

    <!-- POST TITLE GOES HERE -->
<h3>
    <a href=""><?php echo $post->title ?></a>
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
<small><a class="btn btn-secondary" href="#">Read More</a></small> <!-- Read More takes us to the full post -->
<hr><hr>

<?php endforeach; ?>