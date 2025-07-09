<form action="" method="POST" enctype="multipart/form-data">
    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium mb-1" for="card-name">Tên chủ tài khoản <span class="text-rose-500">*</span></label>
            <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Viết hoa, ví dụ: VO HUU NHAN" required name="name" value="<?= $_POST['name'] ?? "DINH CONG DOAN" ?>" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="card-name">Tài khoản nguồn <span class="text-rose-500">*</span></label>
            <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 2312004" required name="stk" value="<?= $_POST['stk'] ?? 1234567890 ?>" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="card-name">Số dư tài khoản <span class="text-rose-500">*</span></label>
            <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 50000000" required name="amount" value="<?= $_POST['amount'] ?? 1000000 ?>" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="card-name">Thời gian điện thoại <span class="text-rose-500">*</span></label>
            <input id="card-name" class="form-input mb-1 mt-1 w-full" type="text" placeholder="Ví dụ: 50000000" required name="time_dt" value="<?= $_POST['time_dt'] ?? date('G:i') ?>" />
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="avatar">Upload Avatar</label>
            <input id="avatar" class="form-input mb-1 mt-1 w-full" type="file" name="avatar" accept="image/*" />
        </div>
        <input type="hidden" name="key" value="<?= $user_new['serial_key'] ?>">
        <div class="flex pt-6 items-center">
            <div class="flex items-center justify-between mr-5">
                <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white" type="submit" name="type" value="real">Fake số dư (<?= number_format($tiengoc) ?>)</button>
            </div>
            <div class="flex items-center justify-between">
                <button class="btn bg-rose-500 hover:bg-rose-600 text-white" type="submit" name="type" value="demo">Xem demo</button>
            </div>
        </div>
    </div>
</form><br />

