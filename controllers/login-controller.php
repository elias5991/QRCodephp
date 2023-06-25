<?php
require_once('../utils/connection.php');
require_once('../utils/authentication.php');
require_once('../models/account.php');
require_once('../responses/error-response.php');
require_once('../responses/valid-response.php');

/** Used to call the function needed. */
require_once('../utils/url.php');

function login($data)
{
    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->email)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Email required"));
        exit(0);
    }
    if (!isset($data->password)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Password required"));
        exit(0);
    }

    $mysqli = connect();
    $user = Account::getByEmail($mysqli, $data->email);
    if ($user == null || $data->password != $user->password) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Wrong Credentials"));
        $mysqli->close();
        exit(0);
    }

    echo json_encode(new Valid("true"));
    $mysqli->close();
}