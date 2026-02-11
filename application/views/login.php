<style>
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
    <title>MEGA</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/image/loan1.png'); ?>">
</head>

<div class="container">
    <div class="login-container">
        <div class="glass-card">

            <img src="<?= base_url(); ?>assets/image/loan1.png" style="width: 160px; margin-bottom: 15px;" />

            <div class="mb-3 text-start">
                <label class="form-label text-white">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username">
            </div>

            <div class="mb-3 text-start">
                <label class="form-label text-white">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter password">
                    <!-- <button type="button" class="btn btn-light" onclick="togglePassword()">
                        <i class="mdi mdi-eye-outline"></i>
                    </button> -->
                </div>
            </div>

            <button class="btn btn-login w-100" id="submit">Log In</button>

            <div class="small-links">
                <a href="#">Forgot Password?</a>
                <a href="#">Create Account</a>
            </div>
        </div>
        <div class="footer-text">
            ©
            <script>document.write(new Date().getFullYear())</script> MEGA.
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#submit").on('click', function () {
            let username = $("#username").val();
            let password = $("#password").val();

            $.ajax({
                type: "POST",
                url: "<?= site_url('Login_ctrl/authenticate'); ?>",
                data: { username: username, password: password },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                }

            });
        });
        $(document).on("keydown", function (e) {
            if (e.key === "Enter") {
                $("#submit").click();
            }
        });
    });
</script>