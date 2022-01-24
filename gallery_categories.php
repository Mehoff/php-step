<?php

@include "send_error.php";
@include "connectDb.php";
error_reporting(0);



$method = strtoupper($_SERVER['REQUEST_METHOD']);

switch ($method) {
    case 'POST':
        onPOST();
        break;
    case 'GET':
        onGET();
        break;
    default:
        sendError(502, 'Unsupported method type');
}

function onGET()
{
    $DB = connectDB();
    if (is_string($DB)) {
        sendError(404, "Failed to GET: $DB");
        exit;
    }

    $query = "SELECT * FROM categories";
    $result = $DB->query($query);
    if ($result === false) {
        sendError(404, "Failed to GET: Error occured on DB query\n" . $query);
    }

    echo json_encode([
        'data' => array(
            'categories' => $result->fetchAll(PDO::FETCH_ASSOC)
        )
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function onPOST()
{
    $DB = connectDB();
    if (is_string($DB)) {
        sendError(404, "Failed to GET: $DB");
        exit;
    }

    // Insert new category here

    echo json_encode([
        'error' => 'Not implemented'
    ]);
    exit;
}
