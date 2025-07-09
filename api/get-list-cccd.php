<?php
header('Content-Type: application/json');
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
echo json_encode(DB::query("SELECT * FROM history_cccd WHERE pending = '1'"));