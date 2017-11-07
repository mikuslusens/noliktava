<?php

    # Start the session
    session_start();

    if (!isset($_SESSION['username'])) {
            header('Location: login.php');
    }

?>

<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sākums</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php
        $q = "SELECT * FROM users WHERE username = '$_SESSION[username]'";
        $r = mysqli_query($dbc, $q);
        $row = mysqli_fetch_assoc($r);
        ?>
        
        <p class="greeting"><?php
        echo "Laipni lūgti MEGA MARKET noliktavas pārvaldības sistēmā!";
        ?></p>
        <p class="greeting-subtitle">
            <?php
                if ($row['type'] == 'admin') {
                    echo "Jūsu lietotājvārds: ".$row['username'].". Lietotāja tips: administrators.";
                } else if ($row['type'] == 'regular') {
                    echo "Jūsu lietotājvārds: ".$row['username'].". Lietotāja tips: parasts lietotājs.";
                }
            ?>
        </p>    
        <?php if($row['type'] == 'admin') { ?>
            <div class="main-menu-container"><!--
                --><div class="main-menu">
                    <form action="add_product.php">
                        <button type="submit">Pievienot preci</button>
                    </form>
                    <form action="product_list.php">
                        <button type="submit">Preču saraksts</button>
                    </form>
                    <form action="search.php">
                        <button type="submit">Meklēt preci</button>
                    </form>
                    <form action="add_category.php">
                        <button type="submit">Pievienot kategoriju</button>
                    </form>
                </div><!--
                --><div class="main-menu">
                    <form action="category_list.php">
                        <button type="submit">Kategoriju saraksts</button>
                    </form>

                    <form action="add_user.php">
                        <button type="submit">Pievienot lietotāju</button>
                    </form>
                    <form action="user_list.php">
                        <button type="submit">Lietotāju saraksts</button>
                    </form>

                    <form action="logout.php">
                        <button type="submit">Logout</button>
                    </form>
                </div><!--
            --></div>
        <?php } else { ?>
            <div class="main-menu-container">
                <div class="main-menu">
                    <form action="add_product.php">
                        <button type="submit">Pievienot preci</button>
                    </form>
                    <form action="product_list.php">
                        <button type="submit">Preču saraksts</button>
                    </form>
                    <form action="search.php">
                        <button type="submit">Meklēt preci</button>
                    </form>
                    <form action="add_category.php">
                        <button type="submit">Pievienot katgoriju</button>
                    </form>
                    <form action="category_list.php">
                        <button type="submit">Kategoriju saraksts</button>
                    </form>

                    <form action="logout.php">
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </body>
</html>
