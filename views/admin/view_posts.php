<?php 
use app\core\Application;
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
            <th>Edit Post</th>
            <th>Preview Post</th>
            <th>Status</th>
            <?php if(Application::$app->userRole() == "admin"): ?>
                <th>Change Post Status</th>
            <?php endif; ?>
            <th>Delete Post</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td><a href="/post?id=<?php echo $post->id ?>"><?php echo $post->title ?></a></td>
            <td><?php echo $post->author ?></td>
            <td><?php echo $post->content ?></td>
            <td><?php echo $post->created ?></td>
            <td><a href="/dashboard/edit_post?id=<?php echo $post->id ?>" class="btn btn-primary btn-sm">Edit</a></td>
            <td><a href="/dashboard/post_preview?id=<?php echo $post->id ?>" class="btn btn-outline-primary btn-sm">Preview</a>

            <?php if($post->status == "unpublished"): ?>
                <td class="text-danger"><?php echo $post->status ?></a></td>
            <?php else: ?>
                <td class="text-success"><?php echo $post->status ?></td>
            <?php endif; ?>
            <?php if(Application::$app->userRole() == "admin"): ?>
                <?php if($post->status == "unpublished"): ?>
                    <td><a class="btn btn-outline-success btn-sm" href="/dashboard/publish_post?id=<?php echo $post->id ?>" onclick="return confirm('Are you sure you want to Publish this post?');">Publish</a></td> 
                <?php else: ?>
                    <td><a class="btn btn-outline-danger btn-sm" href="/dashboard/unpublish_post?id=<?php echo $post->id ?>" onclick="return confirm('Are you sure you want to Unpublish this post?');">Unpublish</a></td>
                <?php endif; ?>
            <?php endif; ?>
            <td><a class="btn btn-danger btn-sm" href="/dashboard/delete_post?id=<?php echo $post->id ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>