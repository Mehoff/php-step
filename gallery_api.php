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

    $query = "SELECT * FROM pictures";
    $result = $DB->query($query);
    if ($result === false) {
        sendError(404, "Failed to GET: Error occured on DB query");
    }

    echo json_encode([
        'data' => array(
            'pictures' => $result->fetchAll(PDO::FETCH_ASSOC)
        )
    ], JSON_UNESCAPED_UNICODE);
}

function onPOST()
{

    if (
        !isset($_FILES['pictureFile']['error']) ||
        is_array($_FILES['pictureFile']['error']) ||
        !isset($_POST['title']) ||
        !isset($_POST['description'])
    ) {
        sendError(500, 'Invalid parameters.');
    }


    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

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

    // if (!move_uploaded_file(
    //     $_FILES['pictureFile']['tmp_name'],
    //     sprintf(
    //         './uploads/%s.%s',
    //         $filename,
    //         'jpeg'
    //     )
    // )) 

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

    $sql = 'INSERT INTO pictures(title, filename, description) VALUES(:title, :filename, :description)';

    try {
        $statement = $DB->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':filename' => $filename,
            ':description' => $description
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
        'description' => $description
    ]);
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
