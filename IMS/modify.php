<?php
//error_reporting(E_ALL);
include('config/session.php');
include('config/setup.php');

$id = mysqli_real_escape_string($dbc, $_GET['id']);
$table = mysqli_real_escape_string($dbc, $_GET['table']);

if(isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 'regular') {
        if($table == 'users') {
            header('Location: index.php');
        }
    } 
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Vērtību maiņa</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel">
            <?php
                $q = "SELECT * FROM $table WHERE id = $id";
                    $r = mysqli_query($dbc, $q);
                    $row = mysqli_fetch_assoc($r);
                    if($table == "categories"){
                        $type = "šai kategorijai";
                    } else if ($table == "products") {
                        $type = "šai precei";
                    } else if ($table == "users") {
                        $type = "šim lietotājam";
                    }
                
                if($table == 'categories' or $table == 'products') {
                    echo "<p>Jūs izmainat īpašības ".$type.": ".$row['name']."</p>";
                } else if ($table == 'users') {
                    echo "<p>Jūs izmainat īpašības ".$type.": ".$row['username']."</p>";
                }
                
                
                if($table == 'categories') {    
                    if(isset($_POST['submitted']) and !empty($_POST['name'])) {
                        $name = mysqli_real_escape_string($dbc, $_POST['name']);
                        $q = "UPDATE categories SET name = '".$name."' WHERE id = ".$id;
                        $r = mysqli_query($dbc, $q);
                        $ok = true;
                        if($r) {
                            $message = "<p>Kategorijas vērtības izmainītas veiksmīgi!</p>";
                        } else {
                            $message = '<p>Kategorijas vērtības netika izmainītas šīs kļūdas dēļ: '.mysqli_error($dbc);
                            $message .= $q.'</p>';
                        }
                    } else {
                        $ok = false;
                    }
                } else if ($table == 'products') {
                    if(isset($_POST['submitted']) and !empty($_POST['name']) and !empty($_POST['amount']) and
                            !empty($_POST['price']) and $_POST['category'] !== 0 and !empty($_POST['description'])) {
                        $name = mysqli_real_escape_string($dbc, $_POST['name']);
                        $amount = mysqli_real_escape_string($dbc, $_POST['amount']);
                        $price = mysqli_real_escape_string($dbc, $_POST['price']);
                        $description = mysqli_real_escape_string($dbc, $_POST['description']);
                        $q = "UPDATE products "
                        . "SET name = '".$name."', amount = '".$amount."', price = '".$price."', category = ".$_POST['category'].", description ='".$description."'"
                        . " WHERE id = ".$id;
                        $r = mysqli_query($dbc, $q);
                        $ok = true;
                        if($r) {
                            $message = "<p>Preces vērtības izmainītas veiksmīgi!</p>";
                        } else {
                            $message = '<p>Preces vērtības netika izmainītas šīs kļūdas dēļ: '.mysqli_error($dbc);
                            $message .= $q.'</p>';
                        }
                    } else {
                        $ok = false;
                    }
                } else if ($table == 'users') {
                    if(isset($_POST['submitted']) and !empty($_POST['username']) and !empty($_POST['password']) and $_POST['type'] !== 0) {
                       $username = mysqli_real_escape_string($dbc, $_POST['username']);
                       $password = mysqli_real_escape_string($dbc, $_POST['password']);
                       $q = "UPDATE users "
                               . "SET username = '".$username."', password = SHA1('".$password."'), type = '".$_POST['type']."'"
                               . " WHERE id = ".$id;
                       $r = mysqli_query($dbc, $q);
                       $ok = true;
                       if($r) {
                            $message = "<p>Preces vērtības izmainītas veiksmīgi!</p>";
                        } else {
                            $message = '<p>Preces vērtības netika izmainītas šīs kļūdas dēļ: '.mysqli_error($dbc);
                            $message .= $q.'</p>';
                        }
                    } else {
                        $ok = false;
                    }
                }
            ?>
            <?php if(isset($message)) {echo $message;} ?>
            <?php if(isset($_POST['submitted']) and $ok == false) {echo "<p>Lūdzu aizpildiet lauku/us!</p>";} ?>
            <?php print_r($_POST); ?>
            <form action="modify.php?id=<?php echo $id;?>&table=<?php echo $table;?>" method="POST">
                <?php if($table == 'categories') { ?>
                    <label for="name">Nosaukums:</label>
                    <input type="text" class="form-control" id="name" name="name">
                <?php } else if($table == 'products') { ?>
                    <label for="name">Nosaukums:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <label for ="amount">Daudzums:</label>
                    <input type="text" class="form-control" id="amount" name="amount">
                    <label for="price">Cena:</label>
                    <input type="text" class="form-control" id="price" name="price">
                    <label for="category">Kategorija:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="0">-------</option>
                            <?php 
                            $q = "SELECT * FROM categories";
                            $r = mysqli_query($dbc, $q);
                            while($list = mysqli_fetch_assoc($r)) { ?>
                            <option value="<?php echo $list['id'];?>"><?php echo $list['name'];?></option>
                            <?php } ?>
                    </select>
                    <label for="description">Apraksts:</label>
                    <textarea class="form-control" name="description" id="description" rows="8" maxlength="250" placeholder="Max 250 rakstzīmes..."></textarea>
                <?php } else if($table == 'users') { ?>
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
                <?php } ?>
                <button type="submit">Iesniegt</button>
                <input type="hidden" name="submitted" value="1">
            </form>
        </div>
    </body>
</html>
