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
        <meta charset="UTF-8">
        <title>Preces meklēšana</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php
            $results_per_page = 15;
            
            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
            //if (isset($_GET["sort"])) { $sort  = $_GET["sort"]; } else { $sort=0; }
            $start_from = ($page-1) * $results_per_page;
            if (isset($_GET['searchterm'])) {
                $searchterm = mysqli_real_escape_string($dbc, $_GET['searchterm']);
            }
            
            
            if(isset($_GET['sort']) and isset($searchterm)) {
                if($_GET['sort']==1) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "WHERE p.name LIKE '%".$searchterm."%'"
                            . " LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else if($_GET['sort']==2) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "WHERE c.name LIKE '%".$searchterm."%'"
                            . " LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                } else if($_GET['sort']==3) {
                    $q = "SELECT p.id, p.name, p.amount, p.price, c.name category, p.description"
                            . " FROM products p "
                            . "LEFT JOIN categories c"
                            . " ON p.category = c.id "
                            . "WHERE p.description LIKE '%".$searchterm."%'"
                            . " LIMIT ".$start_from.", ".$results_per_page;
                    $r = mysqli_query($dbc, $q);
                }
            }
        ?>
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel" id="product-list">
            <div class="sort">
                <form class="sort-form" action="search.php" method="get">
                    <label for="sort-by">Meklēt pēc:</label>
                    <select class="form-control" id="sort-by" name="sort">
                        <option value="0">-------</option>
                        <option value="1">Nosaukuma</option>
                        <option value="2">Katgorijas</option>
                        <option value="3">Apraksta</option>
                    </select>
                    <label for="searchterm">Meklējamā frāze:</label>
                    <input type="text" class="form-control" id="searchterm" name="searchterm"> 
                    <button id="sort" type="submit">Meklēt</button>
                </form>
            </div>
            <?php 
                if(isset($r)) {
                   if(mysqli_num_rows($r) > 0) { ?>
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
                            <td><?php echo $row["name"]; ?></td>
                            <td class="min"><?php echo $row["amount"]; ?></td>
                            <td class="min"><?php echo $row["price"]; ?></td>
                            <td><?php echo $row["category"]; ?></td>
                            <td><?php echo $row["description"]; ?></td>
                            <td class="min"><a href=<?php echo "delete.php?id=".$row["id"]."&table=products&page=".$page."&sort=".$_GET['sort']."&searchterm=".$searchterm."";?>>Dzēst</a></td>
                            <td class="min"><a href=<?php echo "modify.php?id=".$row["id"]."&table=products";?>>Mainīt</a></td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </table>  
                    <?php   
                    } else {
                       echo "<p>Diemžēl nekas netika atrasts...";
                    }
                } else {
                    echo "<p>Lūdzu, izvēlieties pēc kādas vērtības un frāzes meklēt!";
                }
                ?>
            <div class="pagination">
                <?php 
                if(isset($r)) {   
                    $total_pages = ceil(mysqli_num_rows($r) / $results_per_page); // calculate total pages with results

                    for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                        if(!isset($_GET['sort']) and !isset($searchterm)) {    
                            echo "<a href='search.php?page=".$i."'";
                            if ($i==$page) { echo " class='curPage'"; }
                            echo ">".$i."</a> ";
                        } else {
                            echo "<a href='search.php?page=".$i."&sort=".$_GET['sort']."&searchterm=".$searchterm."'";
                            if ($i==$page) { echo " class='curPage'"; }
                            echo ">".$i."</a> ";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
