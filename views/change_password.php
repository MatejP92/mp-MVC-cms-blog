<?php
use app\core\Application;
/** @var $this \app\core\View */
$this->title = " - Profile"; 
?>

<h3 class="text-center">Profile</h3>
<hr>


<form method="POST" action="" class="mx-auto bg-light bg-gradient mt-5 mb-5 p-3 w-75">
    <!-- Add option to change password -->
    <div class="form-group">
        <p><b>Create New Password?</b></p>
        <label for="password">Current Password:</label><br>
        <input type="password" id="password" name="password" class="form-control <?php echo $model->hasError("password") ? "is-invalid" : "" ?>">
        <div class="invalid-feedback">
            <?php echo $model->getFirstError("password") ?>
        </div><br>
        <div class="row">
            <div class="col">
                <label for="newpassword">New Password:</label><br>
                <input type="password" id="newpassword" name="newpassword" class="form-control <?php echo $model->hasError("newpassword") ? "is-invalid" : "" ?>">
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("newpassword") ?>
                </div><br>
            </div>
            <div class="col">
                <label for="repeatnewpassword">Repeat New Password:</label><br>
                <input type="password" id="repeatnewpassword" name="repeatnewpassword" class="form-control <?php echo $model->hasError("repeatnewpassword") ? "is-invalid" : "" ?>">
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError("repeatnewpassword") ?>
                </div><br>
            </div>
        </div>
    </div>

    <!-- current password
    new password
    repeat new password -->
    
    <br>
    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>

