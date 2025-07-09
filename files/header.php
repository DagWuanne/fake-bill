<script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>
<script src='https://www.google.com/recaptcha/api.js?hl=vi'></script>
    <!-- Page wrapper -->
    <div class="flex h-[100dvh] overflow-hidden">

        <!-- Sidebar -->
        <div class="min-w-fit">
            <!-- Sidebar backdrop (mobile only) -->
            <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>
        
            <!-- Sidebar -->
            <div id="sidebar" class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg">
        
                <!-- Sidebar header -->
                <div class="flex justify-between mb-10 pr-3 sm:px-2">
                    <!-- Close button -->
                    <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                        </svg>
                    </button>
                    <!-- Logo -->
                       <a href="/"><img src="/logo.png"/></a>
                </div>
        
                <!-- Links -->
                <div class="space-y-8">
                    <!-- Pages group -->
                    <div>
                  
                        <ul class="">
                            <!-- Dashboard -->
             <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="<?=$domain?>/">
                                    <div class="flex items-center">
                                        <img class="w-5 h-5" src="home.png" width="24" height="24" alt="Trang chủ">
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Trang chủ</span>
                                    </div>
                                </a>
                            </li>
               <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="tao-bill-chuyen-tien">
                                    <div class="flex items-center">
                                        <img class="w-5 h-5" src="/icon_banks/banklogo2.svg" width="24" height="24" alt="Công cụ fake bill chuyển khoản">
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake bill chuyển khoản</span>
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="tao-bien-dong-so-du">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/banklogo2.svg"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake biến động số dư</span>
                                    </div>
                                </a></li>
                                  <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="tao-so-du">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/banklogo2.svg"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake số dư tài khoản</span>
                                    </div>
                                </a></li>
                                  <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="fake-cccd">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/unnamed (1).webp"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake CCCD 2 mặt</span>
                                    </div>
                                </a></li>
                                 <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="fake-passport">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/passport.png"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Fake Hộ Chiếu Free</span>
                                    </div>
                                </a></li>
                                 <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="create-qr-cccd">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/unnamed (1).webp"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tool Tạo QR CCCD Free</span>
                                    </div>
                                </a></li>
                            <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="https://subfb.top">
                                    <div class="flex items-center">
                                        <img class="w-5 h-5" src="https://img.upanh.tv/2024/05/27/fb.png" width="24" height="24" alt="tăng người theo dõi facebook">
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tăng người theo dõi fb</span>
                                    </div>
                                </a>
                            </li>
                               <?php
                 if($_SESSION['username'] == 'admin'){
                 ?>
                   <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="<?=$domain?>/admin">
                                    <div class="flex items-center">
                                         <img class="w-5 h-5" src="<?=$domain?>/icon_banks/user-gear.svg"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Admin Panel</span>
                                    </div>
                                </a>
                            </li>
                   
                 <?php } ?>
                            <!-- Community -->
              
                            <!-- Calendar -->
                            <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="payment">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="<?=$domain?>/icon_banks/profits.svg"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Nạp tiền</span>
                                    </div>
                                </a>
                            </li>
                             <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="plans">
                                    <div class="flex items-center">
                                       <img class="w-5 h-5" src="/icon_banks/vip.png"/>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Thuê gói</span>
                                    </div>
                                </a>
                            </li>
                            <!-- Campaigns -->
                           <noscript>      <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="campaigns.html">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path class="fill-current text-slate-600" d="M20 7a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 0120 7zM4 23a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 014 23z" />
                                            <path class="fill-current text-slate-400" d="M17 23a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 010-2 4 4 0 004-4 1 1 0 012 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1zM7 13a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 110-2 4 4 0 004-4 1 1 0 112 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tạo SMS Banking</span>
                                    </div>
                                </a>
                            </li>
                          <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="campaigns.html">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <path class="fill-current text-slate-600" d="M20 7a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 0120 7zM4 23a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 014 23z" />
                                            <path class="fill-current text-slate-400" d="M17 23a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 010-2 4 4 0 004-4 1 1 0 012 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1zM7 13a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 110-2 4 4 0 004-4 1 1 0 112 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">SMS màn hình khóa</span>
                                    </div>
                                </a>
                            </li></noscript>
                        
                        </ul>
                    </div>
                    <!-- More group -->
                    <div>
                        <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                            <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                            <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                        </h3>
                        <ul class="mt-3">
                            <!-- Authentication -->
