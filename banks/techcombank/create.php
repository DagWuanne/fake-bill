 <?php
 date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ theo yêu cầu của bạn
header("Access-Control-Allow-Origin: *");require_once $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
// Mảng các tên thứ trong tiếng Việt
$ten_thu = array(
    'Chủ nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'
);

// Lấy thời gian hiện tại
$timestamp = time();

// Định dạng thời gian
$gio_hien_tai = date('H:i');
$ngay_hien_tai = date('d/m/Y');
$thu_hien_tai = $ten_thu[date('w')];

$thoi_gian = $gio_hien_tai . ' ' . $thu_hien_tai . ' ' . $ngay_hien_tai;
?>
   <div class="grid gap-5 md:grid-cols-1">
                                    
                                    <div class="grid gap-5 md:grid-cols-3">
                                        <div class="">
                                            <label class="block text-sm mb-2" for="default">Số tài khoản người gửi</label>
                                            <input value="987654321"  id="stkgui" class="form-input w-full" type="text" placeholder="Ví dụ: 987654321">
                                        </div>
                                         <div class="d-none" style="display:none">
                                            <label class="block text-sm mb-2" for="default">Tên người gửi</label>
                                            <input value="Nguyễn Văn B"  id="name_gui" class="form-input w-full" type="text" placeholder="Ví dụ: Nguyễn Văn B">
                                        </div>
                                        <!-- Start -->
                                        <div class="">
                                            <label class="block text-sm mb-2" for="default">Số tài khoản người nhận</label>
                                            <input value="1212004"  id="stk_nhan" class="form-input w-full" type="text" placeholder="Ví dụ: 123456789">
                                        </div>
                                         <div class="">
                                            <label class="block text-sm mb-2" for="default">Tên người nhận</label>
                                            <input value="Nguyễn Văn A"  id="name_nhan" class="form-input w-full" type="text" placeholder="Ví dụ: Nguyễn Văn A">
                                        </div>
                                         <div class="">
                                            <label class="block text-sm mb-2" for="default">Số tiền chuyển</label>
                                            <input value="100000"  id="amount" class="form-input w-full" type="number" placeholder="Ví dụ: 100000">
                                        </div>
                                         <?php include $_SERVER['DOCUMENT_ROOT'].'/select-form.php';?>
                                          <div class="">
                                            <label class="block text-sm mb-2" for="default">Hệ điều hành</label>
                                           <select onchange="showPin();" id="theme" class="form-select w-full">
                                               <option  value="ios">IOS/IPhone</option>
                                      <option  value="android">Android</option>
                                       
                                </select>
                                <script>
                                    function showPin(){
                                        var hedieuhanh = document.getElementById('theme').value;
                                        if(hedieuhanh == 'android'){
                                            // Lấy danh sách tất cả các thẻ img trên trang
var images = document.getElementsByTagName('img');

// Duyệt qua từng thẻ img trong danh sách
for (var i = 0; i < images.length; i++) {
  // Kiểm tra nếu thuộc tính width của img có giá trị là "30"
  if (images[i].getAttribute('width') === '30') {
    // Thay đổi giá trị của thuộc tính width thành "15"
    images[i].setAttribute('width', '15');
  }
}
                                        }
                                        if(hedieuhanh == 'android'){
                                              document.getElementById('pin1').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/1.png?2';
                                        document.getElementById('pin2').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/2.png?2';
                                        document.getElementById('pin3').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/3.png?2';
                                        document.getElementById('pin4').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/4.png?2';
                                        document.getElementById('pin5').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/5.png?2';
                                        document.getElementById('pin6').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/6.png?2';
                                        document.getElementById('pin7').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/7.png?2';
                                        document.getElementById('pin8').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/8.png?2';
                                        document.getElementById('pin9').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/9.png?1';
                                        document.getElementById('pin10').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/10.png?1';
                                        document.getElementById('pin11').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/11.png?1';
                                        document.getElementById('pi1').style.display = 'block';
                                        document.getElementById('pi2').style.display = 'block';
                                        document.getElementById('pi3').style.display = 'block';
                                        document.getElementById('pi4').style.display = 'block';
                                        }
                                        if(hedieuhanh == 'ios'){
                                              document.getElementById('pin1').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/1.png?1';
                                        document.getElementById('pin2').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/2.png?1';
                                        document.getElementById('pin3').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/3.png?1';
                                        document.getElementById('pin4').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/4.png?1';
                                        document.getElementById('pin5').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/5.png?1';
                                        document.getElementById('pin6').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/6.png?1';
                                        document.getElementById('pin7').src = '<?=$domain?>/banks/<?=$_GET['name']?>/pin_'+hedieuhanh+'/7.png?1';
                                        document.getElementById('pi1').style.display = 'none';
                                        document.getElementById('pi2').style.display = 'none';
                                        document.getElementById('pi3').style.display = 'none';
                                        document.getElementById('pi4').style.display = 'none';
                                            // Lấy danh sách tất cả các thẻ img trên trang
var images = document.getElementsByTagName('img');

// Duyệt qua từng thẻ img trong danh sách
for (var i = 0; i < images.length; i++) {
  // Kiểm tra nếu thuộc tính width của img có giá trị là "30"
  if (images[i].getAttribute('width') === '15') {
    // Thay đổi giá trị của thuộc tính width thành "15"
    images[i].setAttribute('width', '30');
  }
}
                                        }
                                      
                                    }
                                    window.onload = function() {
  showPin();
};
                                </script>
                                        </div>
                                           <div class="">
                                            <label class="block text-sm mb-2" for="default">Thông báo biến động số dư</label>
                                           <select onchange="thaydoibdsd()" id="bdsd" class="form-select w-full">
                                               <option value="0">Không</option>
                                      <option value="1">Có</option>
                                       
                                </select>
                                  <div id="soducuoi" style="display:none">
                                            <label class="block text-sm mb-2 mt-2" for="default">Vui lòng nhập số dư cuối</label>
                                            <input  id="sdc" class="form-input w-full" type="number" value="100000" placeholder="Ví dụ: 935000">
                                            
                                        </div>
                                </div>
                                        
                                         <div class="">
                                            <label class="block text-sm mb-2" for="default">Thời gian điện thoại</label>
                                            <input  id="time_dt" class="form-input w-full" type="text" value="<?=date('G:i')?>" placeholder="Ví dụ: <?=date('G:i')?>">
                                        </div>
                                         <div class="">
                                            <label class="block text-sm mb-2" for="default">Thời gian trên bill</label>
                                            <input  id="time_bill" class="form-input w-full" type="text" value="<?=date('d')?> thg <?=date('m')?>, <?=date('Y')?> lúc <?=date('G:i')?>" placeholder="Ví dụ: <?=date('h:i:s, d/m/Y')?>">
                                        </div>
                                          <div class="">
                                            <label class="block text-sm mb-2" for="default">Nội dung chuyển khoản</label>
                                            <input value="NGUYEN VAN B chuyen tien"  id="noidung" class="form-input w-full" type="text" value="" placeholder="Ví dụ: Nguyen Van A chuyen tien">
                                        </div>
                                            <div class="">
                                            <label class="block text-sm mb-2" for="default">Mã giao dịch</label>
                                            <input  id="magiaodich" class="form-input w-full" type="text" value="FT24<?=rand(00000000,999999999999)?>">
                                        </div>
                                        <div>
                                         
                                              <label class="block text-sm mb-2" for="default">Chỉnh dung lượng pin</label>
                                               <div x-data="{ modalOpen: false }">
                                            <button
                                                class="btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                                @click.prevent="modalOpen = true"
                                                aria-controls="basic-modal"
                                            >Chỉnh dung lượng</button>
                                            <!-- Modal backdrop -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="modalOpen"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                aria-hidden="true"
                                                x-cloak
                                            ></div>
                                            <!-- Modal dialog -->
                                            <div
                                                id="basic-modal"
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog"
                                                aria-modal="true"
                                                x-show="modalOpen"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4"
                                                x-cloak
                                            >
                                                <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                                    <!-- Modal header -->
                                                    <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div class="font-semibold text-slate-800 dark:text-slate-100">Basic Modal</div>
                                                            <button class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400" @click="modalOpen = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="px-5 pt-4 pb-1">
                                                        <div class="text-sm">
                                                            <div class="font-medium text-slate-800 dark:text-slate-100 mb-2">Chỉnh phần trăm pin của bill tại đây</div>
                                                            <div class="space-y-2">
                                                                <div class="flex flex-wrap items-center -m-3" >
                            
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input   type="radio" name="pin" value="1" class="form-radio" >
                                            <span class="text-sm ml-2"><img width="15" id="pin1" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                              <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="2" class="form-radio">
                                            <span class="text-sm ml-2"><img width="15" id="pin2" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="3" class="form-radio">
                                            <span class="text-sm ml-2"><img width="15" id="pin3" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="4" class="form-radio">
                                            <span class="text-sm ml-2"><img width="15" id="pin4" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="5" class="form-radio">
                                            <span class="text-sm ml-2"><img width="15" id="pin5" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="6" class="form-radio">
                                            <span class="text-sm ml-2"><img width="15" id="pin6" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                    <div class="m-3">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="7" class="form-radio" checked>
                                            <span class="text-sm ml-2"><img width="15" id="pin7" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                   
                             <div class="m-3" id="pi1" style="display:none">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="8" class="form-radio" checked>
                                            <span class="text-sm ml-2"><img width="15" id="pin8" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                     <div class="m-3" id="pi2" style="display:none">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="9" class="form-radio" checked>
                                            <span class="text-sm ml-2"><img width="15" id="pin9" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                     <div id="pi3" class="m-3" style="display:none"> 
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="10" class="form-radio" checked>
                                            <span class="text-sm ml-2"><img width="15" id="pin10" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                                     <div id="pi4" class="m-3" style="display:none">
                                        <!-- Start -->
                                        <label class="flex items-center">
                                            <input  type="radio" name="pin" value="11" class="form-radio" checked>
                                            <span class="text-sm ml-2"><img width="15" id="pin11" src=""/></span>
                                        </label>
                                        <!-- End -->
                                    </div>
                            
                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="px-5 py-4">
                                                        <div class="flex flex-wrap justify-end space-x-2">
                                                            <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false">Lưu</button>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        </div>
                                      <div>
                                             <button onclick="taoBill('primary')"
                                                class="mb-3 btn bg-emerald-500 hover:bg-emerald-600 w-full text-white"
                                                
                                            >Tạo bill (<?=number_format($tiengoc)?>)</button>
                                          <button class="btn bg-rose-500 hover:bg-rose-600 w-full text-white" onclick="taoBill('<?=$default?>')">Xem demo</button>
                                    
                                    </div>
                            
                                    </div>
                                    <div>
                                        <!-- Start -->
                                        <div>
                                            <div class="flex items-center justify-between">
                                                <label class="block text-sm font-medium mb-1" for="tooltip">Xem demo bill trước khi tải xuống<br/><small>(Nhấn vào ảnh để tải bill xuống máy)</small></label>
                                                <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                                    <button class="block" aria-haspopup="true" :aria-expanded="open" @focus="open = true" @focusout="open = false" @click.prevent="" aria-expanded="false">
                                                        <svg class="w-4 h-4 fill-current text-slate-400 dark:text-slate-500" viewBox="0 0 16 16">
                                                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z"></path>
                                                        </svg>
                                                    </button>
                                                    <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                                        <div class="min-w-60 bg-slate-800 text-slate-200 px-2 py-1 rounded overflow-hidden mb-2" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                                            <div class="text-sm">Tải bill xuống sẽ không có hình mờ, demo sẽ có hình mờ</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="grid gap-5 md:grid-cols-3" >
                                         <div id="anhdemo">
                                            
                                         </div>
                                      
                                         </div>
                                         </div>
                                        </div>
                                        <!-- End -->
                                    </div>
                                    
                                  
                                    

                                </div>
                                  <script>
             function chonBank() {
    var selectElement = document.getElementById("bank_nhan");
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var intValues = selectedOption.getAttribute("int");
    document.getElementById('code').value = intValues;
    
    
    var selectElement = document.getElementById("bank_nhan");
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var intValues = selectedOption.getAttribute("ant");
    document.getElementById('code1').value = intValues;
             }
        </script>
          <input id="code1" type="text" value="Vietinbank" name="code1" hidden/>
        <input id="code" type="text" value="ICB" name="code" hidden/>
                                <script>
                                  
    function thaydoibdsd(){
        var bdsd = document.getElementById('bdsd').value;
        if(bdsd === '0'){
            document.getElementById('soducuoi').style.display = 'none';
        }
        if(bdsd === '1'){
            document.getElementById('soducuoi').style.display = 'block';
        }
    }
    // Define the taoBill function
    function taoBill(type) {
        chonBank();

     
        document.getElementById('anhdemo').innerHTML = '<button class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white disabled:border-slate-200 dark:disabled:border-slate-700 disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:text-slate-400 dark:disabled:text-slate-600 disabled:cursor-not-allowed shadow-none" disabled=""><svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16"><path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z"></path></svg><span class="ml-2">Loading</span></button>';
        var selectedElement = document.getElementById('bank_nhan');
        // Get data from input fields or any other source
        var inputData = {
            key: "<?=$user_new['serial_key']?>",
            theme: document.getElementById('theme').value,
            time_dt: document.getElementById('time_dt').value,
            pin: document.querySelector('input[name="pin"]:checked').value,
            stk_nhan: document.getElementById('stk_nhan').value,
            name_nhan: document.getElementById('name_nhan').value,
            amount: document.getElementById('amount').value,
            bank_nhan: document.getElementById('bank_nhan').value,
            code: document.getElementById('code').value,
            code1: document.getElementById('code1').value,
            magiaodich: document.getElementById('magiaodich').value,
            noidung: document.getElementById('noidung').value,
            bdsd: document.getElementById('bdsd').value,
            sdc: document.getElementById('sdc').value,
            stkgui: document.getElementById('stkgui').value,
            name_gui: document.getElementById('name_gui').value,
            time_bill: document.getElementById('time_bill').value
        };

        // Create a new FormData object
        var formData = new FormData();

        // Append each key-value pair to the FormData object
        for (var key in inputData) {
            formData.append(key, inputData[key]);
        }

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure it: POST-request for the URL /create.php
        xhr.open("POST", "<?=$domain?>/banks/<?=$_GET['name']?>/api.php?type=" + type, true);

        // Define a callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
 
                document.getElementById('anhdemo').innerHTML = xhr.responseText;
           
                
            }
        };

        // Send the request with the FormData object
        xhr.send(formData);
    }


function getRandomName() {
    // Generate a random string for the file name
    const randomString = Math.random();
    return `IMG_${randomString}.jpg`;
}

function taiAnh(){
    // Get the image source
    var imageSrc = document.querySelector('#anhdemo img').src;

    // Create a temporary anchor element
    var downloadLink = document.createElement('a');

    // Set the download link attributes
    downloadLink.href = imageSrc;
    downloadLink.download = getRandomName();

    // Append the link to the body
    document.body.appendChild(downloadLink);

    // Trigger a click on the link to start the download
    downloadLink.click();

    // Remove the temporary link from the DOM
    document.body.removeChild(downloadLink);
}
                                </script>