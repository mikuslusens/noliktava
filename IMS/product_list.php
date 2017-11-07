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
        <title>Preču saraksts</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php
            $results_per_page = 15;
            
            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
            //if (isset($_GET["sort"])) { $sort  = $_GET["sort"]; } else { $sort=0; }
            $start_from = ($page-1) * $results_per_page;
            
            
            if(isset($_GET['sort'])) {
                if($_GET['sort']==1) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY p.name ASC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else if($_GET['sort']==2) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY p.name DESC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else if($_GET['sort']==3) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY category ASC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else if($_GET['sort']==4) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY category DESC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY p.id ASC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                }
            } else if (!isset($_GET['sort'])) {
                $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "ORDER BY p.id ASC LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
            }
        ?> 
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel" id="product-list">
            <div class="sort">
                <p>Kārtot pēc:</p>
                <form class="sort-form" action="product_list.php" method="get">
                    <select class="form-control" id="sort-by" name="sort">
                        <option value="0">-------</option>
                        <option value="1">Nosaukuma (A-Z)</option>
                        <option value="2">Nosaukuma (Z-A)</option>
                        <option value="3">Kategorijas (A-Z)</option>
                        <option value="4">Kategorijas (Z-A)</option>
                    </select>
                    <button id="sort" type="submit">Kārtot</button>
                </form>
            </div>
            <?php echo mysqli_error($dbc); ?>
            <table width="100%" border="1" cellpadding="4">
            <tr>
                <th bgcolor="#3385ff"><strong>ID</strong></th>
                <th bgcolor="#3385ff"><strong>Nosaukums</strong></th>
                <th class="min" bgcolor="#3385ff"><strong>Daudzums</strong></th>
                <th class="min" bgcolor="#3385ff"><strong>Cena</strong></th>
                <th bgcolor="#3385ff"><strong>Kategorija</strong></th>
                <th bgcolor="#3385ff"><strong>Apraksts</strong></th>
                <th class="min" bgcolor="#3385ff"></th>
                <th class="min" bgcolor="#3385ff"></th>
            </tr>
            <?php 
             while($row = mysqli_fetch_assoc($r)) {
            ?> 
                <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><a href = <?php echo "view_image.php?id=".$row["id"].""; ?>><?php echo $row["name"]; ?></a></td>
                <td class="min"><?php echo $row["amount"]; ?></td>
                <td class="min"><?php echo $row["price"]; ?></td>
                <td><?php echo $row["category"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                
                <?php if(isset($_GET['sort']) and isset($page)) { ?>
                    <td class="min"><a onClick="javascript: return confirm('Vai tiešām vēlaties dzēst?');" href=<?php echo "delete.php?id=".$row["id"]."&table=products&page=".$page."&sort=".$_GET['sort']."";?>>Dzēst</a></td>
                <?php } else if (!isset ($_GET['sort']) and isset ($page)) { ?>
                    <td class="min"><a onClick="javascript: return confirm('Vai tiešām vēlaties dzēst?');" href=<?php echo "delete.php?id=".$row["id"]."&table=products&page=".$page."";?>>Dzēst</a></td>
                <?php } else { ?>
                    <td class="min"><a onClick="javascript: return confirm('Vai tiešām vēlaties dzēst?');" href=<?php echo "delete.php?id=".$row["id"]."&table=products";?>>Dzēst</a></td>
                <?php } ?>
                
                <td class="min"><a href=<?php echo "modify.php?id=".$row["id"]."&table=products";?>>Mainīt</a></td>
                </tr>
            <?php 
            }
            ?>
            </table>
            <div class="pagination">
                <?php 
                $q = "SELECT COUNT(id) AS total FROM products";
                $r = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($r);
                echo mysqli_error($dbc);
                $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results

                for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                    if(!isset($_GET['sort'])) {    
                        echo "<a href='product_list.php?page=".$i."'";
                        if ($i==$page) { echo " class='curPage'"; }
                        echo ">".$i."</a> ";
                    } else {
                        echo "<a href='product_list.php?page=".$i."&sort=".$_GET['sort']."'";
                        if ($i==$page) { echo " class='curPage'"; }
                        echo ">".$i."</a> ";
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
