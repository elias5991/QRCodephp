<?php

require_once('../utils/connection.php');
require_once('../utils/authentication.php');
require_once('../responses/error-response.php');
require_once('../responses/success-response.php');
require_once('../models/department.php');

/** Used to call the function needed. */
require_once('../utils/url.php');


function getAllDepartments()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(Department::getDepartment($mysqli));
    $mysqli->close();
}

function insertNewDepartment($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->value) || empty($data->value)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department required"));
        $mysqli->close();
        exit(0);
    }
    $valueToAdd = new Department (-1,$data->value);
    if ($valueToAdd->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated Department"));
        $mysqli->close();
        exit(0);
    }
    if (!$valueToAdd->create($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Department added successfully"));
    $mysqli->close();
}

function updateDepartment($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('PUT')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->value) || empty($data->value)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->id) || empty($data->id)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("ID Required"));
        $mysqli->close();
        exit(0);
    }
    $valueToUpdate = new Department ($data->id,$data->value);
    if ($valueToUpdate->sameValue($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("You Didn't Change Data"));
        $mysqli->close();
        exit(0);
    }

    if ($valueToUpdate->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated Department"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToUpdate->edit($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Department Updated Successfully"));
    $mysqli->close();
}

function deleteDepartment($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->value) || empty($data->value)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->id) || empty($data->id)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("ID Required"));
        $mysqli->close();
        exit(0);
    }
    $valueToDelete = new Department ($data->id,$data->value);

    if (!$valueToDelete->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department To Be Deleted Does Not Exist"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToDelete->delete($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Department Deleted Successfully"));
    $mysqli->close();
}
