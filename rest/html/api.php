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

function tryGetParameterValue($param_name, $source)
{
    $data = $source[$param_name];

    if (is_null($data)) {
        sendError(400, "Bad request. Required parameter '$param_name' is missing");
    }

    return $data;
}

function tryParseJson($file_path = "php://input")
{
    $body = file_get_contents("$file_path");
    $data = json_decode($body, true);

    if (JSON_ERROR_NONE !== json_last_error()) {
        sendError(412, "Json parse error");
    }

    return $data;
}

function onPOST()
{
    $contentType = strtolower(trim($_SERVER['CONTENT_TYPE']));

    if ($contentType == "application/json") {
        $data = tryParseJson();

        $a = tryGetParameterValue('a', $data);
        $b = tryGetParameterValue('b', $data);

        echo $a + $b;
    } else {
        sendError(415, "Unsupported Media Type");
    }
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
