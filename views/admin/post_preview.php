<?php
/** @var $this \app\core\View */
$this->title = " - Post"; 
?>

<h1>Post Preview</h1>
<hr>

<?php foreach($post as $p): ?>

<!-- POST TITLE GOES HERE -->
<h2>
<?php echo $p->title ?>
</h2>
<!-- POST STATUS GOES HERE -->
<p>
Status: <?php echo $p->status ?>
</p>
<!-- POST AUTHOR GOES HERE -->
<p class="lead">
by <a href=""><?php echo $p->author ?></a>
</p>
<!-- POST CREATION DATE GOES HERE -->
<p><?php echo $p->created ?></p>
<hr>
<!-- POST CONTENT GOES HERE -->
<p><?php echo $p->content ?></p>  

<hr>
<!-- POST COMMENTS -->
<h5>Comments</h5>

<?php endforeach; ?>