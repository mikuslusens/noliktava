<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dbc = mysqli_connect('localhost', 'dev', 'securepassword', 'inventory_system') OR die('Could not connect because: '.mysqli_connect_error());
mysqli_set_charset($dbc, "utf8");

