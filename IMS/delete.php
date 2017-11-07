<?php
include('config/session.php');
include('config/setup.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$id = mysqli_real_escape_string($dbc, $_GET['id']);
$table = mysqli_real_escape_string($dbc, $_GET['table']);

// security measure

if(isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 'regular') {
        if($table == 'users') {
            header('Location: index.php');
        }
    } 
}

$q = "DELETE FROM $table WHERE id = $id"; 

if (mysqli_query($dbc, $q)) {
    if($table == "categories") {
        header('Location: category_list.php');
        exit;
    }
    else if($table == "products") {
        if(isset($_GET['sort']) and isset($_GET['searchterm'])) {
            header("Location: search.php?page=".$_GET['page']."&sort=".$_GET['sort']."&searchterm=".$_GET['searchterm']."");
            exit;
        } else if (isset($_GET['sort']) and !isset($_GET['searchterm'])) {
            header("Location: product_list.php?page=".$_GET['page']."&sort=".$_GET['sort']."");
            exit;
        } else {
            header('Location: product_list.php');
            exit;
        }
    } else if($table == "users") {
        header('Location: user_list.php');
        exit;
    }
} else {
    echo "Error deleting record";
    echo mysqli_error($dbc);
}

?>