<?php if(!isset($_SESSION['username'])){ ?>
                            <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                                <a class="block text-slate-200 hover:text-white transition duration-150" :class="open && 'hover:text-slate-200'" href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                                <path class="fill-current text-slate-600" d="M8.07 16H10V8H8.07a8 8 0 110 8z" />
                                                <path class="fill-current text-slate-400" d="M15 12L8 6v5H0v2h8v5z" />
                                            </svg>
                                            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tài khoản</span>
                                        </div>
                                        <!-- Icon -->
                                        <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                    <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                                        <li class="mb-1 last:mb-0">
                                            <a href="login" class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate">
                                                <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Đăng nhập</span>
                                            </a>
                                        </li>
                                        <li class="mb-1 last:mb-0">
                                            <a href="register" class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate">
                                                <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Đăng ký</span>
                                            </a>
                                        </li>
                                      
                                    </ul>
                                </div>
                            </li>
                            <?php } ?>
                            <!-- Onboarding -->
                            <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" x-data="{ open: false }">
                                <a class="block text-slate-200 hover:text-white transition duration-150" :class="open && 'hover:text-slate-200'" href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                                <path class="fill-current text-slate-600" d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                                <path class="fill-current text-slate-400" d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                            </svg>
                                            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">API web con</span>
                                        </div>
                                        <!-- Icon -->
                                        <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                    <ul class="pl-9 mt-1 hidden" :class="open ? '!block' : 'hidden'">
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="api">
                                                <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cấu hình API</span>
                                            </a>
                                        </li>
                                  
                                     
                                    </ul>
                                </div>
                            </li>
                        
                        </ul>
                    </div>
                </div>
        
                <!-- Expand / collapse button -->
                <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
                    <div class="px-3 py-2">
                        <button @click="sidebarExpanded = !sidebarExpanded">
                            <span class="sr-only">Expand / collapse sidebar</span>
                            <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                                <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                                <path class="text-slate-600" d="M3 23H1V1h2z" />
                            </svg>
                        </button>
                    </div>
                </div>
        
            </div>
        </div>

        <!-- Content area -->
        <div class="bg-white relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <header class="sticky top-0 bg-white dark:bg-[#182235] border-b border-slate-200 dark:border-slate-700 z-30">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 -mb-px">

                        <!-- Header: Left side -->
                        <div class="flex">
                            <!-- Hamburger button -->
                            <button
                                class="text-slate-500 hover:text-slate-600 lg:hidden"
                                @click.stop="sidebarOpen = !sidebarOpen"
                                aria-controls="sidebar"
                                :aria-expanded="sidebarOpen"
                            >
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="4" y="5" width="16" height="2" />
                                    <rect x="4" y="11" width="16" height="2" />
                                    <rect x="4" y="17" width="16" height="2" />
                                </svg>
                            </button>

                        </div>

                        <!-- Header: Right side -->
                        <div class="flex items-center space-x-3">
<a href="/" class="btn dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300">
                                           
                                            <span>Trang chủ</span>
                            <!-- Search button -->
                     <?php if(isset($_SESSION['username'])){ echo '<a href="payment" class="btn dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300">
                                           
                                            <span> Nạp tiền </span>';}?>
                                        </a>

                            <!-- Divider -->
                            <hr class="w-px h-6 bg-slate-200 dark:bg-slate-700 border-none" />

                             <?php
                               if(!isset($_SESSION['username'])){
                                   echo '<a href="login" class="btn dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300">Đăng nhập</a>';
                                    echo '<a href="register" class="btn dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300">Đăng ký tài khoản</a>';
                               } else {
                               echo '<a href="logout.php" class="btn bg-rose-500 hover:bg-rose-600 text-white">Đăng xuất</a>';} ?>

                        </div>

                    </div>
                </div>
            </header>