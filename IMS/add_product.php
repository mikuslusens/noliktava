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
        <title>Pievienot preci</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php 
            
            if($_FILES) {
                $targetFile = basename($_FILES["fileToUpload"]["name"]);
                echo $targetFile;
                $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
                echo $imageFileType;
                if($_FILES["fileToUpload"]["size"] > 2097152) {
                    $uploadMessage = "Augšupielādētais fails ir par lielu! ";
                    $uploadOk = false;
                } else if ($imageFileType != "jpg" and $imageFileType != "jpeg" and $imageFileType != "png") {
                    $uploadMessage .= "Atļautie failu formāti ir JPG, JPEG un PNG.";
                    $uploadOk = false;
                } else {
                    $uploadOk = true;
                }
            }
        
            if(!empty($_POST['name']) and !empty($_POST['amount'])
                    and !empty($_POST['price']) and $_POST['category'] !== 0 and !empty($_POST['description']) and $_FILES["fileToUpload"]["size"] !== 0) {
                $ok = true;
            } else {
                $ok = false;
            }
            if(isset($_POST['submitted']) and $ok == true and $uploadOk == true) {
                $name = mysqli_real_escape_string($dbc, $_POST['name']);
                $amount = mysqli_real_escape_string($dbc, $_POST['amount']);
                $price = mysqli_real_escape_string($dbc, $_POST['price']);
                $description = mysqli_real_escape_string($dbc, $_POST['description']);
                $image = mysqli_real_escape_string($dbc, (file_get_contents($_FILES['fileToUpload']['tmp_name'])));
                $q = "INSERT INTO products (name, amount, price, category, image, description)"
                        . " VALUES ('$name', '$amount', '$price', $_POST[category], '$image', '$description')";
                $r = mysqli_query($dbc, $q);
		if ($r) {
		$message = '<p>Prece pievienota</p>';
		} else {
		$message = '<p>Prece netika pievientota šīs kļūdas dēļ: '.mysqli_error($dbc);
		$message .= '<p>'.$q.'</p>';
                }
            }
        ?>
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel">
            <?php if(isset($uploadMessage)) {echo $uploadMessage;} ?>
            <?php if(isset($message)) {echo $message;} ?>
            <?php if(isset($_POST['submitted']) and $ok == false) {echo "<p>Lūdzu aizpildiet visus laukus!</p>";} ?>
            <?php print_r($_POST); ?>
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
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
                <label for="fileToUpload">Augšupielādēt attēlu(JPG, JPEG vai PNG):</label>
                <div><input type="file" name="fileToUpload" id="fileToUpload"></div>
                <button type="submit">Pievienot</button>
                <input type="hidden" name="submitted" value="1">
            </form>
        </div>
    </body>
</html>