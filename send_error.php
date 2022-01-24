<?php

const LOG_FILE = "gallery_err.log";

function sendError($statusCode = 500, $message = "Internal server error")
{
    $code = 500;
    $msg = "Internal server error";
    if (is_numeric($statusCode))
        $code = $statusCode;
    if (is_string($message))
        $msg = $message;

    echo json_encode([
        'message' => $msg,
        'code' => $code
    ]);
    exit;
}

function logError($err_text)
{
    $f = fopen(LOG_FILE, "a");
    fwrite($f, date("r") . " " . $err_text . "\r\n");
    fclose($f);
}
