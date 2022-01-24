<?php

@include "send_error.php";
@include "connectDb.php";

error_reporting(0);

$GLOBALS['PICTURES_LIMIT'] = 3;


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

    if (!isset($_GET['page']) || !isset($_GET['category'])) {
        sendError(404, 'Needed parameter is missing');
        exit;
    }

    $PAGE = $_GET['page'];

    if (!is_numeric($PAGE)) {
        echo json_encode([
            'error' => 'Page is not a number'
        ]);
        exit;
    }

    $OFFSET = $PAGE * $GLOBALS['PICTURES_LIMIT'];

    $query = "SELECT * FROM pictures";

    if ($_GET['category'] != 'all') {
        $query = $query . " WHERE categoryId = " . $_GET['category'];
    }

    $query = $query . " LIMIT " . $GLOBALS['PICTURES_LIMIT'] . " OFFSET " . $OFFSET;

    $result = $DB->query($query);
    if ($result === false) {
        sendError(404, "Failed to GET: Error occured on DB query");
    }

    echo json_encode([
        'data' => array(
            'pictures' => $result->fetchAll(PDO::FETCH_ASSOC),
            'query' => $query
        )
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function onPOST()
{
    if (
        !isset($_FILES['pictureFile']['error']) ||
        is_array($_FILES['pictureFile']['error']) ||
        !isset($_POST['title']) ||
        !isset($_POST['description']) ||
        !isset($_POST['category'])
    ) {
        sendError(500, 'Invalid parameters.');
    }


    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $categoryId = trim($_POST['category']);

    if ($categoryId == 'all') {
        $categoryId = NULL;
    }

    switch ($_FILES['pictureFile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            sendError(500, 'No file sent.');
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            sendError(500, 'Exceeded filesize limit.');
            break;
        default:
            sendError(500, 'Unknown errors.');
    }

    if ($_FILES['pictureFile']['size'] > 1000000) {
        sendError(500, 'Exceeded filesize limit.');
    }

    // TODO: Get file`s ext
    $filename = sha1_file($_FILES['pictureFile']['tmp_name']) . ".jpeg";

    if (!move_uploaded_file(
        $_FILES['pictureFile']['tmp_name'],
        sprintf(
            './uploads/%s',
            $filename
        )
    )) {
        sendError(500, 'Failed to move uploaded file.');
    }

    $DB = connectDB();
    if (is_string($DB)) {  // string - means error
        sendError(
            507,
            "Internal error 1.1"
        );
    }

    $sql = 'INSERT INTO pictures(title, filename, description, categoryId) VALUES(:title, :filename, :description, :categoryId)';

    try {
        $statement = $DB->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':filename' => $filename,
            ':description' => $description,
            ':categoryId' => $categoryId
        ]);
    } catch (PDOException $ex) {
        sendError(
            501,
            $ex->getMessage()
        );
    }

    echo json_encode([
        'code' => 200,
        'title' => $title,
        'filename' => $filename,
        'description' => $description,
        'categoryId' => $categoryId
    ]);
    exit;
}


// Handle GET parameters to edit query (category, date)
            
            // Query example
            // $query = "
            // SELECT 
            //     G.id,
            //     G.filename,
            //     G.moment,
            //     A.iso639_1,
            //     L.txt AS descr
            // FROM 
            //     Gallery G 
            //     JOIN Literals L ON L.id_entity = G.id
            //     JOIN Langs A ON L.id_lang = A.id
            // " ;
