<?php
// Chỉ khởi động session nếu chưa khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nạp cấu hình chính, chỉ một lần duy nhất
require_once __DIR__ . '/files/config.php';

// Các lệnh PHP khác bên dưới...
?>


<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="/favicon.ico">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6QSRMFSZ8T"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6QSRMFSZ8T');
</script>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TL9R3739');</script>
<!-- End Google Tag Manager -->
    <meta charset="utf-8">
   <?php
   require 'files/config.php';
   use Melbahja\Seo\MetaTags;

$metatags = new MetaTags();

$metatags
        ->title($webinfo['title'].' - Công cụ fake bill chuyển khoản số 1 Việt Nam dùng để seeding')
        ->description('Dịch vụ fake bill chuyển khoản ngân hàng Vietcombank,Sacombank,MBBank,Techcombank,BIDV,Viettinbank,...')
         ->meta('keyword', 'bill fake, TaoBill.Co, fakebill, fakebillck, fake bill bidv, fake bill nước ngoài, fake bill mb, fake bill vcb, fake bill free, tao bill ck, taobillck.co, taobillck.com, fake bill,fakebill,fakebillck,fake bill chuyen tien,fake bill chuyen khoan, fake bill free, fake bill ck, fake bill ngan hang, fake bill momo, fake bill tech, fake bill vcb, fake bill mb, web tạo bill chuyển tiền giả, tạo bill chuyển tiền miễn phí, photoshop bill chuyển tiền, web fake bill')
        ->meta('author', 'BillFake.Com')
        ->image('https://billfake.com/banner123.gif');

echo $metatags;
   ?>
    <meta name="google-site-verification" content="-osTJwH7cTvi6eM2DW8RQNt6-8F_hG4CXrwsTWOmmrA" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>  
    <style>
    @media only screen and (min-width: 800px) {

        .grid-cols-5 {
    grid-template-columns: repeat(15, minmax(0, 1fr));
}
}



    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
        <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script>
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
</head>

