<?php 
/** @var $this \app\core\View */
$this->title = " - View all Users"; 
?>

<h2>View all Users</h2>

<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Creation Date</th>
            <th>Role</th>
            <th>Change Role</th>
            <th>Delete User</th>
        </tr>
    </thead>
    <tbody>
        <?php //print_r($user) ?>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user["username"] ?></td>
                <td><?php echo $user["firstname"] ?></td>
                <td><?php echo $user["lastname"] ?></td>
                <td><?php echo $user["email"] ?></td>
                <td><?php echo $user["created"] ?></td>
                <?php if($user["role"] == "admin"): ?>
                    <td class="text-danger"><?php echo $user["role"] ?></td>
                <?php elseif ($user["role"] == "subscriber"): ?>
                    <td class="text-success"><?php echo $user["role"] ?></td>
                <?php endif; ?>
                <?php if($user["role"] == "admin"): ?>
                <td>
                    <?php if ($user["username"] === "admin"): ?>
                        <button type="button" class="btn btn-outline-danger btn-sm disabled" disabled>Disabled</button>
                    <?php else: ?>
                        <a class="btn btn-outline-success btn-sm" href='/dashboard/change_role?id=<?php echo $user['id'] ?>' onclick="return confirm('Are you sure you want to change user role to Subscriber?');">Subscriber</a>
                    <?php endif; ?>
                </td>
                <?php else: ?>
                    <td><a class="btn btn-outline-danger btn-sm" href='/dashboard/change_role?id=<?php echo $user['id'] ?>' onclick="return confirm('Are you sure you want to change user role to Admin?')">Admin</a></td>
                <?php endif; ?>
                <td>
                    <?php if ($user["username"] === "admin"): ?>
                        <a class="btn btn-danger btn-sm disabled" disabled>Delete</button>
                    <?php else: ?>
                        <a class="btn btn-danger btn-sm" href='/dashboard/delete_user?id=<?php echo $user['id'] ?>' onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>