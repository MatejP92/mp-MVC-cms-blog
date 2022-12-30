<br><h2>View All Posts</h2><br>

<!-- <table border="2">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Creation Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <?php foreach($posts as $post): ?>
    <tr>
        <td><?php echo $post->title ?></td>
        <td><?php echo $post->author ?></td>
        <td><?php echo $post->content ?></td>
        <td><?php echo $post->created ?></td>
        <td><?php echo $post->status ?></td>
    </tr>
    <?php endforeach; ?>
</table> -->

<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Creation Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td><?php echo $post->title ?></td>
            <td><?php echo $post->author ?></td>
            <td><?php echo $post->content ?></td>
            <td><?php echo $post->created ?></td>
            <td><?php echo $post->status ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>