<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quản trị hệ thống | QLCH</title>
    <link rel="shortcut icon" href="../../../images/logo-nobg.png" type="image/x-icon" />

    <!-- Font Awesome CSS -->
    <link href="../../css/all.css" rel="stylesheet" />

    <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="../../js/tailwindcss.js"></script>

    <!-- jQuery -->
    <script src="../../js/jquery.min.js"></script>

    <!-- Chart -->
    <script src="../../js/chart.js"></script>

    <!-- Font Awesome JS -->
    <script src="../../js/all.js"></script>

    <!-- Bootstrap Bundle JS  -->
    <script src="../../js/bootstrap.bundle.min.js"></script>

    <style>
        .activeAd {
            background-color: rgb(55 65 81);
            color: #FFF !important;
        }

        .subnav {
            display: none;
        }

        .user-container:hover .subnav {
            display: inline-block;
            width: 150px;
        }


        #calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin: 20px 0;
        }

        .day {
            border: 1px solid #ccc;
            padding: 20px;
            position: relative;
            cursor: pointer;
        }

        .dot {
            width: 10px;
            height: 10px;
            background-color: orange;
            border-radius: 50%;
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: none;
        }

        .hidden {
            display: none;
        }

        #info {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<?php
error_reporting(1);
session_start();
include("../../../model/connect.php");

$db = new Database();
$conn = $db->connect();

if (isset($_POST["btnxem"])) {
    $_SESSION["startM"] = $_POST["startM"];
    $_SESSION["endM"] = $_POST["endM"];

    $daystart = explode("-", $_SESSION["startM"]);
    $startM = implode("-", array($daystart[0], $daystart[1], $daystart[2]));
    $dayend = explode("-", $_SESSION["endM"]);
    $endM = implode("-", array($dayend[0], $dayend[1], $dayend[2]));
} else {
    $startM = date("Y-m-01");
    $endM = date("Y-m-t");
}

$startW = date("Y-m-d", strtotime("monday this week"));
$endW = date("Y-m-d", strtotime("sunday this week"));
?>

<body class="bg-gray-100" style="scroll-behavior: smooth; font-family: 'Playwrite DE Grund', cursive;">
    <div class="flex flex-col md:flex-row h-full" id="container">
        <div class="bg-gray-900 w-full md:w-64">
            <div class="flex items-center justify-center h-20 w-full bg-gray-800">
                <a href="index.php">
                    <img src="../../../images/logo-nobg.png" alt="Logo" class="size-20">
                </a>
            </div>
            <nav class="mt-10">
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="admin" href="index.php">
                    <i class="fas fa-tachometer-alt mr-3"></i>Tổng quan
                </a>
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="employee" href="index.php?i=employee">
                    <i class="fa-solid fa-users-gear mr-3"></i></i>Quản lý nhân viên
                </a>
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="menu" href="index.php?i=menu">
                    <i class="fa-solid fa-utensils mr-3"></i>Quản lý món ăn
                </a>
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="revenue" href="index.php?i=revenue">
                    <i class="fa-solid fa-file-invoice-dollar mr-3"></i>Thống kê doanh thu
                </a>
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="shift" href="index.php?i=shift">
                    <i class="fa-regular fa-calendar-days mr-3"></i>Lịch làm việc
                </a>
                <a class="flex items-center py-2 px-8 text-gray-400 hover:bg-gray-700 hover:text-white adnav" id="attendance" href="index.php?i=attendance">
                    <i class="fa-solid fa-clock mr-3"></i>Bảng chấm công
                </a>
            </nav>
        </div>
        <div class="flex-1 p-6 pb-2 md:p-10">
            <div class="flex justify-between items-center mb-6 hover:cursor-pointer">
                <div class="relative w-1/2 flex">
                    <input class="w-full py-2 px-4 mr-2 rounded-lg border border-gray-300" placeholder="Tìm kiếm..." type="text" />
                    <button type="submit" class="btn btn-primary ml-2 px-3">Tìm</button>
                </div>
                <div class="flex items-center hover:cursor-pointer">
                    <div class="ml-4 bg-blue-100 text-blue-500 p-2 rounded-full text-xl hover:bg-blue-500 hover:text-white">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <div class="ml-4 bg-blue-100 text-blue-500 p-2 rounded-full text-xl hover:bg-blue-500 hover:text-white">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <div class="ml-4 flex items-center relative user-container">
                        <img alt="User Avatar" class="rounded-full mr-1 border-solid border-2" height="40" width="40" src="../../../images/user.png" />
                        <span class="text-xs font-bold ml-1">
                            <?php
                            $name = $_SESSION["name"];
                            echo $name;
                            ?>
                        </span>

                        <div class="subnav absolute top-11 right-0 bg-white rounded-lg bg-gray-500 h-fit p-2 text-center border-2">
                            <a href="../../../index.php" onclick="logout()">Đăng xuất <i class="fa-solid fa-right-from-bracket"></i></a>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            $i = "";
            if (isset($_REQUEST["i"])) {
                $i = $_REQUEST["i"];
            } else {
                $i = "home";
            }

            if ($i != "home") {
                require("" . $_REQUEST["i"] . "/index.php");
            } else {
                require("home/index.php");
            }
            ?>
        </div>
    </div>
    </div>

    <script>
        const navAd = document.querySelectorAll(".adnav");
        let idActiveAd = "admin";

        navAd.forEach(function(item) {
            item.addEventListener("click", () => {
                navAd.forEach((i) => i.classList.remove("activeAd"));
            });
        });

        if (window.location.search != "")
            idActiveAd = window.location.search.slice(3);

        window.addEventListener("load", () => {
            navAd.forEach(function(item) {
                if (item.id == idActiveAd) item.classList.add("activeAd");
                else item.classList.remove("activeAd");
            });
        });
        
        function logout() {
            <?php unset($_SESSION["loginadmin"]); 
            unset($_SESSION["name"]); ?>
        }
    </script>
</body>

</html>