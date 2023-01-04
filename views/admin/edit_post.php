<?php use app\core\Application; ?>
<?php 
/** @var $this \app\core\View */
$this->title = " - Edit Post"; 
?>


<h2 class="text-center">Edit Post</h2>

<?php foreach($post as $p): ?>

    <form method="POST" action="" class="mx-auto bg-light bg-gradient mt-5 mb-5 p-3 w-75">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" class="form-control <?php echo $model->hasError("title") ? "is-invalid" : "" ?>" value="<?php echo $p->title ?>">
        <div class="invalid-feedback">
            <?php echo $model->getFirstError("title") ?>
        </div><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" class="form-control" value="<?php echo $p->author ?>" readonly><br>

        <label for="status">Post status: </label>
        <?php if($p->status == "unpublished"): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="unpublished" value="unpublished" checked>
                <label class="form-check-label" for="status">Unpublished</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="published" value="published" <?php echo Application::$app->UserRole() !== "admin" ? "disabled": ""; ?>>
                <label class="form-check-label" for="published">Published</label>
            </div>
        <?php elseif($p->status == "published"): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="unpublished" value="unpublished" >
                <label class="form-check-label" for="status">Unpublished</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="published" value="published" <?php echo Application::$app->UserRole() !== "admin" ? "disabled": ""; ?> checked>
                <label class="form-check-label" for="published">Published</label>
            </div>
        <?php endif; ?>
        <br><br>
        <label for="content">Content:</label><br>
        <textarea id="editor" name="content" class="form-control <?php echo $model->hasError("content") ? 'is-invalid' : '' ?>"><?php echo $p->content ?></textarea>
        <script>
            ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
        </script>
        <div class="invalid-feedback">
            <?php echo $model->getFirstError("content") ?>
        </div><br><br>
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
    </form>

<?php endforeach; ?>