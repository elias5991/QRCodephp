<?php

/** Returns a connection to the datatabase. */
function connect()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "uni_inventory";
    $con = mysqli_connect($host, $username, $password, $db) or die("Connection failed");
    return $con;
}
