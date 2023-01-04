<?php
use app\core\Application;
/** @var $this \app\core\View */
$this->title = " - Profile"; 
?>

<h3 class="text-center">Profile</h3>
<hr>


<form method="POST" action="" class="mx-auto bg-light bg-gradient mt-5 mb-5 p-3 w-75">
    <p><b>Edit Profile</b></p>
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" class="form-control <?php echo $model->hasError("username") ? "is-invalid" : "" ?>" value="<?php echo $user->username ?>">
    <div class="invalid-feedback">
        <?php echo $model->getFirstError("username") ?>
    </div><br>

    <div class="row">
        <div class="col">
            <label for="firstname">Firstname:</label><br>
            <input type="text" id="firstname" name="firstname" class="form-control <?php echo $model->hasError("firstname") ? "is-invalid" : "" ?>" value="<?php echo $user->firstname ?>">
            <div class="invalid-feedback">
                <?php echo $model->getFirstError("firstname") ?>
            </div>
        </div>
        <div class="col">
            <label for="lastname">Lastname:</label><br>
            <input type="text" id="lastname" name="lastname" class="form-control <?php echo $model->hasError("lastname") ? "is-invalid" : "" ?>" value="<?php echo $user->lastname ?>">
            <div class="invalid-feedback">
                <?php echo $model->getFirstError("lastname") ?>
            </div>
        </div>
    </div><br>
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email" class="form-control <?php echo $model->hasError("email") ? "is-invalid" : "" ?>" value="<?php echo $user->email ?>">
    <div class="invalid-feedback">
        <?php echo $model->getFirstError("email") ?>
    </div><br>


    <br>
    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>

