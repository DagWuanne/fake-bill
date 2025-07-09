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
                      <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white" type="submit" name="type" value="real">Tạo Bill (<?= number_format($tiengoc) ?>)</button>
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
                                 'notifications' => 'Đã tạo 1 bill số dư Vietin, số tiền trừ ' . $tiengoc,
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
                        function khhaha($image, $fontsize, $y, $textColor, $font, $text)
                        {
                            $fontSize = $fontsize;
                            $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
                            $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
                            $imageWidth = imagesx($image);
                            $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
                            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
                        }

                        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                            $avatarPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . basename($_FILES['avatar']['name']);
                            move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);

                            // Load the avatar image
                            $avatar = imagecreatefromstring(file_get_contents($avatarPath));
                            $avatarSize = min(imagesx($avatar), imagesy($avatar)); // Ensure avatar is square

                            // Create a circular true color image
                            $circularAvatar = imagecreatetruecolor($avatarSize, $avatarSize);
                            imagesavealpha($circularAvatar, true);
                            $transparency = imagecolorallocatealpha($circularAvatar, 0, 0, 0, 127);
                            imagefill($circularAvatar, 0, 0, $transparency);

                            // Create a circular mask directly by copying the circular part of the avatar
                            $radius = $avatarSize / 2;
                            for ($x = 0; $x < $avatarSize; $x++) {
                                for ($y = 0; $y < $avatarSize; $y++) {
                                    $dx = $x - $radius;
                                    $dy = $y - $radius;
                                    if (($dx * $dx + $dy * $dy) <= ($radius * $radius)) {
                                        $color = imagecolorat($avatar, $x, $y);
                                        imagesetpixel($circularAvatar, $x, $y, $color);
                                    }
                                }
                            }
                            imagedestroy($avatar);
                            $desiredWidth = 182;  // Set desired width
                            $desiredHeight = 182; // Set desired height
                            $circularAvatar = imagescale($circularAvatar, $desiredWidth, $desiredHeight);
                        }
                        // Load the base image
                        $image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/banks/vietinbank/sodu/sodu-vietinbank.png');

                        if ($watermark == 1) {
                            imagettftext($image, 30, 0, 150, 400, imagecolorallocate($image, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Ảnh này chỉ để xem demo');
                            imagettftext($image, 30, 0, 150, 900, imagecolorallocate($image, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Vui lòng ấn vào nút' . "\n" . '"Tạo số dư" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                        }

                        // Place the avatar on the base image (optional positioning)
                        if (isset($circularAvatar)) {
                            imagecopy($image, $circularAvatar, 80, 313, 0, 0, imagesx($circularAvatar), imagesy($circularAvatar));
                            imagedestroy($circularAvatar);
                        }

                        // Thêm khiên vào avt
                        $khienPath = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/banks/vietinbank/sodu/khien-vietin.png');
                        $imgW = imagesx($khienPath) - 107;
                        $imgH = imagesy($khienPath) - 123;

                        $khienPath = imagescale($khienPath, $imgW, $imgH);

                        imagecopy($image, $khienPath, 215, 310, 0, 0, imagesx($khienPath), imagesy($khienPath));
                        imagedestroy($khienPath);

                        imagettftext($image, 30, 0, 315, 410, imagecolorallocate($image, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Mark/Mark-Bold.ttf', $_POST['name']);
                        imagettftext($image, 40, 0, 130, 100, imagecolorallocate($image, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', $_POST['time_dt']);
                        imagettftext($image, 28, 0, 90, 740, imagecolorallocate($image, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/SVN-Gilroy/SVN-Gilroy Medium.woff', $_POST['stk']);

                                                 
                        $number = $_POST['amount'];
                        $vndText = ' VND';
                        $vndFont = $_SERVER['DOCUMENT_ROOT'] . '/fonts/SVN-Gilroy/SVN-Gilroy Bold.woff';
                        $numberSize = 42;
                        $vndSize = 40;

                        $numberBox = imagettfbbox($numberSize, 0, $vndFont, number_format($number));
                        $numberWidth = $numberBox[2] - $numberBox[0];
                        $numberX = 90;
                        $numberY = 880;
                        imagettftext($image, $numberSize, 0, $numberX, $numberY, imagecolorallocate($image, 3, 90, 160), $vndFont, number_format($number));

                        $vndBox = imagettfbbox($vndSize, 0, $vndFont, $vndText);
                        $vndWidth = $vndBox[2] - $vndBox[0];
                        $vndX = $numberX + $numberWidth + 10;
                        $vndY = 880;
                        imagettftext($image, $vndSize, 0, $vndX, $vndY, imagecolorallocate($image, 3, 90, 160), $vndFont, $vndText);
                        //imagedestroy($image);


                        ob_start();
                        imagepng($image);
                        $imageData = ob_get_clean();
                        $base64 = base64_encode($imageData);

                        echo '<img width="300px" src="data:image/png;base64,' . $base64 . '" alt="Image" />';

                        if ($watermark == 0) {
                            $name = rand(1111111111,9999999999);
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
                            // echo "<img src='{$downloadUrl}' alt='Fake Số Dư' />";
                            echo "</body>";
                            echo "</html>";
                        }

                        exit;
                    } else {
                        echo '<script>alert("Số dư tài khoản không đủ")</script>';
                    }
                } else {
                    echo '<span style="color:red">Tài khoản không hợp lệ!</span>';
                }
            }
        } catch (Exception $e) {
            echo '<span style="color:red">Lỗi' . $e->getMessage() . '</span>';
        }