<body
    class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TL9R3739"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php include('files/header.php');?>

            <main class="grow">  
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    <?php if(!empty($webinfo['banner'])){
                    echo '<img src="'.$webinfo['banner'].'" width="500" style="margin:auto;display:block" class="rounded mb-3"/>';
                    }?>
                    <marquee class="mt-3 mb-3" style="color:green"><b><?=$webinfo['description']?></b></marquee>

                                       
                                        
                                     <div x-show="open" x-data="{ open: true }" role="alert">
                                    
                                         <div class="px-4 py-2 rounded-sm text-sm border bg-indigo-100 dark:bg-indigo-400/30 border-indigo-200 dark:border-transparent text-indigo-500 dark:text-indigo-400 mb-3">
                                            <div class="flex w-full justify-between items-start">
                                                <div class="flex">
                                                    <svg class="w-4 h-4 shrink-0 fill-current opacity-80 mt-[3px] mr-3" viewBox="0 0 16 16">
                                                        <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm1 12H7V7h2v5zM8 6c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z"></path>
                                                    </svg>
                                                    <div><b>Update fake số dư các giao diện mới nhất !</b></div>
                                                </div>
                                                <button class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    
                                        <div class="px-4 py-2 rounded-sm text-sm border bg-indigo-100 dark:bg-indigo-400/30 border-indigo-200 dark:border-transparent text-indigo-500 dark:text-indigo-400 mb-3">
                                            <div class="flex w-full justify-between items-start">
                                                <div class="flex">
                                                    <svg class="w-4 h-4 shrink-0 fill-current opacity-80 mt-[3px] mr-3" viewBox="0 0 16 16">
                                                        <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm1 12H7V7h2v5zM8 6c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z"></path>
                                                    </svg>
                                                    <div><b>Đã update fake bill các ngân hàng giao diện mới nhất !</b></div>
                                                </div>
                                                <button class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                   
                <?php
                if(isset($_SESSION['username'])){
                ?>
                   <div class="grid grid-cols-12 gap-6 mb-4">
                       <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                            <div class="px-5 pb-5 pt-5">
  <header class="flex justify-between items-start mb-2">
                                    <!-- Icon -->
                                    <img src="./images/icon-01.svg" width="32" height="32" alt="Icon 01">
                                    <!-- Menu button -->
                           
                                </header>
                                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">Số dư</h2>
                                <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 mb-1">ID : <?=$user_new['id']?></br>Tài Khoản : <?=$_SESSION['username']?>
                               </div>
                                <div class="flex items-start">
                                    <div class="text-3xl font-bold text-slate-800 dark:text-slate-100 mr-2"><?=number_format($user_new['sodu'])?>đ</div>
                                </div>
                            </div>
                            <!-- Chart built with Chart.js 3 -->
                            <!-- Check out src/js/dashboard-charts.js for config -->
                          
                        </div>
                        <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                            <div class="px-5 pb-5 pt-5">
   <header class="flex justify-between items-start mb-2">
                                    <!-- Icon -->
                                    <img src="./images/icon-02.svg" width="32" height="32" alt="Icon 01">
                                    <!-- Menu button -->
                           
                                </header>
                                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">Tổng đã nạp</h2>
                                
                                <div class="flex items-start">
                                    <div class="text-3xl font-bold text-slate-800 dark:text-slate-100 mr-2"><?=number_format($user_new['tongtiennap'])?>đ</div>
                                </div>
                            </div>
                            <!-- Chart built with Chart.js 3 -->
                            <!-- Check out src/js/dashboard-charts.js for config -->
                          
                        </div>
  
                                <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                            <div class="px-5 pb-5 pt-5">
   <header class="flex justify-between items-start mb-2">
                                    <!-- Icon -->
                                    <img src="./images/icon-03.svg" width="32" height="32" alt="Icon 01">
                                    <!-- Menu button -->
                           
                                </header>
                                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">Gói đang dùng</h2>
                                <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase mb-1"> <a href="plans" style="color:blue">Thuê gói</a></div>
                                <div class="flex items-start">
                                    <div class="text-1xl font-bold text-slate-800 dark:text-slate-100 mr-2">
                                        <?php
                                        if(empty(trim($user_new['date_bill']))){
                                            echo '<span style="color:red">CHƯA MUA GÓI</span>';
                                        } else {

                                            echo '<span style="color:green">Dùng đến '.date_format(date_create($user_new['date_bill']),'d/m/Y').'</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Chart built with Chart.js 3 -->
                            <!-- Check out src/js/dashboard-charts.js for config -->
                          
                        </div>
</div>
                <?php } ?>
      
   <div class="grid grid-cols-12 gap-6">

                        <!-- Line chart (Acme Plus) -->
                        <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center">
                                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Công cụ</h2>
                                <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="block" aria-haspopup="true" :aria-expanded="open" @focus="open = true" @focusout="open = false" @click.prevent="" aria-expanded="false">
                                        <svg class="w-4 h-4 fill-current text-slate-400 dark:text-slate-500" viewBox="0 0 16 16">
                                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z"></path>
                                        </svg>
                                    </button>
                                    <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                        <div class="bg-white dark:bg-slate-700 dark:text-slate-100 border border-slate-200 dark:border-slate-600 p-3 rounded shadow-lg overflow-hidden mb-2" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                            <div class="text-xs text-center whitespace-nowrap">Mua gói để tiết kiệm chi phí</div>
                                        </div>
                                    </div>
                                </div>
                            </header>
                      <div class="overflow-x-auto">
                                    <table class="table-auto w-full dark:text-slate-300">
                                        <!-- Table header -->
                           
                                        <!-- Table body -->
                                        <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                                            <!-- Row -->
                                            <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/banklogo.svg" width="24" height="24" alt="Công cụ fake bill chuyển khoản">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake bill chuyển khoản</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="tao-bill-chuyen-tien" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                                 <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/banklogo.svg" width="24" height="24" alt="Công cụ fake biến động số dư">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake biến động số dư</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="tao-bien-dong-so-du" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                             <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/banklogo.svg" width="24" height="24" alt="Công cụ fake biến động số dư">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake số dư tài khoản</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="tao-so-du" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                            <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/unnamed (1).webp" width="24" height="24" alt="Fake cccd 2 mặt">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake CCCD 2 mặt</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="fake-cccd" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                            <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/passport.png
" width="24" height="24" alt="Fake Hộ Chiếu">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake Hộ Chiếu Miễn Phí</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="fake-passport" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                             
                                        <tr>
                                            <tr>
                                                <td class="p-2">
                                                   <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/unnamed (1).webp" width="24" height="24" alt="tool tạo qr cccd miễn phí">
                                        <span class="text-sm font-medium ml-3 lg:opacity-100 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tool Tạo QR CCCD Miễn Phí</span>
                                    </div>
                                                </td>
                                               
                                                <td class="p-2">
                                                    <div class="text-center text-emerald-500"><a href="create-qr-cccd" class="text-indigo-500">Tạo</a></div>
                                                </td>
     
                                            </tr>
                                        
                                            <!-- Row -->
                                         
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 py-3 px-5">
                                        <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase mb-3">Thông tin liên hệ</div>
                                         <ul class="mb-6">

                                            <li class="-mx-2">
                                                <button class="w-full p-2 rounded" @click="profileSidebarOpen = false">
                                                    <div class="flex items-center truncate">
                                                        <div class="relative mr-2">
                                                            <img class="w-8 h-8 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/2023_Facebook_icon.svg/2048px-2023_Facebook_icon.svg.png" width="32" height="32" alt="User 01">
                                                            <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
                                                        </div>
                                                        <div class="truncate">
                                                            <span class="text-sm font-medium text-slate-800 dark:text-slate-100">Fanpage Facebook<a class="ml-2 text-xs inline-flex font-medium bg-indigo-100 dark:bg-indigo-500/30 text-indigo-600 dark:text-indigo-400 rounded-full text-center px-2.5 py-1" target="_blank" href="https://www.facebook.com/fakebill.top">Liên hệ</a></span>
                                                        </div>
                                                    </div>
                                                </button>
                                            </li>
                                              <li class="-mx-2">
                                                <button class="w-full p-2 rounded" @click="profileSidebarOpen = false">
                                                    <div class="flex items-center truncate">
                                                        <div class="relative mr-2">
                                                            <img class="w-8 h-8 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/2048px-Telegram_logo.svg.png" width="32" height="32" alt="User 01">
                                                            <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
                                                        </div>
                                                        <div class="truncate">
                                                            <span class="text-sm font-medium text-slate-800 dark:text-slate-100">Group Telegram <a class="ml-2 text-xs inline-flex font-medium bg-indigo-100 dark:bg-indigo-500/30 text-indigo-600 dark:text-indigo-400 rounded-full text-center px-2.5 py-1"  target="_blank" href="https://t.me/fakebill_top">Tham gia</a></span>
                                                        </div>
                                                    </div>
                                                </button>
                                            </li>
                                              <li class="-mx-2">
                                                <button class="w-full p-2 rounded" @click="profileSidebarOpen = false">
                                                    <div class="flex items-center truncate">
                                                        <div class="relative mr-2">
                                                            <img class="w-8 h-8 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/2048px-Telegram_logo.svg.png" width="32" height="32" alt="User 01">
                                                            <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
                                                        </div>
                                                        <div class="truncate">
                                                            <span class="text-sm font-medium text-slate-800 dark:text-slate-100">Telegram Admin<a class="ml-2 text-xs inline-flex font-medium bg-indigo-100 dark:bg-indigo-500/30 text-indigo-600 dark:text-indigo-400 rounded-full text-center px-2.5 py-1"  target="_blank" href="https://t.me/doandeptrailasai">Liên Hệ</a></span>
                                                        </div>
                                                    </div>
                                                </button>
                                            </li>
                                        </ul>
                                                   
               <script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 5,
                    nav: true
                  },
                  600: {
                    items: 10,
                    nav: false
                  },
                  1000: {
                    items: 10,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
            })
          </script>
            </div>
           <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 py-3 px-3">
                             
                            <!-- Card content -->
                            <div class="flex flex-col h-full">
                                <!-- Live visitors number -->
                                <div class="px-5 py-3">
                                    <div class="flex items-center">
                                        <!-- Red dot -->
                                        <div class="relative flex items-center justify-center w-3 h-3 mr-3" aria-hidden="true">
                                            <div class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-50"></div>
                                            <div class="relative inline-flex rounded-full w-1.5 h-1.5 bg-rose-500"></div>
                                        </div>
                                        <!-- Vistors number -->
                                        <div>
                                            <div class="text-3xl font-bold text-slate-800 dark:text-slate-100 mr-2">1<?=number_format(DB::queryFirstField("SELECT COUNT(*) FROM users"))?></div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">Thành viên</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart built with Chart.js 3 -->
                                <!-- Check out src/js/analytics-charts.js for config -->
                              

                                <!-- Table -->
                                <div class="grow px-5 pb-1">
                                    <div class="overflow-x-auto">
                                        <table class="table-auto w-full dark:text-slate-300">
                                        
                                            <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                                                <!-- Row -->
                                                <tr>
                                                    <td class="py-2">
                                                        <div class="text-left">Số lượt mua bill</div>
                                                    </td>
                                                    <td class="py-2">
                                                        <div class="font-medium text-right text-slate-800"><?=number_format($webinfo['luottaobill'])?></div>
                                                    </td>
                                                </tr>    <tr>
                                                    <td class="py-2">
                                                        <div class="text-left">Số lượt tạo cccd</div>
                                                    </td>
                                                    <td class="py-2">
                                                        <div class="font-medium text-right text-slate-800">33,<?=number_format($webinfo['luottaocccd'])?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">
                                                        <div class="text-left">Số lượt tạo hộ chiếu</div>
                                                    </td>
                                                    <td class="py-2">
                                                        <div class="font-medium text-right text-slate-800"><?=number_format($webinfo['luottaohochieu'])?></div>
                                                    </td>
                                                </tr>
                                                <!-- Row -->
            
                                                <!-- Row -->
                                              
                                                <!-- Row -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Card footer -->
                              
                            </div>
                            
                        </div>
  
            </main>
       <?php
       include('files/footer.php');?>