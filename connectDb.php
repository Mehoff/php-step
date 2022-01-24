<?php
function connectDB()
{
    unset($db_config);
    @include "db_config.php";
    if (empty($db_config)) {
        sendError(500, "Failed to read database connection configuration");
    }
    try {
        $DB = new PDO("{$db_config['type']}:" . "host={$db_config['host']};" . "port={$db_config['port']};" . "dbname={$db_config['name']};" . "charset={$db_config['char']}", $db_config['user'], $db_config['pass'],);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        sendError(500, $ex->getMessage());
    }
    return $DB;
}
