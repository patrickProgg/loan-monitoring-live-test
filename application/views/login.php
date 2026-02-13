<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert.js"></script>

<style>
    /* @import url('https://fonts.googleapis.com/css?family=Raleway:400,700'); */
    @import url('<?php echo base_url(); ?>assets/css/style.css');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    html,
    body {
        height: 100%;
        overflow: hidden;
        /* Prevents scrolling */
    }

    body {
        /* background: linear-gradient(90deg, #C7C5F4, #776BCC); */
        background-image: url('<?= base_url('assets/images/db.jpg'); ?>');
        background-size: cover;
        background-position: center;

    }

    ::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;

    }

    .screen {
        /* background: linear-gradient(90deg, #5D54A4, #7C78B8); */
        position: relative;
        height: 300px;
        width: 360px;
        box-shadow: 0px 0px 24px #5C5696;
        /* background-color: rgba(255, 255, 255, 0.6); */
        background-color: transparent;

    }

    .screen__content {
        z-index: 1;
        position: relative;
        height: 100%;

    }

    .screen__background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
        background-color: transparent;
    }


    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
        background-color: rgba(255, 255, 255, 0.6);
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #6C63AC;
        top: -172px;
        right: 0;
        border-radius: 32px;
        background-color: rgba(93, 84, 164, 0.6);
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        /* background: linear-gradient(270deg, #5D54A4, #6A679E); */
        top: -24px;
        right: 0;
        border-radius: 32px;
        background-color: rgba(93, 84, 164, 0.6);
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #7E7BB9;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .login {
        width: 320px;
        padding: 30px;
        padding-top: 56px;
    }

    #loginButton {
        justify-content: center;
    }

    .login__field {
        padding: 10px 0px;
        position: relative;
        /* margin-left: 30px; */

    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;

    }

    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 100%;
        transition: .2s;
        align-items: center;
        border-radius: 5px;
        margin-left: 7%;
    }

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
        margin-left: 20px;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

    .social-login {
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;
        text-shadow: 0px 0px 8px #7875B5;
    }

    .social-login__icon:hover {
        transform: scale(1.5);
    }

    .custom-alert {
        position: absolute;
        top: 0;
        right: 0;
        margin: 1rem;
        z-index: 1050;
    }

    .login-container {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .glass-card {
        width: 400px;
        padding: 35px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
        text-align: center;
        transform: scale(0.8);
        transform-origin: center;
    }

    .login-title {
        color: white;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    /* INPUT BOX */
    .form-control {
        height: 48px;
        border-radius: 10px;
        border: 2px solid transparent;
        transition: 0.3s;
    }

    .form-control:focus {
        border: 2px solid var(--bs-primary);
        var(--bs-primary);
        box-shadow: 0 0 12px rgba(5, 93, 226, 0.6);
    }

    .form-label {
        color: black;
        font-weight: 500;
    }

    .btn-login {
        height: 48px;
        border-radius: 10px;
        background-color: var(--bs-primary);

        border: none;
        font-size: 18px;
        font-weight: 600;
        color: white;
        transition: 0.3s ease;
    }

    .btn-login:hover {
        background-color: var(--bs-primary);
        box-shadow: 0 0 12px rgba(5, 93, 226, 0.6);
        color: white;
    }

    .small-links a {
        color: black;
        font-size: 14px;
        text-decoration: none;
        transition: 0.3s;
    }

    .small-links a:hover {
        color: var(--bs-primary);
    }

    .small-links {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    .footer-text {
        color: white;
        font-size: 13px;
        margin-top: 30px;
        text-align: center;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONITORING</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/loan.png'); ?>">
</head>

<div class="container">
    <div class="login-container">
        <div class="glass-card">

            <img src="<?= base_url(); ?>assets/images/loan.png" style="width: 160px; margin-bottom: 15px;" />

            <div class="mb-3 text-start">
                <label class="form-label text-white">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username">
            </div>

            <div class="mb-3 text-start">
                <label class="form-label text-white">Password</label>

                <div class="position-relative">
                    <input type="password" id="password" name="password" class="form-control pe-5"
                        placeholder="Enter password">

                    <button type="button" onclick="togglePassword(event)"
                        class="btn position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent p-0">

                        <i class="mdi mdi-eye-outline fs-5"></i>
                    </button>
                </div>
            </div>

            <button class="btn btn-login w-100" id="submit">Login</button>

            <!-- <div class="small-links">
                <a href="#">Forgot Password?</a>
                <a href="#">Create Account</a>
            </div> -->
        </div>
        <div class="footer-text">
            ©
            <script>document.write(new Date().getFullYear())</script> LOAN MONITORING-SYS.
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#submit").on('click', function () {

            let username = $("#username").val();
            let password = $("#password").val();

            // ✅ Show loading swal
            Swal.fire({
                title: '<strong>Authenticating...</strong>',
                html: '<i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #4caf50;"></i><br><br>Please wait while we verify your credentials.',
                showConfirmButton: false,
                background: 'linear-gradient(135deg, #f3f4f6, #e0f7fa)',
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

            $.ajax({
                type: "POST",
                url: "<?= site_url('Login_cont/authenticate'); ?>",
                data: { username: username, password: password },
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        Swal.close(); // close loading
                        window.location.href = response.redirect;
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Server error occurred.", "error");
                }
            });
        });


        $(document).on("keydown", function (e) {
            if (e.key === "Enter") {
                $("#submit").click();
            }
        });
    });

    function togglePassword(event) {
        const button = event.currentTarget;
        const input = button.parentElement.querySelector("input");
        const icon = button.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("mdi-eye-outline", "mdi-eye-off-outline");
        } else {
            input.type = "password";
            icon.classList.replace("mdi-eye-off-outline", "mdi-eye-outline");
        }
    }
</script>