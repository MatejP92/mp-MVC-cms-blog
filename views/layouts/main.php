<?php use app\core\Application; ?>

<!-- HEADER START -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <!-- <link href="/public/css/bootstrap.css" rel="stylesheet"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        
        <title>Matej's Blog Page</title>
    
    </head>
<!-- HEADER END -->

<!-- NAVBAR START -->
   <?php include_once "shared/navbar.php" ?>
<!-- NAVBAR END -->

<!-- PLACEHOLDER -->
<div class="container">
    <?php if(Application::$app->session->getFlash("success")): ?>
    <div class="alert alert-success">
        <?php echo Application::$app->session->getFlash("success") ?>
    </div>
    <?php endif; ?>
    {{content}}
</div>
<!----------------->

    <script src="/public/js/bootstrap.js"></script>
<!-- FOOTER START -->
    </body>
</html>
<!-- FOOTER END -->
