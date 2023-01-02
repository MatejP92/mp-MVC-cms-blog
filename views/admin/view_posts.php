<?php 
/** @var $this \app\core\View */
$this->title = " - View all Posts"; 
?>

<h2>View All Posts</h2><br>

<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Creation Date</th>
            <th>Status</th>
            <th>Edit Post</th>
            <th>Preview Post</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td><a href="/post?id=<?php echo $post->id ?>"><?php echo $post->title ?></a></td>
            <td><?php echo $post->author ?></td>
            <td><?php echo $post->content ?></td>
            <td><?php echo $post->created ?></td>
            <td><?php echo $post->status ?></td>
            <td><a href="/admin/edit_post?id=<?php echo $post->id ?>">Edit</a></td>
            <td><a href="/admin/post_preview?id=<?php echo $post->id ?>">Preview</a>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>