<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/files/config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Access-Control-Allow-Origin: *");


function generateRandom($number = 11)
{
  $randomCCCD = '';

  // Đảm bảo số đầu tiên không bắt đầu bằng 0
  $randomCCCD .= rand(1, 9);

  // Tạo 11 số còn lại
  for ($i = 1; $i <= $number; $i++) {
    $randomCCCD .= rand(0, 9);
  }

  return $randomCCCD;
}

// Sử dụng hàm để tạo số CCCD ngẫu nhiên
$randomCCCD = generateRandom(11);
?>
<div class="px-4 py-8">
  <div class="">
    <div class="grid gap-5 md:grid-cols-3">
      <div class="d1">
        <li>Hoàn tiền nếu khách hàng tạo lỗi, chữ dài,...</li>
        <li>Sử dụng xác thực Zalo, mở 2FA thoải mái</li>
        <li>Tạo 1 lần, ra cả mặt trước và mặt sau</li>
        <li>Mã QR có thể quét</li>
        <br />
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="grid gap-5 md:grid-cols-2 grid:items-center">
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="hovaten">Họ và tên trên CCCD</br>
              <font color="red">họ và tên viết chữ thường cấm viết chữ HOA</font></label>
              <input id="hovaten" name="hovaten" class="form-input w-full" type="text" required value="<?= $_POST['hovaten'] ?? 'nguyễn văn a' ?>">
            </div>

            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="gioitinh">Giới tính</label>
              <select id="gioitinh" name="gioitinh" class="form-input w-full" type="text">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
              </select>
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="anhthe">Chọn ảnh thẻ</label>
              <input class="form-input w-full" type="file" name="anhthe" id="anhthe">
            </div>
            <b><font color="red"><a href="https://taoanhdep.com/cong-cu-tao-anh-the-online">Ghép ảnh thẻ tại đây !</a></font> (ưu tiên nền trắng)</b>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="ngaysinh">Ngày tháng năm sinh</label>
              <input id="ngaysinh" name="ngaysinh" class="form-input w-full" type="text" require value="<?= $_POST['ngaysinh'] ?? '01/01/2000' ?>" c>
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="socccd">Số CCCD</label>
              <input id="socccd" name="socccd" class="form-input w-full" type="text" required value="<?= $randomCCCD ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="socccd">Số CMND</label>
              <input id="socmnd" name="socmnd" class="form-input w-full" type="text" required value="<?= generateRandom(8) ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="ngaysinh">Ngày cấp</label>
              <input id="ngaycap" name="ngaycap" class="form-input w-full" type="text" required value="<?= $_POST['ngaycap'] ?? '01/01/2021' ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="ngayhethan">Ngày hết hạn</label>
              <input id="ngayhethan" name="ngayhethan" class="form-input w-full" type="text" required value="<?= $_POST['ngayhethan'] ?? '01/01/2031' ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="quequan">Quê quán</label>
              <input id="quequan" name="quequan" class="form-input w-full" type="text" required value="<?= $_POST['quequan'] ?? 'Cầu Giấy, Hà Nội' ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="part99_type">Thường trú (dòng 1, tối đa 3-5 chữ)</label>
              <input id="thuongtru" name="part99_type" class="form-input w-full" type="text" placeholder="xã Văn A" required value="<?= $_POST['part99_type'] ?? 'Xã Văn A' ?>">
            </div>
            <div class="mb-1">
              <label class="block text-sm font-medium mb-1" for="thuongtru">Thường trú (dòng 2, không giới hạn chữ)</label>
              <input id="thuongtru" name="thuongtru" class="form-input w-full" type="text" placeholder="huyện Văn B,TP Hải B" required value="<?= $_POST['thuongtru'] ?? 'Huyện Văn B, TP Hải B' ?>">
            </div>

          </div>
          <div><small class="mb-1 small">Nhấn vào đây</small><br /><button type="submit" class="btn bg-emerald-500 hover:bg-emerald-600 text-white">Tạo CCCD (<?= number_format($tiengoc1) ?>đ)</button></div>
        </form>

      </div>
      <?php

      if (isset($_POST['hovaten'], $_FILES['anhthe']) && $_FILES['anhthe']['error'] === UPLOAD_ERR_OK) {
        // Lấy thông tin người dùng
        $username = isset($_POST['key']) ? xss_clean(DB::queryFirstField("SELECT username FROM users WHERE serial_key = '" . trim($_POST['key']) . "' LIMIT 1")) : $_SESSION['username'];

        // Kiểm tra trạng thái đăng nhập
        if (empty($username)) {
          echo '<script>alert("Bạn chưa đăng nhập");</script>';
          exit;
        }

        // Kiểm tra số dư
         DB::query("UPDATE settings SET luottaocccd=luottaocccd+1 WHERE id = '1'");
        $sodu = DB::queryFirstField("SELECT sodu FROM users WHERE username = '$username'");
        if ($sodu < 10000) {
          echo '<script>alert("Số dư của bạn không đủ");</script>';
          exit;
        }

        // Cập nhật số dư
        DB::query("UPDATE users SET sodu = sodu - $tiengoc1 WHERE username = '$username'");
        DB::insert('notifications', [
                    'notifications' => 'Đã tạo 1 cccd, số tiền trừ ' . $tiengoc1,
                    'username' => $username,
                    'amount' => $tiengoc1
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

          // Hiển thị ảnh
          $params = http_build_query([
            'name' => $_POST['hovaten'],
            'socccd' => $_POST['socccd'],
            'birthday' => $_POST['ngaysinh'],
            'sex' => $_POST['gioitinh'],
            'quequan' => $_POST['quequan'],
            'thuongtru' => $_POST['thuongtru'],
            'ngaycap' => $_POST['ngaycap'],
            'ngayhethan' => $_POST['ngayhethan'],
            'thuongtru2' => $_POST['part99_type'],
            'anhthe' => $fileName,
            'socmnd' => $_POST['socmnd'],
          ]);

          echo '<img class="w-full rounded w-100 mb-2" src="cccd/api/front-image.php?' . $params . '"/>';
          echo '<img class="w-full rounded w-100 mb-2" src="cccd/api/back-image.php?' . $params . '"/>';
        } else {
          throw new Exception('Lỗi khi di chuyển tệp vào thư mục lưu trữ.');
        }
      } else {
        echo '<div class="d2">
        <img class="w-full rounded mt-3" src="demo_cccd.jpg">
      </div>
      <div class="d2">
        <img class="w-full rounded mt-3" src="demo_cccd_back.jpg">
      </div>';
        throw new Exception('Không có tệp được tải lên hoặc có lỗi khi tải tệp.');
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