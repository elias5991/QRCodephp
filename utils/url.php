<?php

/**
 * Used to get the function from the URL & extract data from the request.
 */
$json = file_get_contents('php://input');
$data = json_decode($json);

if (isset($_GET['f'])) {
    if (function_exists($_GET['f'])) {
        if ($data == null)
        {
            $_GET['f']($_GET);
        }
        else
        {
            $_GET['f']($data);
        }
    }
}


/** Used to check request method */
function requestMethodCheck($method)
{
    if ($_SERVER['REQUEST_METHOD'] == $method) {
        return true;
    }
    return false;
}