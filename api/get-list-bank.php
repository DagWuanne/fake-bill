<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header('Content-Type: application/json;charset=utf8');
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
$results = DB::query("SELECT * FROM bank1 WHERE active = '1' ORDER BY id ASC");
echo json_encode($results);