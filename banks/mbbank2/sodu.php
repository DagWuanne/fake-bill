      <form action="" method="POST">
                                <div class="space-y-4">

                                <div>
                                    <label class="block text-sm font-medium mb-1" for="card-name">Tên chủ tài khoản <span class="text-rose-500">*</span></label>
                                    <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Viết hoa, ví dụ: VO HUU NHAN" required name="name" value="<?=$_POST['name']?>"/>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="card-name">Tài khoản nguồn <span class="text-rose-500">*</span></label>
                                    <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 2312004" required name="stk" value="<?=$_POST['stk']?>"/>
                                </div>
                                 <div>
                                    <label class="block text-sm font-medium mb-1" for="card-name">Số dư tài khoản <span class="text-rose-500">*</span></label>
                                    <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 50000000" required name="amount" value="<?=$_POST['amount']?>"/>
                                </div>
                                 <div>
                                    <label class="block text-sm font-medium mb-1" for="card-name">Điểm thưởng <span class="text-rose-500">*</span></label>
                                    <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 5000" required name="diemthuong" value="<?=$_POST['diemthuong']?>"/>
                                </div>
                                 <div class="flex items-center justify-between">
                                    <button class="btn bg-rose-500 hover:bg-rose-600 text-white" type="submit">Fake số dư (<?=number_format(0)?>)</button>
                                    
                                </div></div>
                                </form><br/>
<?php
if(isset($_POST['amount'])){
$sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '".$_SESSION['username']."'");
if($sodu >= 0){
       DB::query("UPDATE users SET sodu=sodu-0 WHERE username='".$_SESSION['username']."'");
    function khhaha($image, $fontsize, $y, $textColor, $font, $text) {
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}

// Tạo ảnh mới
$image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/banks/mbbank/mb.png');

// Viết văn bản lên ảnh
khhaha($image, 45, 350, imagecolorallocate($image, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Bold.otf', $_POST['name']);
imagettftext($image, 28, 0, 391, 1019, imagecolorallocate($image, 125, 140, 153), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stk']);
imagettftext($image, 26, 0, 341, 1245, imagecolorallocate($image, 125, 140, 153), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', number_format($_POST['diemthuong']).' Point');


$number = $_POST['amount'];
$vndText = ' VND';
$vndFont = $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Bold.otf';
$numberSize = 41;
$vndSize = 25;

$numberBox = imagettfbbox($numberSize, 0, $vndFont, number_format($number));
$numberWidth = $numberBox[2] - $numberBox[0];
$numberX = 90;
$numberY = 1085;
imagettftext($image, $numberSize, 0, $numberX, $numberY, imagecolorallocate($image, 125, 140, 153), $vndFont, number_format($number));

$vndBox = imagettfbbox($vndSize, 0, $vndFont, $vndText);
$vndWidth = $vndBox[2] - $vndBox[0];
$vndX = $numberX + $numberWidth + 10;
$vndY = 1085;
imagettftext($image, $vndSize, 0, $vndX, $vndY, imagecolorallocate($image, 116, 116, 116), $vndFont, $vndText);


// Lưu ảnh vào một biến dạng base64
ob_start();
imagepng($image);
$imageData = ob_get_clean();
$base64 = base64_encode($imageData);

// Xuất ảnh dưới dạng base64
echo '<img width="300px" src="data:image/png;base64,' . $base64 . '" alt="Image" />';

// Giải phóng bộ nhớ
imagedestroy($image);
} else {
    echo '<script>alert("Số dư tài khoản không đủ")</script>';
}
}
?>