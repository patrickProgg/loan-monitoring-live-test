<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MONITORING</title>
    <!-- <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/forklift.png" /> -->

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/daterangepicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/material.icon.css" rel="stylesheet" />

    <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
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

        a {
            text-decoration: none;
        }

        *,
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        #content main .table-data {
            display: flex;
            flex-wrap: wrap;
            grid-gap: 24px;
            margin-top: 10px;
            width: 100%;
            /* color: var(--dark); */
            color: black;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data>div {
            /* border-radius: 20px; */
            background: var(--light);
            padding: 5px;
            overflow-x: auto;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data .head {
            display: flex;
            align-items: center;
            grid-gap: 16px;
            margin-bottom: 24px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data .head h3 {
            margin-right: auto;
            font-size: 24px;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data .head .bx {
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data .order {
            flex-grow: 1;
            flex-basis: 500px;
            /* background-color: rgba(255, 255, 255, 0); */
            padding-left: 0;
            padding-right: 0;
            background-color: transparent;
        }

        #content main .table-data .order table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
        }

        #content main .table-data .order table th {
            padding-bottom: 12px;
            font-size: 13px;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid var(--grey);
            background-color: rgba(255, 255, 255, 0.1);
            color: black;
        }

        #content main .table-data .order table td {
            padding: 9px 0;
            font-size: 14px;
            /* background-color: rgba(255, 255, 255, 0.1); */
            background-color: transparent;
        }

        #content main .table-data .order table tbody tr:hover {
            background: var(--light-blue);
        }

        #content main .table-data .head {
            min-width: 420px;
        }

        #content main .table-data .order table {
            min-width: 420px;
        }

        .page-content {
            padding: 10px;
            padding-left: 60px;
            padding-right: 60px;
        }

        .main-content {
            width: 100%;
            padding: 10px;
            margin-left: 0 !important;
            padding-top: 60px;
        }

        .navbar-nav .nav-link {
            /* color: var(--bs-dark); */
            color: black;
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
            color:  var(--bs-primary) !important;
            padding-top: 11px;
            border-bottom: 3px solid var(--bs-primary) !important;
        }

        /* .active-nav {
            position: relative;
            height: 50px;
            color: var(--bs-red) !important;
            padding-top: 11px;
        }

        .active-nav::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: linear-gradient(90deg, transparent, red, transparent);
            background-size: 200% 100%;
            animation: run-border 2s linear infinite;
        }

        @keyframes run-border {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        } */


        .navbar-nav .nav-link:hover {
            color: var(--bs-primary) !important;
        }

        .icon {
            width: 14px;
            height: 14px;
        }

        .menu-label {
            font-size: 13px;
            white-space: nowrap;
        }

        @media (max-width: 765px) {
            .menu-label {
                display: none;
            }

            .nav-link .text {
                display: none;
            }
        }

        img.rounded-circle {
            object-fit: cover;
            height: 40px;
            width: 40px;
        }

        .page-fluid {
            margin-top: 20px;
        }
    </style>

</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm px-0"
        style="height: 50px; background-color: #ffffffff; position: fixed; top: 0; width: 100%; z-index: 1050; padding:0">
        <a class="navbar-brand d-flex align-items-center" style="margin-left:60px;" href="<?= base_url(); ?>dashboard"
            style="height: 100%;">
            <!-- <img src="<?= base_url(); ?>assets/images/box1.png" alt="Logo" style="height: 35px;"> -->
        </a>

        <ul class="navbar-nav flex-row align-items-center" style="margin: 0; padding: 0; column-gap: 12px;">
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'dashboard') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>dashboard">
                    <i class='bx  bxs-dashboard'></i>
                    <span class="menu-label">Dashboard</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'monitoring') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>monitoring">
                    <i class='bx bxs-user'></i>
                    <span class="menu-label">Monitoring</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'masterfile') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>masterfile">
                    <i class='bx bxs-file'></i>
                    <span class="menu-label">Pull Out</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'location') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>location">
                    <i class="bx bxs-wallet"></i>
                    <span class="menu-label">Expenses</span>
                </a>
            </li>
            <li class="nav-item" style="flex-shrink: 1; min-width: 0;">
                <a class="nav-link d-flex align-items-center gap-1 <?= ($this->uri->segment(1) == 'receiving') ? 'active-nav' : '' ?>"
                    href="<?= base_url(); ?>receiving">
                    <i class='bx bx-download'></i>
                    <span class="menu-label">History</span>
                </a>
            </li>
        </ul>

        <div class="d-flex align-items-center ms-auto" style="margin-right: 60px;">
            <li class="nav-item dropdown bell-wrapper position-relative"
                style="flex-shrink: 1; min-width: 0; list-style: none;">
                <a class="nav-link d-flex align-items-center gap-1" href="#" role="button" id="bellDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url(); ?>assets/images/chat(1).png" alt="Logo" style="height: 20px;">

                    <span id="messageCount"
                        class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                        style="display:none; min-width:18px; height:18px; font-size:0.7rem; line-height:18px; text-align:center; padding:0;">
                        0
                    </span>

                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bellDropdown" id="messageSenderDropdown"
                    style="min-width: 250px; max-height: 300px; overflow-y: auto;">
                    <li class="dropdown-item text-muted small">No new messages</li>
                </ul>
            </li>

            <div class="dropdown ms-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown">
                    <img src="<?= !empty($img)
                        ? 'http://172.16.161.34:8080/hrms//' . $img
                        : base_url('assets/images/user.png'); ?>"
                        onerror="this.onerror=null;this.src='<?= base_url('assets/images/user.png'); ?>';"
                        class="rounded-circle" alt="User Image"
                        style="object-fit: cover; margin-right: 8px; height:35px; width:35px;">

                    <span class="text">
                        <?= $this->session->userdata('fullname'); ?>
                        <i class='bx bx-chevron-down' style="font-size: 16px;"></i>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url(); ?>profile">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" style="cursor: pointer;" onclick="logout();">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <script>
        feather.replace();

        function logout() {
            Swal.fire({
                title: 'Sign out',
                text: "Are you sure you want to sign out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url("User_cont/logout"); ?>',
                        success: function () {
                            location.reload();
                        },
                        error: function (jqXHR) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        }

        
    </script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">