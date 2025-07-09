<?php
$magd = 'FT'.rand(0000000000,9999999999);
session_start();
?>
    <style>

        .grid-cols-5 {
    grid-template-columns: repeat(6, minmax(0, 1fr));
}




    </style>
<?php
$pins = array(
    'pin1' => 'https://taobillck.com/uploads/6565889bec626.png',
    'pin3' => 'https://taobillck.com/uploads/656588aa10c85.png',
    'pin4' => 'https://taobillck.com/uploads/656588b4161c0.png',
    'pin5' => 'https://taobillck.com/uploads/656588bd89995.png',
    'pin6' => 'https://taobillck.com/uploads/656588cb11d0e.png',
    'pin7' => 'https://taobillck.com/uploads/656588d184153.png',
    'pin2' => 'https://taobillck.com/uploads/656588d797e63.png'
);
if(isset($_SESSION['username'])){
    if(isset($_POST['time'])){
 $time1 = trim($_POST['time1']);
  $nd1 = trim($_POST['nd1']);
   $time2 = trim($_POST['time2']);
  $nd2 = trim($_POST['nd2']);
   $time3 = trim($_POST['time3']);
  $nd3 = trim($_POST['nd3']);
   $pin = trim($_POST['pin']);
   $time4 = trim($_POST['time4']);
  $nd4 = trim($_POST['nd4']);
    $time = trim($_POST['time']);

$sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '".$_SESSION['username']."'");

if($sodu >= $tiengoc){
$imageUrl = $_SERVER['DOCUMENT_ROOT'].'/banks/mbbank/billmb2.png';

// Tải ảnh từ URL

// Tạo ảnh từ dữ liệu ảnh
$image = imagecreatefrompng($imageUrl);

$fontPath = $_SERVER['DOCUMENT_ROOT'].'/fonts';


function canlephai($image,$fontsize,$y,$textColor,$font,$text){


    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 60 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

}
function canletrai($image,$fontsize,$y,$textColor,$font,$text,$box2 = 270){


    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    imagettftext($image, $fontSize, 0, $box2, $y, $textColor, $font, $text);

}
function canchinhgiua33($image, $fontsize, $y, $textColor, $font, $text) {
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}


canlephai($image, 25, 580, imagecolorallocate($image, 105,105,105), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $time1);
canletrai($image, 22, 625, imagecolorallocate($image, 0, 0, 0), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $nd1,37);
canlephai($image, 25, 895, imagecolorallocate($image, 105,105,105), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $time2);
canletrai($image, 22, 935, imagecolorallocate($image, 0, 0, 0), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $nd2,37);
canlephai($image, 25, 1200, imagecolorallocate($image, 105,105,105), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $time3);
canletrai($image, 22, 1245, imagecolorallocate($image, 0, 0, 0), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $nd3,37);
canlephai($image, 25, 1520, imagecolorallocate($image, 105,105,105), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $time4);
canletrai($image, 22, 1565, imagecolorallocate($image, 0, 0, 0), $fontPath.'/AvertaStd/AvertaStd-Regular.otf', $nd4,37);
if(isset($_POST['primary'])){
    DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='".$_SESSION['username']."'");
     DB::insert('notifications', [
  'notifications' => 'Đã tạo 1 biến động số dư, số tiền trừ '.$tiengoc,
  'username' => $_SESSION['username'],
  'amount' => $tiengoc
]);
}
if(isset($_POST['demo'])){
     canchinhgiua($image, 25, 400, imagecolorallocate($image, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                  canchinhgiua($image, 25, 1140, imagecolorallocate($image, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút'."\n".'"Tải ảnh gốc" để xóa dòng chữ này'."\n".'Đây chỉ là demo để xem trước khi tải');
}
imagettftext($image, 25, 0, 80, 65, imagecolorallocate($image, 255, 255, 255), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $time);
$childImage = imagecreatefromstring(file_get_contents('https://api.vietqr.io/img/'.$_POST['code'].'.png'));

// Lấy kích thước của ảnh con
$childWidth = imagesx($childImage);
$childHeight = imagesy($childImage);

// Kích thước mới của ảnh con
$newChildWidth = 125;
$newChildHeight = 50;

// Tạo ảnh con mới với kích thước mới
$resizedChildImage = imagescale($childImage, $newChildWidth, $newChildHeight);

// Chèn ảnh con đã co dãn vào hình ảnh chính
imagecopy($image, $resizedChildImage, 40, 650, 0, 0, $newChildWidth, $newChildHeight);

// Giải phóng bộ nhớ ảnh con đã co dãn
imagedestroy($resizedChildImage);
$overlayImageLink = $pins[$pin];

// Tải ảnh overlay từ liên kết
$overlayImage = imagecreatefrompng($overlayImageLink);

// Kích thước ảnh overlay
$overlayWidth = imagesx($overlayImage);
$overlayHeight = imagesy($overlayImage);

// Kích thước ảnh gốc
$imageWidth = imagesx($image);
$imageHeight = imagesy($image);

// Kích thước mới cho ảnh overlay (tùy chỉnh theo nhu cầu)
$newOverlayWidth = 60; // Kích thước mới của ảnh overlay (chiều rộng)
$newOverlayHeight = 25; // Kích thước mới của ảnh overlay (chiều cao)

// Tạo ảnh mới có kích thước overlay mới với kênh alpha (transparency)
$resizedOverlayImage = imagecreatetruecolor($newOverlayWidth, $newOverlayHeight);
imagealphablending($resizedOverlayImage, false);
imagesavealpha($resizedOverlayImage, true);
$transparentColor = imagecolorallocatealpha($resizedOverlayImage, 0, 0, 0, 127);
imagefill($resizedOverlayImage, 0, 0, $transparentColor);

// Thay đổi kích thước ảnh overlay
imagecopyresampled($resizedOverlayImage, $overlayImage, 0, 0, 0, 0, $newOverlayWidth, $newOverlayHeight, $overlayWidth, $overlayHeight);

// Tính toán vị trí overlay
$overlayX = $imageWidth - $newOverlayWidth - 25; // Cách lề phải 10px
$overlayY = $imageHeight - $newOverlayHeight - 1730; // Cách lề dưới 10px

// Overlay ảnh mới lên ảnh gốc
imagecopy($image, $resizedOverlayImage, $overlayX, $overlayY, 0, 0, $newOverlayWidth, $newOverlayHeight);


$named = rand(00000,999999999999);
// Lưu ảnh kết quả
$outputFile = $_SERVER['DOCUMENT_ROOT'].'/bills/IMG_'.$named.'.png';
imagepng($image, $outputFile);

// Giải phóng bộ nhớ
imagedestroy($image);
imagedestroy($overlayImage);

$data = array(
    'bank' => trim($_GET['name']),
    'name' => $name_nhan,
    'time_create' => date('Y-m-d H:i:s'),
    'for_username' => $_SESSION['username'],
    'image_url' => $domain.'/bills/IMG_'.$named.'.png'
);

// Chèn dữ liệu vào bảng
DB::insert('history_bill', $data);

echo '<div class="list-group mb-3">
            <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect">
              <img src="'.$domain.'/bills/IMG_'.$named.'.png" width="100px" class="rounded me-3 w-px-50">
              <div class="w-100">
                <div class="d-flex justify-content-between">
                  <div class="user-info">
                    <div class="mb-1 alert alert-success">Đã tạo bill thành công!</div>

                  </div>
                  <div class="add-btn">
                    <a class="btn bg-rose-500 hover:bg-rose-600 text-white" href="'.$domain.'/bills/IMG_'.$named.'.png" download>Download</a>
                  </div>
                </div>
              </div>
            </div>

          </div>';
}
else {
    echo '<div class="alert alert-danger">Số dư trong tài khoản của bạn không đủ để tạo bill</div>';
}
}
}else {
    echo '<div class="alert alert-danger">Vui lòng đăng nhập trước khi tạo bill</div>';
}
?>

                                    <div class="grid gap-5 md:grid-cols-2">
    <div class="col-md-6">
        <form action="" method="POST">
            <div class="mb-3">
                <input class="form-input w-full" name="time" value="<?=date('G:i')?>"/>
            </div>
            <div class="mb-3">
            <b>Biến động 1</b>
            <textarea class="form-input w-full mt-2" rows="4" name="nd1">TK 03xxx824|GD: -10,000VND 29/11/23
9:56 ISD: OVNDIND: FAKE BILL
CHUYEN KHOAN - Ma giao dịch/
Trace 123456</textarea>
            <input class="form-input w-full mt-2" name="time1" value="vừa xong"/>
        </div>
        <div class="mb-3">
            <b>Biến động 2</b>
            <textarea class="form-input w-full mt-2" rows="4" name="nd2">TK 03xxx824|GD: -10,000VND 29/11/23
9:56 ISD: OVNDIND: FAKE BILL
CHUYEN KHOAN - Ma giao dịch/
Trace 123456</textarea>
            <input class="form-input w-full mt-2" name="time2" value="vừa xong"/>
        </div>
        <div class="mb-3">
            <b>Biến động 3</b>
            <textarea class="form-input w-full mt-2" rows="4" name="nd3">TK 03xxx824|GD: -10,000VND 29/11/23
9:56 ISD: OVNDIND: FAKE BILL
CHUYEN KHOAN - Ma giao dịch/
Trace 123456</textarea>
            <input class="form-input w-full mt-2" name="time3" value="vừa xong"/>
        </div>
        <div class="mb-3">
            <b>Biến động 4</b>
            <textarea class="form-input w-full mt-2" rows="4" name="nd4">TK 03xxx824|GD: -10,000VND 29/11/23
9:56 ISD: OVNDIND: FAKE BILL
CHUYEN KHOAN - Ma giao dịch/
Trace 123456</textarea>
            <input class="form-input w-full mt-2" name="time4" value="vừa xong"/>
        </div>
               <div class="row mb-3">
          <label class="col-sm-3 col-form-label" for="form-alignment-username">Phần trăm pin</label>
          <div class="col-sm-9">
                <div class="grid gap-5 grid-cols-5">
                    <?php
                    foreach ($pins as $key => $value) {
    echo '<div class="">';
    echo '  <div class="form-check custom-option custom-option-image custom-option-image-radio">';
    echo '    <label class="form-check-label custom-option-content" for="' . $key . '">';
    echo '      <span class="custom-option-body">';
    echo '        <img   style="height:50px!important;object-fit:contain;background-color: #b6b6b6;" src="' . $value . '" alt="radioImg" />';
    echo '      </span>';
    echo '    </label>';
    echo '    <input name="pin" class="form-check-input" type="radio" value="' . $key . '" id="' . $key . '"';
    if ($key === 'pin2') {
        echo ' checked';
    }
    echo '  />';
    echo '  </div>';
    echo '</div>';
}
?>
        </div>
          </div>
        </div>
        <div class="mb-3">
            <button name="primary" class="btn bg-rose-500 hover:bg-rose-600 text-white">Tạo ảnh BĐSD (<?=number_format($tiengoc)?>đ)</button>
              <button name="demo" class="btn bg-rose-500 hover:bg-rose-600 text-white">Xem demo 0đ</button>
        </div>
        </form>
    </div>
    <div class="col-md-5">
        <img src="<?=$domain?>/IMG_459918180219.png?100" class="w-full"/>
    </div>
</div>
