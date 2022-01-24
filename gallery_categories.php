<?php

@include "send_error.php";
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


function connectDB()
{
    unset($db_config);
    @include "db_config.php";
    if (empty($db_config)) {
        sendError(500, "Failed to read database connection configuration");
    }

    try {
        $DB = new PDO(
            "{$db_config['type']}:"
                . "host={$db_config['host']};"
                . "port={$db_config['port']};"
                . "dbname={$db_config['name']};"
                . "charset={$db_config['char']}",
            $db_config['user'],
            $db_config['pass'],
        );
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        sendError(500, $ex->getMessage());
    }
    return $DB;
}
