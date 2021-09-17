<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Drive Dashboard</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class="nav bg-white shadow w-full">
        <div class="lg:max-w-screen-lg lg:mx-auto mx-6 flex py-2">
            <div class="nav-brand flex items-center w-1/5">
                <img src="images/logo_app_small.png" width="30px">
                <h3 class="font-semibold text-xl ml-4">LMS Drive</h3>
            </div>

            <form class="nav-right items-center flex justify-item w-3/5">
                <div class="w-full flex rounded border overflow-hidden">
                    <button class="p-2 text-indigo-800"><i class="fa fa-search"></i></button>
                    <input type="text" name="search" class="p-2 w-full outline-none" placeholder="Cari Berkas...">
                </div>
            </form>
            <div class="text-right w-1/5 leading-none flex items-center flex-row-reverse">
                <div class="relative w-full">
                    <a href="javascript:void(0)" onclick="toggleNav()" class="leading-none">
                        <span class="align-text-top"><?=strlen($_SESSION['auth']['username']) > 7 ? substr($_SESSION['auth']['username'],0,7).'..' : $_SESSION['auth']['username']?></span>
                        <i class="fa fa-user-circle text-indigo-800 text-2xl ml-2"></i> 
                        <i class="fa fa-caret-down align-text-top ml-2"></i>
                    </a>
                    <div class="nav-box absolute shadow bg-white hidden p-4 w-full text-left" style="top:45px;">
                        <a href="?action=auth/logout" class="block">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main bg-gray-100" style="min-height:calc(100vh - 58px);height:auto;">