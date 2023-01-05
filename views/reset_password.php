<?php 
/** @var $this \app\core\View */
$this->title = " - Reset Password"; 
?>

<div class="col">
    <h2 class="text-center">New Password</h2>
    <div class="container">
        <form action="" method="post">
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="password" class="form-control <?php echo $model->hasError("password") ? "is-invalid" : "" ?>" name="password" id="password" placeholder="New Password...">
                <label for="password">New Password...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("password") ?>
                </div>
            </div>
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="password" class="form-control <?php echo $model->hasError("repeatPassword") ? "is-invalid" : "" ?>" name="repeatPassword" id="repeatPassword" placeholder="RepeatPassword...">
                <label for="repeatPassword">Repeat Password...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("repeatPassword") ?>
                </div><br>
            </div>
            <div class="mx-auto d-grid">
                <button type="submit" class="mx-auto btn btn-dark col-2" name="submit" id="submit">Submit</button>
            </div>
        </form>
    </div>
</div>