<?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = null;
        if (isset($_POST['key'])) {
            $username = xss_clean(DB::queryFirstField("SELECT username FROM users WHERE serial_key = '" . trim($_POST['key']) . "' LIMIT 1"));
        }
        if ($_POST['type'] == 'demo' || !empty($username)) {
            $timestampHetHan = strtotime(DB::queryFirstField("SELECT date_bill FROM `users` WHERE username = '$username'"));
            if (time() < $timestampHetHan) {
                $tiengoc = 0;
            }
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
            if ($_POST['type'] == 'demo') {
                $tiengoc = 0;
                $watermark = 1;
            } else {
                  $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
                         if ($sodu >= $tiengoc) {
                             DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
                             $watermark = 0;
                             DB::insert('notifications', [
                                 'notifications' => 'Đã tạo 1 bill số dư BIDV, số tiền trừ ' . $tiengoc,
                                 'username' => $username,
                                 'amount' => $tiengoc
                             ]);
                         }
            }
            if (empty(trim($_POST['name'])) || empty(trim($_POST['stk']))  || empty(trim($_POST['amount'])) || empty(trim($_POST['time_dt']))) {
                die('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
            }
            if ($sodu >= $tiengoc) {
                DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='" . $_SESSION['username'] . "'");

                // Avatar upload handling
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $avatarPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . basename($_FILES['avatar']['name']);
                    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)) {
                        throw new Exception('Không thể tải lên file avatar');
                    }

                    $avatar = imagecreatefromstring(file_get_contents($avatarPath));
                    if (!$avatar) {
                        throw new Exception('Không thể tạo hình ảnh từ avatar đã tải lên');
                    }

                    $avatarSize = min(imagesx($avatar), imagesy($avatar));
                    $circularAvatar = imagecreatetruecolor($avatarSize, $avatarSize);
                    imagesavealpha($circularAvatar, true);
                    $transparency = imagecolorallocatealpha($circularAvatar, 0, 0, 0, 127);
                    imagefill($circularAvatar, 0, 0, $transparency);

                    $radius = $avatarSize / 2;
                    for ($x = 0; $x < $avatarSize; $x++) {
                        for ($y = 0; $y < $avatarSize; $y++) {
                            $dx = $x - $radius;
                            $dy = $y - $radius;
                            if (($dx * $dx + $dy * $dy) <= ($radius * $radius)) {
                                $color = imagecolorat($avatar, $x, $y);
                                $r = ($color >> 16) & 0xFF;
                                $g = ($color >> 8) & 0xFF;
                                $b = $color & 0xFF;
                                $brightnessReduction = 0.5;
                                $r = (int)($r * $brightnessReduction);
                                $g = (int)($g * $brightnessReduction);
                                $b = (int)($b * $brightnessReduction);
                                $newColor = imagecolorallocatealpha($circularAvatar, $r, $g, $b, ($color >> 24) & 0x7F);
                                imagesetpixel($circularAvatar, $x, $y, $newColor);
                            }
                        }
                    }
                    imagedestroy($avatar);
                    $desiredWidth = 54;
                    $desiredHeight = 54;
                    $circularAvatar = imagescale($circularAvatar, $desiredWidth, $desiredHeight);
                }

                // Load base image
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/banks/bidv/sodu.png';
                if (!file_exists($imagePath)) {
                    throw new Exception('File hình ảnh cơ bản không tồn tại');
                }

                $image = imagecreatefrompng($imagePath);
                if (!$image) {
                    throw new Exception('Không thể tạo hình ảnh từ file cơ bản');
                }

                // Adding watermark
                if ($watermark == 1) {
                    imagettftext($image, 20, 0, 150, 400, imagecolorallocate($image, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Ảnh này chỉ để xem demo');
                    imagettftext($image, 20, 0, 150, 900, imagecolorallocate($image, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Vui lòng ấn vào nút' . "\n" . '"Tạo số dư" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }

                // Adding avatar to the image
                if (isset($circularAvatar)) {
                    imagecopy($image, $circularAvatar, 23, 132, 0, 0, imagesx($circularAvatar), imagesy($circularAvatar));
                    imagedestroy($circularAvatar);
                }

                imagettftext($image, 18, 0, 93, 180, imagecolorallocate($image, 123, 150, 148), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Mulish/Mulish-SemiBold.ttf', $_POST['name']);
                imagettftext($image, 16, 0, 70, 40, imagecolorallocate($image, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', $_POST['time_dt']);
                imagettftext($image, 18, 0, 20, 930, imagecolorallocate($image, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Mulish/Mulish-Bold.ttf', $_POST['stk']);

                $number = $_POST['amount'];
                $vndText = ' VND';
                $vndFont = $_SERVER['DOCUMENT_ROOT'] . '/fonts/Mulish/Mulish-Bold.ttf';
                $numberSize = 18;
                $vndSize = 18;

                $numberBox = imagettfbbox($numberSize, 0, $vndFont, number_format($number));
                $numberWidth = $numberBox[2] - $numberBox[0];
                $numberX = 20;
                $numberY = 1025;
                imagettftext($image, $numberSize, 0, $numberX, $numberY, imagecolorallocate($image, 25,89,122), $vndFont, number_format($number));

                $vndBox = imagettfbbox($vndSize, 0, $vndFont, $vndText);
                $vndWidth = $vndBox[2] - $vndBox[0];
                $vndX = $numberX + $numberWidth + 5;
                $vndY = 1025;
                imagettftext($image, $vndSize, 0, $vndX, $vndY, imagecolorallocate($image, 25,89,122), $vndFont, $vndText);

                ob_start();
                imagepng($image);
                $imgData = ob_get_clean();
                //imagedestroy($image);

                echo '<img src="data:image/png;base64,' . base64_encode($imgData) . '"/>';

                if ($watermark == 0) {
                    $name = rand(1111111111, 9999999999);
                    $tempFilePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $name . '.png';
                    imagepng($image, $tempFilePath);

                    imagedestroy($image);

                    $downloadUrl = "/uploads/" . $name . ".png";

                    echo "<html>";
                    echo "<body>";
                    echo "<script type='text/javascript'>
                            window.onload = function() {
                                var link = document.createElement('a');
                                link.href = '{$downloadUrl}';
                                link.download = '{$name}.png';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                          </script>";
                    echo "<img src='{$downloadUrl}' alt='Fake Số Dư' />";
                    echo "</body>";
                    echo "</html>";
                }

                exit;
            } else {
                echo '<span style="color:red">Không đủ số dư để thực hiện</span>';
            }
        }
    }
} catch (Exception $e) {
    echo '<span style="color:red">Lỗi: ' . $e->getMessage() . '</span>';
}
?>