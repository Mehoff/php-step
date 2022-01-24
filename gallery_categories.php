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

    if (isset($_GET['name'])) {

        $name = $_GET["name"];

        $statement = $DB->prepare("SELECT COUNT(*) from categories WHERE name = :name");
        $statement->execute([
            ':name' => $name
        ]);
        $row = $statement->fetch(PDO::FETCH_NUM);

        echo json_encode([
            'data' => array(
                'exists' => $row[0]
            )
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $query = "SELECT * FROM categories";
    $result = $DB->query($query);
    if ($result === false) {
        sendError(404, "Failed to GET: Error occured on DB query\n" . $query);
        exit;
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

    if (
        !isset($_POST['name'])
    ) {
        sendError(404, "New category name is not set");
        exit;
    }

    $name = $_POST['name'];

    $statement = $DB->prepare("SELECT COUNT(*) from categories WHERE name = :name");
    $statement->execute([
        ':name' => $name
    ]);
    $row = $statement->fetch(PDO::FETCH_NUM);

    if ($row[0] == 1) {
        sendError(500, "Category with this name already exists");
        exit;
    }

    try {
        $statement = $DB->prepare("INSERT INTO categories(name) VALUES (:name)");
        $statement->execute([
            ':name' => $name
        ]);
        $id = $DB->lastInsertId();
        echo json_encode([
            'data' => array(
                'id' => $id,
                'name' => $name
            )
        ]);
        exit;
    } catch (PDOException $ex) {
        sendError(500,  $ex->getMessage());
        exit;
    }


    // Insert new category here
}
