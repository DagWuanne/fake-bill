<?php
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
function canletrai($image,$fontsize,$y,$textColor,$font,$text,$x_tcb){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    imagettftext($image, $fontSize, 0, $x_tcb, $y, $textColor, $font, $text);

}
function cangiua($image, $fontsize, $y, $textColor, $font, $text) {
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}
 function alignRight($image, $text, $font, $size, $color, $y,$nhan=130)
        {
            $bbox = imagettfbbox($size, 0, $font, $text);
            $text_width = $bbox[2] - $bbox[0];
            $x = imagesx($image) - $text_width - $nhan; // Điều chỉnh giá trị 10 tùy theo lề phải mong muốn
            imagettftext($image, $size, 0, $x, $y, $color, $font, $text);
        }
        function convertCurrencyToWords($amount)
{
  $data = file_get_contents('http://forum.vdevs.net/nossl/mtw.php?number='.$amount);
$data = json_decode($data, true);
if ($data['success'] == true) {
    return htmlspecialchars($data['result']);
}
}

$fontPath =  $_SERVER['DOCUMENT_ROOT'].'/fonts';
if(isset($_GET['type'])){

    $username;
    
    if(isset($_POST['key'])){
        $username = DB::queryFirstField("SELECT username FROM users WHERE serial_key = '".trim($_POST['key'])."'");
    }
    
    if(!empty($username) || $_GET['type'] == 'demo'){
         $timestampHetHan = strtotime(DB::queryFirstField("SELECT date_bill FROM `users` WHERE username = '$username'"));
            if (time() < $timestampHetHan) {
                $tiengoc = 0;
            }
        $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
        if($_GET['type'] == 'demo'){
            $tiengoc = 0;
            $watermark = 1;
        } else {
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
            if($sodu >= $tiengoc){
            DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
            $watermark = 0;
            DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='$username'");
             DB::insert('notifications', [
  'notifications' => 'Đã tạo 1 biến động số dư, số tiền trừ '.$tiengoc,
  'username' => $username,
  'amount' => $tiengoc
]);
            }
        }
       $theme = 'vcb01.png';
        if(empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['sdc'])) || empty(trim($_POST[stkgui])) || empty(trim($_POST['time_bill']))){
            die ('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if($sodu >= $tiengoc){
            {
             $sourceImage = imagecreatefrompng($theme);
             if($watermark == 1){
        canchinhgiua($sourceImage, 30, 400, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                  canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút'."\n".'"Tải ảnh gốc" để xóa dòng chữ này'."\n".'Đây chỉ là demo để xem trước khi tải');
             }
             
            imagettftext($sourceImage, 38, 0, 140, 105, imagecolorallocate($sourceImage, 255,255,255), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
            $overlayImagePath = $_SERVER['DOCUMENT_ROOT'].'/banks/techcombank/pin_ios/'.$_POST['pin'].'.png';
            imagettftext($sourceImage, 29, 0, 105, 690, imagecolorallocate($sourceImage, 195,198,199), $fontPath.'/Inter/Inter-Medium.ttf', $_POST['time_bill']);
            imagettftext($sourceImage, 29, 0, 1110, 690, imagecolorallocate($sourceImage, 195,198,199), $fontPath.'/Inter/Inter-Medium.ttf', $_POST['time_dt']);
            if($_POST['type'] == 'congtien'){
                $dau = '+';
            }
            if($_POST['type'] == 'trutien'){
                $dau = '-';
            }
            $string = $_POST['time_bill'];

            // Chuyển đổi chuỗi thành đối tượng DateTime
            $date = DateTime::createFromFormat('d/m/Y', $string);
            
            // Lấy ngày và định dạng lại nếu cần
            $ngay = $date->format('d/m/Y');
           
            imagettftext($sourceImage, 30, 0, 110, 820, imagecolorallocate($sourceImage, 000), $fontPath.'/Inter/Inter-Regular.ttf', 'Số dư TK VCB '.$_POST['stkgui'].' '.$dau.' '.number_format($_POST['amount']).' VND lúc '.$_POST['time_dt']."\n".$ngay.' So du '.number_format($_POST['sdc']).'. Ref: MBVCB.'.rand(00000,99999999999)."\n".'.'.rand(00000,999999).' '.$_POST['noidung']);
            $overlayImagePath = $_SERVER['DOCUMENT_ROOT'].'/banks/vietcombank/pin_ios/'.$_POST['pin'].'.png';
            // Đọc ảnh sẽ được chèn
            $overlayImage = imagecreatefrompng($overlayImagePath);
             $newWidth = 91;
            $newHeight = 42;
            $pinx = 1090;
            $piny = 70;
            // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
            // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
            if (function_exists('imagescale')) {
                $scaledOverlayImage = imagescale($overlayImage, $newWidth, $newHeight);
            } else {
                // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                $scaledOverlayImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($scaledOverlayImage, $overlayImage, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage), imagesy($overlayImage));
            }
            
            // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
         
            
            // Chèn ảnh vào ảnh cơ sở
            imagecopy($sourceImage, $scaledOverlayImage, $pinx, $piny, 0, 0, $newWidth, $newHeight);
            
           ob_start();

            // Hiển thị ảnh vào output buffer
            imagepng($sourceImage, null, 9);
            
            // Lấy nội dung đối tượng đầu ra (output buffer)
            $imageData = ob_get_clean();
            
            // Chuyển đổi ảnh thành base64
            $base64Image = base64_encode($imageData);
            
            // In thẻ img với src là dữ liệu base64
            echo '<img onclick="taiAnh()" class="w-full" src="data:image/png;base64,' . $base64Image . '" alt="Generated Image">';
            
            // Giải phóng bộ nhớ
            imagedestroy($sourceImage);
            imagedestroy($scaledOverlayImage);
            imagedestroy($overlayImage);
            }
        } else {
            echo '<span style="color:red">Số dư không đủ</span>';
        }
    } else {
        echo '<span style="color:red">Tài khoản không hợp lệ!</span>';
    }
}