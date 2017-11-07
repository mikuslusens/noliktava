<?php include('config/session.php'); ?>
<?php include('config/setup.php'); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Pievienot kategoriju</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php 
            if(isset($_POST['submitted']) == 1 and !empty($_POST['name'])) {
                $name = mysqli_real_escape_string($dbc, $_POST['name']);
                $q = "INSERT INTO categories (name) VALUES ('$name')";
		$r = mysqli_query($dbc, $q);
                if ($r) {
                    $message = '<p>Kategorija tika pievienota!</p>';
                    } else {
                    $message = '<p>Kategorija netika pievienota dēļ šīs kļūdas: '.mysqli_error($dbc);
                    $message .= '<p>'.$q.'</p>';
                    }
            }
        ?>
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel">
            <?php if(isset($message)) {echo $message;} ?>
            <?php if(isset($_POST['submitted']) and !isset($name)) {echo "<p>Lūdzu aizpildiet lauku!</p>";} ?>
            <form action="add_category.php" method="POST">
                <label for="name">Nosaukums</label>
                <input type="text" class="form-control" id="name" name="name">
                <button type="submit">Pievienot</button>
                <input type="hidden" name="submitted" value="1">
            </form>
        </div>
    </body>
</html>
