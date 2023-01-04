<?php
/** @var $this \app\core\View */
$this->title = " - Profile"; 
?>

<h3 class="text-center">Profile</h3>
<hr>

    <p><b>Username:</b></p>
    <p><?php echo $user->username ?></p>
    <p><b>First Name:</b> </p>
    <p><?php echo $user->firstname ?></p>
    <p><b>Last Name:</b> </p>
    <p><?php echo $user->lastname ?></p>
    <p><b>Email:</b> </p>
    <p><?php echo $user->email ?></p>
    <p><b>Role:</b> </p>
    <p><?php echo $user->role ?></p>

    <br>
    <a href="/edit_profile?id=<?php echo $user->id ?>" class="btn btn-primary">Edit Profile</a>
    <a href="/change_password?id=<?php echo $user->id ?>" class="btn btn-primary">Change Password</a>


