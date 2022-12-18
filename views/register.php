<?php 
/** @var $this \app\core\View */
$this->title = " - Register"; 
?>

<div class="col">
    <h2 class="text-center">Register</h2>
    <div class="container">
        <form action="" method="post">
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="text" class="form-control <?php echo $model->hasError('username') ? 'is-invalid' : '' ?>" name="username" value="<?php echo $model->username ?>" id="username" placeholder="Username...">
                <label for="username">Username...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("username") ?>
                </div>
            </div>
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="text" class="form-control <?php echo $model->hasError('email') ? 'is-invalid' : '' ?>" name="email" value="<?php echo $model->email ?>" id="email" placeholder="Email...">
                <label for="email">Email...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("email") ?>
                </div>
            </div>
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="password" class="form-control <?php echo $model->hasError('password') ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Password...">
                <label for="password">Password...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("password") ?>
                </div>
            </div>
            <div class="mx-auto form-floating mb-3 mt-3 col-4">
                <input type="password" class="form-control <?php echo $model->hasError('repeatPassword') ? 'is-invalid' : '' ?>" name="repeatPassword" id="repeatPassword" placeholder="RepeatPassword...">
                <label for="repeatPassword">Repeat Password...</label>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("repeatPassword") ?>
                </div>
            </div>
            <div class="mx-auto d-grid">
                <button type="submit" class="mx-auto btn btn-dark col-2" name="submit" id="submit">Register</button>
            </div>
        </form>
    </div>
</div>
