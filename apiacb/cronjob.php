<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Content-Type'); // Cho phép tiêu đề Content-Type
require('../files/config.php');

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.web2m.com/historyapiacbv3/Doanhc9@/7387071/C8E6CDAD-514A-219B-9545-545CAD68AB62',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response, true);

if ($data['status'] == true) {
    $transactions = $data['transactions'];
    foreach ($transactions as $transaction) {
        $transactionID = $transaction['transactionID'];
        $amount = $transaction['amount'];
        $description = strtolower($transaction['description']);
        $transactionDate = $transaction['transactionDate'];
        $type = $transaction['type'];
        $id_bank = get_id_bank($description);
      
        if(DB::queryFirstField("SELECT COUNT(*) FROM transactions WHERE transaction_id = '$transactionID'") == 0 && $id_bank > 0){
        $today = date("d/m/Y");
        if($amount > 0 && $type == 'IN'){
            if($transactionID){
                    if($amount >=50000) $amount+=$amount*20/100;
                    DB::insert('transactions', [
                        'transaction_id' => $transactionID, // Giá trị của cột 'key'
                        'amount' => $amount,
                        'description' => $description,
                        'transaction_date' => $today,
                        'transaction_type' => $type// Giá trị của cột 'expires_time'
                    ]);
                   
                  DB::query("UPDATE users SET sodu=sodu+$amount WHERE id='$id_bank'");
 DB::query("UPDATE users SET tongtiennap=tongtiennap+$amount WHERE id='$id_bank'");
 DB::insert('notifications', [
  'notifications' => 'Đã nạp <b style="color:green">'.number_format($transaction['amount']).'</b> vào tài khoản',
  'username' => DB::queryFirstField("SELECT username FROM users WHERE id = '$id_bank'"),
  'amount' => $amount
]);
                   
                
            }
        }
        }
    }
} 
