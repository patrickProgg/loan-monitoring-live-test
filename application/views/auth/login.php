<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login | WMS URC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/forklift.png">
    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet">
    <!-- SweetAlert -->
    <script src="<?= base_url(); ?>assets/js/sweetalert.js"></script>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
        }

        /* MAIN CONTAINER */
        .login-wrapper {
            display: flex;
            height: 100vh;
        }

        /* LEFT IMAGE */
        .login-image {
            flex: 2.0;
            background: url("<?= base_url(); ?>assets/images/bg_img.jpeg") center/cover no-repeat;
        }

        /* RIGHT PANEL */
        .login-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f2f2f2 0%, #ffffff 100%);
        }

        .login-panel::before,
        .login-panel::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.1;
        }

        .login-panel::before {
            width: 250px;
            height: 250px;
            background: #c40000;
            top: -50px;
            right: -50px;
        }

        .login-panel::after {
            width: 150px;
            height: 150px;
            background: #ff6b6b;
            bottom: -30px;
            left: -30px;
        }

        .login-box {
            position: relative;
            z-index: 1;
            background: white;
            /* keeps login box readable */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* LOGO + TITLE */
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .brand-icon {
            width: 90px;
            height: auto;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .brand-logo {
            width: 100px;
            height: auto;
            margin-bottom: 1px;
        }

        .brand-title {
            font-size: 16px;
            font-weight: 700;
            color: #c40000;
            line-height: 1.1;
        }

        /* FORM LABEL */
        .form-label {
            font-weight: 500;
            color: #333;
        }

        /* BUTTON */
        .btn-login {
            height: 46px;
            background: #c40000;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 6px;
        }

        .btn-login:hover {
            background: #a80000;
        }

        /* LINKS */
        .login-links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .login-links a {
            font-size: 13px;
            color: #666;
            text-decoration: none;
        }

        .login-links a:hover {
            color: #c40000;
        }

        /* FOOTER */
        .login-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }

            .login-panel {
                flex: 1;
            }
        }

        /* INPUTS WITH ICONS (USERNAME & PASSWORD) */
        .input-wrapper,
        .password-wrapper {
            position: relative;
        }

        .input-clean {
            height: 42px;
            padding-left: 42px;
            padding-right: 42px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .input-clean:focus {
            border-color: #c40000;
            box-shadow: none;
        }

        /* LEFT ICON */
        .input-icon-left {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        /* RIGHT EYE ICON */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 18px;
        }

        /* FOCUS STATE */
        .input-wrapper:focus-within .input-icon-left,
        .password-wrapper:focus-within .input-icon-left,
        .password-wrapper:focus-within .toggle-password {
            color: #c40000;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- LEFT IMAGE -->
        <div class="login-image"></div>

        <!-- RIGHT LOGIN PANEL -->
        <div class="login-panel">
            <div class="login-box" style="width: 360px;">

                <!-- LOGO -->
                <div class="brand">
                    <!-- Left: WMS icon -->
                    <img src="<?= base_url(); ?>assets/images/wms_icon.png" class="brand-icon">

                    <!-- Right: URC logo + text -->
                    <div class="brand-text">
                        <img src="<?= base_url(); ?>assets/images/urc_img.png" class="brand-logo">
                        <div class="brand-title">
                            Warehouse<br>Management System
                        </div>
                    </div>
                </div>

                <!-- USERNAME -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <i class="mdi mdi-account-outline input-icon-left"></i>
                        <input type="text" id="username" class="form-control input-clean" placeholder="Enter username">
                    </div>
                </div>



                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <i class="mdi mdi-lock-outline input-icon-left"></i>
                        <input type="password" id="password" class="form-control input-clean password-input"
                            placeholder="Enter password">
                        <i class="mdi mdi-eye-outline toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>


                <!-- LOGIN BUTTON -->
                <button class="btn btn-login w-100" id="submit">
                    Submit
                </button>

                <!-- LINKS -->
                <div class="login-links">
                    <a href="#">Forgot Password?</a>
                    <a href="#">Create Account</a>
                </div>

                <!-- FOOTER -->
                <div class="login-footer">
                    ©
                    <script>document.write(new Date().getFullYear())</script> WMS URC.
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            let p = document.getElementById("password");
            let icon = document.querySelector(".toggle-password");

            if (p.type === "password") {
                p.type = "text";
                icon.classList.remove("mdi-eye-outline");
                icon.classList.add("mdi-eye-off-outline");
            } else {
                p.type = "password";
                icon.classList.remove("mdi-eye-off-outline");
                icon.classList.add("mdi-eye-outline");
            }
        }


        $("#submit").on("click", function () {
            $.post("<?= site_url('User_cont/login'); ?>", {
                username: $("#username").val(),
                password: $("#password").val()
            }, function (res) {
                if (res.success) location.reload();
                else Swal.fire("Error", "Invalid credentials", "error");
            }, "json");
        });
    </script>
</body>

</html>