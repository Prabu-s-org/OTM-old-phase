<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', '0');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
error_reporting(0);

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/dbclass.php';

$driver = project_env('APP_DB_DRIVER', 'mysql');
$host = project_env('APP_DB_HOST', 'localhost');
$username = project_env('APP_DB_USERNAME', 'root');
$password = project_env('APP_DB_PASSWORD');
$databasename = project_env('APP_DB_NAME', 'operation_team_beta');
$dbPort = project_env('APP_DB_PORT', '3306');

$pdo = new Db($driver, $host, $username, $password, $databasename);
try {
    $conn = new PDO($driver . ':host=' . $host . ';port=' . $dbPort . ';dbname=' . $databasename, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    error_log($e->getMessage());
}

require_once __DIR__ . '/comfun.php';
require_once __DIR__ . '/SecureUPload/src/autoloader.php';
try {
    $fileUploadConfig = new Alirdn\SecureUPload\Config\SecureUPloadConfig();
    $fileUploadConfig->setArray([
        'upload_folder' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR,
    ]);
} catch (Alirdn\SecureUPload\Exceptions\UploadFolderException $exception) {
    error_log($exception->getMessage());
    die('Upload configuration error.');
}
?>
