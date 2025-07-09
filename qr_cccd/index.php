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

<head>
    <style>
        .loading-container {
            display: none;
            text-align: center;
            margin: 20px 0;
        }

        .loading-container .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        .loading-container .loading-text {
            display: inline-block;
            margin-left: 10px;
            font-size: 16px;
            color: #333;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<div class="px-4 py-8">
    <div class="">
        <div class="grid gap-5 md:grid-cols-1">
            <div class="d1">
                <li>Mã QR có thể quét zalo như quét cccd real</li>
                <br />
                <form id="cccdForm" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-5 md:grid-cols-2 grid:items-center">
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="hovaten">Họ và tên trên CCCD</label>
                            <input id="hovaten" name="hovaten" class="form-input w-full" type="text" required value="<?= $_POST['hovaten'] ?? 'Nguyễn Văn A' ?>">
                        </div>

                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="gioitinh">Giới tính</label>
                            <select id="gioitinh" name="gioitinh" class="form-input w-full">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="ngaysinh">Ngày tháng năm sinh</label>
                            <input id="ngaysinh" name="ngaysinh" class="form-input w-full" type="text" required value="<?= $_POST['ngaysinh'] ?? '01/01/2000' ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="socccd">Số CCCD</label>
                            <input id="socccd" name="socccd" class="form-input w-full" type="text" required value="010031995222">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="socmnd">Số CMND</label>
                            <input id="socmnd" name="socmnd" class="form-input w-full" type="text" required value="<?= generateRandom(8) ?>">
                        </div>
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="ngaycap">Ngày cấp</label>
                            <input id="ngaycap" name="ngaycap" class="form-input w-full" type="text" required value="<?= $_POST['ngaycap'] ?? '01/01/2000' ?>">
                        </div>
                        
                       
                        <div class="mb-1">
                            <label class="block text-sm font-medium mb-1" for="thuongtru">Địa chỉ thường trú</label>
                            <input id="thuongtru2" name="thuongtru" class="form-input w-full" type="text" placeholder="Thôn Yên Thành, Tản Lĩnh, Ba Vì, Hà Nội" required value="<?= $_POST['thuongtru'] ?? 'Thôn Yên Thành, Tản Lĩnh, Ba Vì, Hà Nội' ?>">
                        </div>

                    </div>
                    <div><small class="mb-1 small">Nhấn vào đây</small><br />
                        <button type="submit" class="btn bg-emerald-500 hover:bg-emerald-600 text-white">Tạo Mã QR</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="show-qr">
            <div class="loading-container">
                <div class="loading-spinner"></div>
                <div class="loading-text">Đang tạo mã QR...</div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cccdForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn form gửi đi theo cách thông thường

            if ("<?= $_SESSION['username'] ?>" === "") {
                alert("Đăng nhập để tạo mã qr")
            } else {
                // Hiển thị loading
                $('.loading-container').show();
                $('.show-qr img').remove(); // Xóa mã QR cũ (nếu có)

                // Lấy dữ liệu từ form và tạo URL QR
                var formData = {
                    socccd: $('#socccd').val(),
                    socmnd: $('#socmnd').val(),
                    hovaten: $('#hovaten').val(),
                    gioitinh: $('#gioitinh').val(),
                    ngaysinh: $('#ngaysinh').val(),
                    ngaycap: $('#ngaycap').val(),
                    thuongtru2: $('#thuongtru2').val()
                };

                var queryString = encodeURIComponent(
                    formData.socccd + '|' + formData.socmnd + '|' + formData.hovaten + '|' +
                    formData.ngaysinh.replaceAll(/\//g, '') + '|' + formData.gioitinh + '|' +
                    formData.thuongtru2 + '|' +
                    formData.ngaycap.replaceAll(/\//g, '')
                );

                var qrUrl = 'https://quickchart.io/qr?text=' + queryString + '&light=0000&ecLevel=Q&format=png&size=170';

                // Mô phỏng thời gian xử lý
                setTimeout(function() {
                    // Ẩn loading và hiển thị mã QR
                    $('.loading-container').hide();
                    $('.show-qr').append('<img src="' + qrUrl + '" alt="QR Code" />');
                }, 1000); // Giả sử thời gian xử lý là 1 giây
            }
        });

    });
</script>