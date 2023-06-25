<?php
require_once('../utils/connection.php');
require_once('../utils/authentication.php');
require_once('../models/account.php');
require_once('../responses/error-response.php');
require_once('../responses/valid-response.php');
require_once('../models/role.php');
require_once('../models/account-type.php');
require_once('../responses/success-response.php');


/** Used to call the function needed. */
require_once('../utils/url.php');
function getAllRoleTypes()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(Role::getRoles($mysqli));
    $mysqli->close();
}

function getAllAccTypes()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(AccountType::getAccTypes($mysqli));
    $mysqli->close();
}
function getCurrentUser()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    
    $mysqli = connect();
    $user = Account::getByEmail($mysqli, $_GET['email']);

    echo json_encode($user);
    $mysqli->close();
}

function getUsers()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(Account::getAllUsers($mysqli));
    $mysqli->close();
}

function insertNewUser($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->firstName) || empty($data->firstName)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("First Name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->lastName) || empty($data->lastName)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Last name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->email) || empty($data->email)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Email required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->typeID) || empty($data->typeID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Type required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->password) || empty($data->password)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Password required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->roleID) || empty($data->roleID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Role required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->phoneNumber) || empty($data->phoneNumber)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Phone Number required"));
        $mysqli->close();
        exit(0);
    }
    $valueToAdd = new Account (null,$data->email,null,$data->typeID,$data->password,$data->firstName,$data->lastName,null,$data->roleID,$data->phoneNumber);
    if ($valueToAdd->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated User"));
        $mysqli->close();
        exit(0);
    }
    if (!$valueToAdd->create($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("User Added Successfully"));
    $mysqli->close();
}

function updateUser($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('PUT')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->firstName) || empty($data->firstName)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("First Name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->lastName) || empty($data->lastName)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Last name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->email) || empty($data->email)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Email required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->typeID) || empty($data->typeID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Type required"));
        $mysqli->close();
        exit(0);
    }
    
    if (!isset($data->roleID) || empty($data->roleID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Role required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->phoneNumber) || empty($data->phoneNumber)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Phone Number required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->id) || empty($data->id)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("ID Required"));
        $mysqli->close();
        exit(0);
    }
    $valueToUpdate = new Account ($data->id,$data->email,null,$data->typeID,null,$data->firstName,$data->lastName,null,$data->roleID,$data->phoneNumber);
    if ($valueToUpdate->sameValue($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("You Didn't Change Data"));
        $mysqli->close();
        exit(0);
    }

    if ($valueToUpdate->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated Room Type"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToUpdate->edit($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Room Type Updated Successfully"));
    $mysqli->close();
}

function deleteUser($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    if (!isset($data->id) || empty($data->id)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("ID Required"));
        $mysqli->close();
        exit(0);
    }
    $valueToDelete = new Account ($data->id,null,null,null,null,null,null,null,null,null);

    if (!$valueToDelete->idExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("User To Be Deleted Does Not Exist"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToDelete->delete($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Deleted Successfully"));
    $mysqli->close();
}
