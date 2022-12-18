<?php 
/** @var $this \app\core\View */
$this->title = " - Forgot Password"; 
?>

<div class="col">
    <h2 class="text-center">Reset password</h2>
    <p class="text-center">An email with the password reset link will be sent to your email if it exists</p>
        <div class="container">
            <form action="" method="post">
                <div class="mx-auto form-floating mb-3 mt-3 col-4">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username/Email...">
                    <label for="username">Username/Email...</label>
                </div>
                <div class="mx-auto d-grid">
                    <button type="submit" class="mx-auto btn btn-dark col-2" name="submit" id="submit">Send</button>
                </div>
            </form>
        </div>
</div>