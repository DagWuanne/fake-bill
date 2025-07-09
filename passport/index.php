<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/files/config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Access-Control-Allow-Origin: *");

function generateRandomCode()
{
    // Tạo ký tự đầu là chữ hoa
    $firstChar = chr(rand(65, 90)); // Ký tự chữ hoa từ A (65) đến Z (90)

    // Tạo 7 số ngẫu nhiên
    $numbers = '';
    for ($i = 0; $i < 7; $i++) {
        $numbers .= rand(0, 9);
    }

    // Ghép lại
    return $firstChar . $numbers;
}

function generateRandom9Digits()
{
    // Tạo 9 số ngẫu nhiên
    $numbers = '';
    for ($i = 0; $i < 9; $i++) {
        $numbers .= rand(0, 9);
    }

    return $numbers;
}

?>
<div class="px-4 py-8">
    <div class="">
        <div class="grid gap-7 md:grid-cols-2">
            <div class="d1">
                <li>Hoàn tiền nếu khách hàng tạo lỗi, chữ dài,...</li>
               
                <br />
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-5 md:grid-cols-2 grid:items-center">
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="hovaten">Họ và tên</label>
                            <input id="hovaten" name="hovaten" class="form-input w-full" type="text" required value="<?= $_POST['hovaten'] ?? 'Dương Trí Niềm' ?>">
                        </div>

                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="gioitinh">Giới tính</label>
                            <select id="gioitinh" name="gioitinh" class="form-input w-full" type="text">
                                <option value="Nam / M">Nam</option>
                                <option value="Nữ / F">Nữ</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="anhthe">Chọn ảnh thẻ (trước tiên hãy xóa nền của ảnh thẻ, có thể sử dụng <b><a style="color: blue;" href="https://www.remove.bg/vi">tool này</a></b>)</label>
                            <input class="form-input w-full" type="file" name="anhthe" id="anhthe">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="ngaysinh">Ngày tháng năm sinh</label>
                            <input id="ngaysinh" name="ngaysinh" class="form-input w-full" type="text" require value="<?= $_POST['ngaysinh'] ?? '01/01/2000' ?>" c>
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="sohochieu">Số hộ chiếu</label>
                            <input id="sohochieu" name="sohochieu" class="form-input w-full" type="text" required value="<?= generateRandomCode() ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="socccd">Số GCMND/ID Card</label>
                            <input id="gcmnd" name="gcmnd" class="form-input w-full" type="text" required value="<?= generateRandom9Digits() ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="ngaysinh">Ngày cấp</label>
                            <input id="ngaycap" name="ngaycap" class="form-input w-full" type="text" required value="<?= $_POST['ngaycap'] ?? '01/01/2000' ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="ngayhethan">Có giá trị đến</label>
                            <input id="ngayhethan" name="ngayhethan" class="form-input w-full" type="text" required value="<?= $_POST['ngayhethan'] ?? '01/01/2000' ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="quequan">Nơi sinh</label>
                            <input id="noisinh" name="noisinh" class="form-input w-full" type="text" required value="<?= $_POST['quequan'] ?? 'Hà Nội' ?>">
                        </div>

                    </div>
                    <div class="mb-1">
                        <label class="block text-sm font-medium mb-1" for="quequan">Code bên dưới</label>
                        <textarea id="footer" name="footer" class="form-input w-full" required><?= $_POST['footer'] ?? 'p<vnmduong<<tri<niem<<<<<<<<<<<<<<<<<<<<<<<<
c9578038<4vnm9105012m3103164183725727<<<<<62' ?> </textarea>
                    </div>
                    <div><small class="mb-1 small">Nhấn vào đây</small><br /><button type="submit" class="btn bg-emerald-500 hover:bg-emerald-600 text-white">Tạo hộ chiếu (<?= number_format($tiengoc3) ?>đ)</button></div>
                </form>
            </div>
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hovaten'], $_FILES['anhthe']) && $_FILES['anhthe']['error'] === UPLOAD_ERR_OK) {
                // Lấy thông tin người dùng
                $username = isset($_POST['key']) ? xss_clean(DB::queryFirstField("SELECT username FROM users WHERE serial_key = '" . trim($_POST['key']) . "' LIMIT 1")) : $_SESSION['username'];

                // Kiểm tra trạng thái đăng nhập
                if (empty($_FILES['anhthe'])) {
                    echo '<script>alert("Dữ liệu điền vào không đủ");</script>';
                }
                if (empty($username)) {
                    echo '<script>alert("Bạn chưa đăng nhập");</script>';
                    exit;
                }

                // Kiểm tra số dư
                 DB::query("UPDATE settings SET luottaohochieu=luottaohochieu+1 WHERE id = '1'");
                $sodu = DB::queryFirstField("SELECT sodu FROM users WHERE username = '$username'");
                if ($sodu < 0) {
                    echo '<script>alert("Số dư của bạn không đủ");</script>';
                    exit;
                }

                // Cập nhật số dư
                DB::query("UPDATE users SET sodu = sodu - $tiengoc3 WHERE username = '$username'");
                DB::insert('notifications', [
                    'notifications' => 'Đã tạo 1 hộ chiếu, số tiền trừ ' . $tiengoc3,
                    'username' => $username,
                    'amount' => $tiengoc3
                ]);

                // Xử lý tải ảnh lên
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                $fileName = uniqid() . '-' . basename($_FILES['anhthe']['name']);
                $uploadFile = $uploadDir . $fileName;

                // Tạo thư mục nếu không tồn tại
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Di chuyển tệp tải lên
                if (move_uploaded_file($_FILES['anhthe']['tmp_name'], $uploadFile)) {
                    $anhtheUrl = '/uploads/' . $fileName;
                    $params = http_build_query([
                        'name' => $_POST['hovaten'],
                        'sohochieu' => $_POST['sohochieu'],
                        'gcmnd' => $_POST['gcmnd'],
                        'birthday' => $_POST['ngaysinh'],
                        'sex' => $_POST['gioitinh'],
                        'noisinh' => $_POST['noisinh'],
                        'ngaycap' => $_POST['ngaycap'],
                        'ngayhethan' => $_POST['ngayhethan'],
                        'footer' => $_POST['footer'],
                        'anhthe' => $fileName,
                    ]);

                    echo '<div class="d2"><img class="w-full w-100 mb-2" src="passport/api.php?' . $params . '"/> </div>';
                } else {
                    throw new Exception('Lỗi khi di chuyển tệp vào thư mục lưu trữ.');
                }
            } else {
                echo '<div class="d2">
        <img class="w-full mt-3" src="demo-passport.png">
      </div>';
            }

            ?>
        </div>
        <br />
    </div>
</div>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>