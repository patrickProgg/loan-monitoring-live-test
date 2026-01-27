<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
    <meta charset="utf-8" />
    <title>WMS-URC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script>
        var BASE_URL = "<?= base_url(); ?>";
    </script>
    <script src="<?= base_url(); ?>assets/js/plugin.js"></script>
    <script src="<?= base_url(); ?>assets/js/sweetalert.js"></script>

</head>
     <body data-sidebar="dark">
         <div id="layout-wrapper">
             <header id="page-topbar">
                 <div class="navbar-header">
                     <div class="d-flex">
                         <!-- LOGO -->
                         <div class="navbar-brand-box">
                             <a href="<?php echo base_url(); ?>dashboard" class="logo logo-dark">
                                 <span class="logo-sm">
                                     <img src="<?php echo base_url(); ?>assets/images/logo.svg" alt="" height="22" />
                                 </span>
                                 <span class="logo-lg">
                                     <img src="<?php echo base_url(); ?>assets/images/logo-dark.png" alt="" height="17" />
                                 </span>
                             </a>

                             <a href="<?php echo base_url(); ?>dashboard" class="logo logo-light">
                                 <span class="logo-sm">
                                     <img src="<?php echo base_url(); ?>assets/images/logo-light.svg" alt="" height="22" />
                                 </span>
                                 <span class="logo-lg">
                                     <img src="<?php echo base_url(); ?>assets/images/logo-light.png" alt="" height="19" />
                                 </span>
                             </a>
                         </div>

                         <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                             <i class="fa fa-fw fa-bars"></i>
                         </button>

                         <!-- App Search-->
                         <form class="app-search d-none d-lg-block">
                             <div class="position-relative">
                                 <input type="text" class="form-control" placeholder="Search..." />
                                 <span class="bx bx-search-alt"></span>
                             </div>
                         </form>
                         <!-- mega menu add here -->
                     </div>

                     <div class="d-flex">

                         <div class="dropdown d-inline-block d-lg-none ms-2">
                             <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown"aria-haspopup="true" aria-expanded="false">
                                 <i class="mdi mdi-magnify"></i>
                             </button>
                             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
        
                                 <form class="p-3">
                                     <div class="form-group m-0">
                                         <div class="input-group">
                                             <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                                             <div class="input-group-append">
                                                 <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>

                         <div class="dropdown d-none d-lg-inline-block ms-1">
                             <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                 <i class="bx bx-fullscreen"></i>
                             </button>
                         </div>

                         <div class="dropdown d-inline-block">
                             <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="bx bx-bell bx-tada"></i>
                                 <span class="badge bg-danger rounded-pill">0 </span>
                             </button>
                             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                 <div class="p-3">
                                     <div class="row align-items-center">
                                         <div class="col">
                                             <h6 class="m-0" key="t-notifications"> Notifications  </h6>
                                         </div>
                                         <div class="col-auto">
                                             <a href="#!" class="small" key="t-view-all"> View All </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div data-simplebar="" style="max-height: 230px;">
                                     <a href="javascript: void(0);" class="text-reset notification-item">
                                         <div class="d-flex">
                                             <div class="avatar-xs me-3">
                                                 <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                     <i class="bx bx-cart"></i>
                                                 </span>
                                             </div>
                                             <div class="flex-grow-1">
                                                 <h6 class="mb-1" key="t-your-order">Your order is placed </h6>
                                                 <div class="font-size-12 text-muted">
                                                     <p class="mb-1" key="t-grammer">If several languages coalesce ___ grammar </p>
                                                     <p class="mb-0"><i class="mdi mdi-clock-outline"></i>  <span key="t-min-ago">3 min ago </span></p>
                                                 </div>
                                             </div>
                                         </div>
                                     </a>
                                 </div>
                                 <div class="p-2 border-top d-grid">
                                     <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                         <i class="mdi mdi-arrow-right-circle me-1"></i>  <span key="t-view-more">View More.. </span> 
                                     </a>
                                 </div>
                             </div>
                         </div>

                         <div class="dropdown d-inline-block">
                             <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <img class="rounded-circle header-profile-user" src="<?php echo base_url(); ?>assets/images/users/avatar-1.jpg" alt="Header Avatar" />
                                 <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry </span>
                                 <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                             </button>
                             <div class="dropdown-menu dropdown-menu-end">
                                 <!-- item-->
                                 <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>  <span key="t-profile">Profile </span></a>
                                 <div class="dropdown-divider"></div>
                                 <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="logout()"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>  <span key="t-logout">Logout </span></a>
                             </div>
                         </div>

                     </div>
                 </div>
             </header>

             <script type="text/javascript">
                  function logout() {
                        Swal.fire({
                            title: 'Sign out',
                            text: "Are you sure you want to sign out?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '<?php echo base_url("User_cont/logout"); ?>',
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        if (jqXHR.status === 0) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Network Error',
                                                text: 'Please check your internet connection and try again.'
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Something went wrong! Retrying...'
                                            });
                                            //retryLogout(3); // Retry up to 3 times
                                        }
                                    },
                                    success: function(success) {          
                                        
                                        location.reload();
                                    }
                                });
                            }
                        })
                    }
             </script>
             
             <!-- ========== Left Sidebar Start ========== -->
             <div class="vertical-menu">

                 <div data-simplebar="" class="h-100">

                     <!--- Sidemenu -->
                     <div id="sidebar-menu">
                         <!-- Left Menu Start -->
                         <ul class="metismenu list-unstyled" id="side-menu">
                             <li class="menu-title" key="t-menu">Menu </li>

                             <li>
                                 <a href="<?php echo base_url(); ?>dashboard" class="waves-effect">
                                     <i class="mdi mdi-view-dashboard"></i>
                                     <span key="t-file-manager">Dashboards </span>
                                 </a>
                             </li>


                             
                             <li>
                                 <a href="<?php echo base_url(); ?>dashboard2" class="waves-effect">
                                     <i class="mdi mdi-view-dashboard"></i>
                                     <span key="t-file-manager">Dashboards 2</span>
                                 </a>
                             </li>

                             <!-- <li>
                                 <a href="javascript: void(0);" class="has-arrow waves-effect">
<i class="bx bx-share-alt"></i>
                                     <span key="t-multi-level">Multi Level </span>
                                 </a>
                                 <ul class="sub-menu" aria-expanded="true">
                                     <li><a href="javascript: void(0);" key="t-level-1-1">Level 1.1 </a></li>
                                     <li>
                                         <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Level 1.2 </a>
                                         <ul class="sub-menu" aria-expanded="true">
                                             <li><a href="javascript: void(0);" key="t-level-2-1">Level 2.1 </a></li>
                                             <li><a href="javascript: void(0);" key="t-level-2-2">Level 2.2 </a></li>
                                         </ul>
                                     </li>
                                 </ul>
                             </li> -->

                         </ul>
                     </div>
                     <!-- Sidebar -->
                 </div>
             </div>
             <!-- Left Sidebar End -->
             <!-- ============================================================== -->
             <!-- Start right Content here -->
             <!-- ============================================================== -->
             <div class="main-content">
                 <div class="page-content">
                     <div class="container-fluid">

                      </div> <!-- container-fluid -->
                </div>

            <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © WMS - URC.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop It-Sysdev
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/js/app.js"></script>

</body>

</html> 


                         
