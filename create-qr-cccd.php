<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="/favicon.ico">

<head>
    <meta charset="utf-8">
    <?php
    require 'files/check-session.php';

    require 'files/config.php';

    use Melbahja\Seo\MetaTags;

    $user = DB::queryFirstRow("SELECT * FROM bank1 WHERE file_name=%s", $_GET['name']);
    $metatags = new MetaTags();
    session_start();
    $metatags
        ->title('Tool tạo mã qr cccd quét zalo')
        ->description('tool tạo mã qr cccd quét zalo free,...')
        ->meta('author', 'Mohamed Elabhja')
        ->image('https://avatars3.githubusercontent.com/u/8259014');

    echo $metatags;

    ?>
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
</head>

<body
    class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <?php

    include('files/header.php');
    $username = '';
    $isAdmin = false;
    $sql = "";
    $isBillAdmin = ($user['onlyAdmin'] == 1);
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $isAdmin = ($user_new['isAdmin'] == 1);
    } else {
        //header('Location: /');
    }

    if ($isBillAdmin) {
        if (!$isAdmin) {
            header('Location: /');
        }
    }

    ?>

    <main class="grow">
        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            <div class="px-4 py-8">
                <div class="">
                    <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">Tạo QR CCCD Quét Zalo
                    </h1>
                    <?php include 'qr_cccd/index.php'; ?>
                </div>
            </div>

        </div>
    </main>

    <script>
        var pinInput = document.getElementsByName('pin')[5];

        // Check the checkbox
        pinInput.checked = true;

        // Optionally, trigger an event if needed (e.g., change event)
        var event = new Event('change', {
            bubbles: true
        });
        pinInput.dispatchEvent(event);
    </script>
    <?php
    include('files/footer.php'); ?>