<?php
//error_reporting(E_ALL);
include('config/session.php');
include('config/setup.php');

$id = mysqli_real_escape_string($dbc, $_GET['id']);

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
        <title>Skatīt attēlu</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <?php
            if(isset($id)) {
                $q = "SELECT image FROM products WHERE id = $id";
                $r = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($r);
                $image = $row["image"];
                if($image != '') {
                    $info = getimagesizefromstring($image);
                    echo '<img src="data:image/'.$info["mime"].';base64,'.base64_encode($image).'"/>';
                } else {
                    echo "Nav attēla, ko parādīt...";
                }
            } else {
                echo "Nav attēla, ko parādīt...";
            }
        ?>
    </body>
</html>
