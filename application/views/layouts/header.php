<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MONITORING</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/loan.png" />

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/daterangepicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/material.icon.css" rel="stylesheet" />

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sweetalert.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/qrcode.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/JsBarcode.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>

    <link id="bootstrap-style" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="app-style" href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" />

    <style>
        @import url('<?php echo base_url(); ?>assets/css/style.css');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        :root {
            --poppins: 'Poppins', sans-serif;

            --light: #F9F9F9;
            --blue: #3C91E6;
            --light-blue: #CFE8FF;
            --light-grey: rgb(220, 223, 226);
            --grey: #eee;
            --dark-grey: #AAAAAA;
            --dark: #342E37;
            --red: #DB504A;
            --yellow: #FFCE26;
            --light-yellow: #FFF2C6;
            --orange: #FD7238;
            --light-orange: #FFE0D3;
            --silver: #f3efefa2;
        }

        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
        }

        body {
            background: var(--silver);
            /* background: silver; */
            overflow-x: hidden;
        }

        .btn {
            font-size: 11px;
        }

        #content main {
            width: 100%;
            /* padding: 8px 15px; */
            font-family: var(--poppins);
            /* max-height: calc(100vh - 56px); */
            overflow-y: auto;
        }

        #content main .head-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 16px;
            flex-wrap: wrap;
        }

        .head-title .buttons {
            display: flex;
            flex-direction: column;
            /* Stack buttons vertically */
            gap: 10px;
            /* Add spacing between buttons */
        }

        #content main .head-title .btn-upload {
            height: 36px;
            padding: 0 16px;
            border-radius: 36px;
            background: var(--red);
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            grid-gap: 10px;
            font-weight: 500;
        }

        #content main .head-title .btn-download {
            height: 36px;
            padding: 0 16px;
            border-radius: 36px;
            background: var(--blue);
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            grid-gap: 10px;
            font-weight: 500;
        }

        #content main .table-data {
            display: flex;
            flex-wrap: wrap;
            grid-gap: 24px;
            margin-top: 10px;
            width: 100%;
            color: var(--dark);
            /* color: #ffffff; */
            font-size: 14px;
        }

        #content main .table-data>div {
            /* border-radius: 20px; */
            background: var(--light);
            padding: 24px;
            overflow-x: auto;
            background-color: rgb(255, 255, 255);
            /* background-color: transparent; */
            /* White background with 50% opacity */
        }

        #content main .table-data .head {
            display: flex;
            align-items: center;
            grid-gap: 16px;
            margin-bottom: 24px;
        }

        #content main .table-data .head h3 {
            margin-right: auto;
            font-size: 24px;
            font-weight: 600;
        }

        #content main .table-data .head .bx {
            cursor: pointer;
        }

        #content main .table-data .order {
            flex-grow: 1;
            flex-basis: 500px;
        }

        #content main .table-data .order table {
            width: 100%;
            border-collapse: collapse;
        }

        #content main .table-data .order table th {
            font-size: 13px;
            text-align: left;
            padding-left: 5px;
            color: var(--dark);
            /* background: silver; */
            font-weight: bold;
            background: var(--light-grey);
            padding-right: 0;
        }

        #content main .table-data .order table td {
            padding: 10px 0;
            font-size: 14px;
            padding-left: 5px;
            padding-right: 5px;
            background: transparent;

        }

        /* #content main .table-data .order table tbody tr:hover {
            background: var(--light-blue);
        } */

        .form-control {
            border: 1px solid #cfd1d8;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }

        /* MAIN */
        /* CONTENT */

        #content main .table-data .head {
            min-width: 420px;
        }

        #content main .table-data .order table {
            min-width: 420px;
        }


        .page-content {
            padding: 10px;
            padding-left: 100px;
            padding-right: 100px;
        }

        .main-content {
            width: 100%;
            /* padding: 10px; */
            margin-left: 0 !important;
            /* background-image: url('https://www.transparenttextures.com/patterns/clean-gray-paper.png'); */
            padding-top: 40px;
            overflow: hidden;
        }

        .navbar-nav .nav-link {
            color: var(--bs-dark);
            /* color: dark; */

            font-size: 14px;
        }

        .navbar .container-fluid {
            padding-left: 0 !important;
            height: 60px !important;
        }

        footer.footer {
            width: 100%;
            left: 0;
        }

        .active-nav {
            height: 50px;
            color: var(--bs-black) !important;
            padding-top: 11px;
            border-bottom: 3px solid var(--bs-primary) !important;
        }

        .navbar-nav .nav-link:hover {
            /* color: var(--bs-primary) !important; */
            color: var(--bs-black) !important;
        }

        #content main {
            overflow-x: hidden;
        }

        .page-title-box {
            color: black;
        }

        @media (max-width: 765px) {
            .menu-label {
                display: none;
            }

            .nav-link .text {
                display: none;
            }
        }

        #datefilter {
            text-align: center;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--bs-primary);
        }

        /* .dataTables_filter input {
            width: 300px !important;
            display: inline-block;
        } */

        input[type="text"] {
            text-transform: capitalize;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_desc:before {
            display: none !important;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm px-0" style="height: 50px; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: linear-gradient(rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.7)), url('<?php echo base_url("assets/images/blue.png"); ?>'); width: 100%; position:
        fixed; top: 0; width: 100%; z-index: 1050; padding:0">
        <a class="navbar-brand d-flex align-items-center"
            style="margin-left:129px; background-color: #ffffff; height: 100%; padding: 0 15px; border-radius: 4px;"
            href="<?= base_url(); ?>dashboard">
            <span style="font-size: 1.5rem; margin-right: 5px;">📊</span>
            <span style="color: #333;">Dashboard</span>
        </a>

        <ul class="navbar-nav flex-row align-items-center me-auto" style="margin: 0; padding: 0; column-gap: 12px;">
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'dashboard') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>dashboard">
                    <i class="bx bx-pulse"></i>
                    <span class="menu-label">Dashboard</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'client') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>client">
                    <i class='bx bx-user'></i>
                    <span class="menu-label">Client</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'pull_out') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>pull_out">
                    <i class='bx bx-receipt'></i>
                    <span class="menu-label">Pull Out</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'expenses') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>expenses">
                    <i class="bx bx-wallet"></i>
                    <span class="menu-label">Expenses</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'history') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>history">
                    <i class='bx bx-history'></i>
                    <span class="menu-label">History</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto" style="margin-right:122px;">
            <li class="nav-item">
                <a href="<?= base_url('logout') ?>" class="nav-link logout text-danger" id="logout-link">
                    <i class="bx bx-log-out"></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Navbar End -->

    <script>
        feather.replace();

        document.addEventListener('DOMContentLoaded', function () {
            const logoutLink = document.getElementById('logout-link');

            logoutLink.addEventListener('click', function (e) {
                e.preventDefault(); // prevent immediate logout

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, logout!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // show loading swal
                        Swal.fire({
                            title: '<strong>Logging Out...</strong>',
                            html: '<i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #4caf50;"></i><br><br>Please wait while we logged you out.',
                            showConfirmButton: false,
                            // background: 'linear-gradient(135deg, #f3f4f6, #e0f7fa)',
                            color: '#333',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                const swalContent = Swal.getHtmlContainer();
                                if (swalContent) {
                                    swalContent.style.textAlign = 'center';
                                }
                            }
                        });

                        setTimeout(() => {
                            window.location.href = logoutLink.href;
                        }, 500);
                    }
                });
            });
        });

    </script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">