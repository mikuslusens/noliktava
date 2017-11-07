<?php include('config/session.php'); ?>
<?php include('config/setup.php'); ?>
<?php
if(isset($_SESSION['type'])) {
    if ($_SESSION['type'] != 'admin') {
        header('Location: index.php');
    } 
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pievienot lietotāju</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php 
            if(isset($_POST['submitted']) and !empty($_POST['username']) and !empty($_POST['password']) and $_POST['type'] !== 0) {
                $username = mysqli_real_escape_string($dbc, $_POST['username']);
                $password = mysqli_real_escape_string($dbc, $_POST['password']);
                $type = mysqli_real_escape_string($dbc, $_POST['type']);
                $q = "INSERT INTO users (username, password, type) VALUES ('$username', SHA1('$password'), '$type')";
		$r = mysqli_query($dbc, $q);
                if ($r) {
                    $message = '<p>Lietotājs tika pievienots!</p>';
                    } else {
                    $message = '<p>Lietotājs netika pievienots dēļ šīs kļūdas: '.mysqli_error($dbc);
                    $message .= '<p>'.$q.'</p>';
                    }
            }
        ?>
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel">
            <?php if(isset($message)) {echo $message;} ?>
            <?php if(isset($_POST['submitted']) and !isset($name) and !isset($password) and $_POST['type'] == 0) {echo "<p>Lūdzu aizpildiet laukus!</p>";} ?>
            <form action="add_user.php" method="POST">
                <label for="username">Lietotājvārds</label>
                <input type="text" class="form-control" id="username" name="username">
                <label for="password">Parole</label>
                <input type="password" class="form-control" id="password" name="password">
                <label for="type">Tips</label>
                <select class="form-control" id="type" name="type">
                    <option value="0">-------</option>
                    <option value="admin">Administrators</option>
                    <option value="regular">Parasts lietotājs</option>
                </select>
                <button type="submit">Pievienot</button>
                <input type="hidden" name="submitted" value="1">
            </form>
        </div>
    </body>
</html>
