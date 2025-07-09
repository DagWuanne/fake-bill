<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header('Content-Type: application/json;charset=utf8');
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
$results = DB::query("SELECT username,sodu,date_bill FROM users WHERE serial_key = '".trim(strip_tags($_GET['key']))."' ORDER BY id ASC");
echo json_encode($results);