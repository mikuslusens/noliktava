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
        <title>Kategoriju saraksts</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <?php
            $results_per_page = 15;
            
            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
            $start_from = ($page-1) * $results_per_page;
            $q = "SELECT * FROM categories ORDER BY id ASC LIMIT ".$start_from.", ".$results_per_page;
            $r = mysqli_query($dbc, $q);
//            echo mysqli_error($dbc);
//            echo $q;
        ?> 
        <div class="back">
            <a href="index.php">Atpakaļ uz sākumu</a>
        </div>
        <div class="panel">
            <table width="100%" border="1" cellpadding="4">
            <tr>
                <th bgcolor="#3385ff"><strong>ID</strong></th>
                <th bgcolor="#3385ff"><strong>Nosaukums</strong></th>
                <th class="min" bgcolor="#3385ff"></th>
                <th class="min" bgcolor="#3385ff"></th>
            </tr>
            <?php 
             while($row = mysqli_fetch_assoc($r)) {
            ?> 
                <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td class="min"><a onClick="javascript: return confirm('Vai tiešām vēlaties dzēst?');" href=<?php echo "delete.php?id=".$row["id"]."&table=categories";?>>Dzēst</a></td>
                <td class="min"><a href=<?php echo "modify.php?id=".$row["id"]."&table=categories";?>>Mainīt</a></td>
                </tr>
            <?php 
            }
            ?>
            
            </table>
            <div class="pagination">
                <?php 
                $q = "SELECT COUNT(id) AS total FROM categories";
                $r = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($r);
                echo mysqli_error($dbc);
                $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results

                for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                    echo "<a href='category_list.php?page=".$i."'";
                    if ($i==$page) { echo " class='curPage'"; }
                    echo ">".$i."</a> "; 
                }
                ?>
            </div>
        </div>
    </body>
</html>
