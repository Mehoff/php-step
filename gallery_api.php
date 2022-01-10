<?php

@include "send_error.php";

$method = strtoupper($_SERVER['REQUEST_METHOD']);

switch ($method) {
    case 'POST':
        onPOST();
    case 'GET':
        onGET();
        break;
}

function onGET()
{
    $DB = connectDB();
    if (is_string($DB)) {
        sendError(404, "Failed to GET: $DB");
        exit;
    }
    $query = "SELECT * FROM pictures";
    $result = $DB->query($query);
    if ($result === false) {
        sendError(404, "Failed to GET: Error occured on DB query");
        exit;
    }

    // echo json_encode([
    //     'data' => $result->fetchAll(PDO::FETCH_ASSOC)
    // ], JSON_UNESCAPED_UNICODE);

    echo json_encode([
        'data' => array(
            'pictures' => $result->fetchAll(PDO::FETCH_ASSOC)
        )
    ], JSON_UNESCAPED_UNICODE);
}

function onPOST()
{

    echo $_FILES['pictureFile'];
    //$query = "INSERT INTO pictures(filename, description) VALUES(?, ?)";
}

function connectDB()
{
    unset($db_config);
    @include "db_config.php";
    if (empty($db_config)) {
        return "Failed to read database connection configuration";
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
        return $ex->getMessage();
    }
    return $DB;
}
