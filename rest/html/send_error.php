<?php

function sendError($statusCode = 500, $message = "Internal server error")
{
    $code = 500;
    $msg = "Internal server error";
    if (is_numeric($statusCode))
        $code = $statusCode;
    if (is_string($message))
        $msg = $message;

    http_response_code($code);
    echo $msg;
}
