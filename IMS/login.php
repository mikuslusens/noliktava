<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
	
    # Start session
    session_start();

    include('config/connection.php');

    if ($_POST) {
		$username = mysqli_real_escape_string($dbc, $_POST['username']);
                $password = mysqli_real_escape_string($dbc, $_POST['password']);
                $q = "SELECT * FROM users WHERE username = '$username' AND password = SHA1('$password')";
		$r = mysqli_query($dbc, $q);
                mysqli_error($dbc);
	
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_assoc($r);
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['type'] = $row['type'];
			header('Location: index.php');
			$found = true;
		} else {
			$found = false;
		}
	} else {
            $found = false;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ierakstīšanās</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
<body>
    <div class="panel-body">
        <?php if(!$found && $_POST) {echo "Lietotājvārds un/vai parole ievadīti nepareizi!";} ?>		
        <form action="login.php" method="post" role="form">
            <div class="form-group">
                <label for="username">Lietotājvārds</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Lietotājvārds">
            </div>
            <div class="form-group">
                <label for="password">Parole</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Parole"><br>
                <button type="submit" class="btn btn-default">Ieiet</button>
            </div>
            <?php// if ($_POST){
//                mysqli_error($dbc);
//                echo gettype($r);}
//                
//                if(!mysqli_query($dbc, $q)){
//                    echo "True";
//                }
//                else {
//                        echo 'false';
//                }
//            ?>
        </form>
    </div> <!-- END panel body -->
</body>
</html>
