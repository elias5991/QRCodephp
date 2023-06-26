<?php

require_once('../utils/connection.php');
require_once('../utils/authentication.php');
require_once('../responses/valid-response.php');
require_once('../models/role.php');
require_once('../models/account-type.php');
require_once('../responses/error-response.php');
require_once('../responses/success-response.php');
require_once('../models/room.php');
require_once('../models/faculty.php');

/** Used to call the function needed. */
require_once('../utils/url.php');

function getAllFaculties()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(Faculty::getFaculties($mysqli));
    $mysqli->close();
}

function getAllRooms()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }

    $mysqli = connect();
    echo json_encode(Room::getRoom($mysqli));
    $mysqli->close();
}

function insertNewRoom($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('POST')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->name) || empty($data->name)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->typeID) || empty($data->typeID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Type required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->space) || empty($data->space)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Space required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->departmentID) || empty($data->departmentID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->facultyID) || empty($data->facultyID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Faculty required"));
        $mysqli->close();
        exit(0);
    }
    $valueToAdd = new Room (null,$data->name, $data->typeID,null, $data->space,$data->departmentID ,null,$data->facultyID,null);
    if ($valueToAdd->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated Room"));
        $mysqli->close();
        exit(0);
    }
    if (!$valueToAdd->create($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Room Added Successfully"));
    $mysqli->close();
}

function updateRoom($data)
{
    $mysqli = connect();

    if (!requestMethodCheck('PUT')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    if (!isset($data->name) || empty($data->name)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Name required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->typeID) || empty($data->typeID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Type required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->space) || empty($data->space)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Space required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->departmentID) || empty($data->departmentID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Department required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->facultyID) || empty($data->facultyID)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Faculty required"));
        $mysqli->close();
        exit(0);
    }
    if (!isset($data->id) || empty($data->id)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("ID Required"));
        $mysqli->close();
        exit(0);
    }
    $valueToUpdate = new Room ($data->id,$data->name, $data->typeID,null, $data->space,$data->departmentID ,null,$data->facultyID,null);
    if ($valueToUpdate->sameValue($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("You Didn't Change Data"));
        $mysqli->close();
        exit(0);
    }

    if ($valueToUpdate->valueExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Duplicated Room"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToUpdate->edit($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Room Updated Successfully"));
    $mysqli->close();
}

function deleteRoom($data)
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
    $valueToDelete = new Room ($data->id,null,null,null,null,null,null,null,null);

    if (!$valueToDelete->idExists($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Room To Be Deleted Does Not Exist"));
        $mysqli->close();
        exit(0);
    }

    
    if (!$valueToDelete->delete($mysqli)) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Server error"));
        $mysqli->close();
        exit(0);
    }
    echo json_encode(new SuccessResponse("Room Deleted Successfully"));
    $mysqli->close();
}

function roomExists()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    $room = new Room ($_GET['roomId'],null,null,null,null,null,null,null,null);


    $mysqli = connect();
    echo json_encode(new Valid($room->idExists($mysqli)));
    $mysqli->close();
}

function getCurrentRoom()
{
    if (!requestMethodCheck('GET')) {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(new ErrorResponse("Method not allowed"));
        exit(0);
    }
    $room = new Room ($_GET['roomId'],null,null,null,null,null,null,null,null);


    $mysqli = connect();
    echo json_encode($room->getRoomById($mysqli));
    $mysqli->close();
}
