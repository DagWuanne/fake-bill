<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
$bank = trim($_GET['bank']);
$type = trim($_GET['type']);
$directory = $_SERVER['DOCUMENT_ROOT'].'/banks/'.$bank.'/pin_'.$type;

// Lấy danh sách tên file trong thư mục
$files = scandir($directory);

// Loại bỏ các phần tử không cần thiết (. và ..)
$files = array_diff($files, array('..', '.'));

$i = 0;
foreach ($files as $file) {
    if($i == 0){
        $check = 'checked';
    } else {
        $check = '';
    }
    echo '<div class="col-lg-2 col-2 mb-2"><div class="form-check form-check-primary mt-3">
            <input '.$check.' name="pin" class="form-check-input" type="radio" value="'.str_replace('.png','',$file).'" id="pin'.str_replace('.png','',$file).'" checked="">
            <label class="form-check-label" for="pin'.str_replace('.png','',$file).'">  <img style="height: 20px!important; object-fit: contain; background-color: #bebebe;" src="https://fakebillx.com/banks/'.$bank.'/pin_'.$type.'/'.$file.'" alt="radioImg" /> </label>
          </div></div>';

    $i++;
}
