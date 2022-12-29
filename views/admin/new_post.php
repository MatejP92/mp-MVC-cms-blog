<?php use app\core\Application; ?>

<br>
<h2 class="text-center">New post</h2>

<form method="POST" action="" class="mx-auto bg-light bg-gradient mt-5 mb-5 p-3 w-50">
  <label for="title">Title:</label><br>
  <input type="text" id="title" name="title" class="form-control <?php //echo $model->hasError("title") ? "is-invalid" : "" ?>">
  <div class="invalid-feedback">
      <?php //echo $model->getFirstError("title") ?>
  </div><br>
  <label for="author">Author:</label><br>
  <input type="text" id="author" name="author" class="form-control" value="<?php echo Application::$app->user->getDisplayName() ?>" readonly><br>

  <label for="status">Post status:</label>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="draft" value="draft" checked>
    <label class="form-check-label" for="status">Draft</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="status" id="published" value="published" <?php echo Application::$app->UserRole() !== "admin" ? "disabled": ""; ?>>
    <label class="form-check-label" for="published">Published</label>
  </div><br>
  <br>
  <label for="content">Content:</label><br>
  <textarea id="content" name="content" class="form-control <?php //echo $model->hasError("content") ? 'is-invalid' : '' ?>"></textarea>
  <div class="invalid-feedback">
      <?php //echo $model->getFirstError("content") ?>
  </div><br><br>
  <input type="submit" value="Submit" class="btn btn-primary">
</form>