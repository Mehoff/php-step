<?php

$method = strtoupper($_SERVER['REQUEST_METHOD']);

switch ($method) {
    case 'GET':
        onGET();
        break;
    case 'POST':
        onPOST();
        break;
    case 'PATCH':
        onPATCH();
        break;
    case 'DELETE':
        onDELETE();
        break;
    default:
        sendError(418);
}


function is_get_parameter_set($param_name = '')
{
    if (!isset($_GET[$param_name])) {
        sendError(412, "[ERROR] Parameter $param_name is required!");
    }
}

function is_get_parameter_numeric($param_name = '')
{
    if (!is_numeric($_GET[$param_name])) {
        sendError(412, "[ERROR] Parameter $param_name is not numeric, but it is required!");
    }
}

function onGET()
{
    is_get_parameter_set('x');
    is_get_parameter_numeric('x');

    is_get_parameter_set('y');
    is_get_parameter_numeric('y');

    var_dump($_GET);
}

function onPOST()
{
    $contentType = strtolower(trim($_SERVER['CONTENT_TYPE']));

    if ($contentType == "application/json") {
    }

    var_dump($_POST);

    $body = file_get_contents("php://input");
}

function onDELETE()
{
    http_response_code(200);
    echo "Hello, this is DELETE from API";
}

function onPATCH()
{
    http_response_code(200);
    echo "Hello, this is PATCH from API";
}

function sendError($code = 500, $error_message = "[ERROR] Internal server error")
{
    http_response_code($code);
    echo $error_message;
    exit;
}
