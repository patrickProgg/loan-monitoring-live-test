<style>
    .page-content .container-fluid {
        padding-top: 5px !important;
    }

    /* ---------- Tabs ---------- */
    .nav-tabs-custom .nav-link {
        border-bottom: 2px solid transparent;
        transition: 0.3s ease;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs-custom .nav-link:hover {
        border-color: #e9ecef;
    }

    .nav-tabs-custom .nav-link.active {
        border-bottom: 2px solid #007bff;
        color: #007bff;
        background-color: transparent;
    }

    /* ---------- Profile Photo ---------- */
    .profile-user img {
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* ---------- Card ---------- */
    .card {
        border-radius: 0.5rem;
    }
</style>
</head>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <!-- Left Profile Card -->
                    <div class="col-xxl-3">
                        <div class="card">
                            <div class="card-body p-4 text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                    <?php
                                    if (!empty($user->photo)) {
                                        $photo_filename = basename($user->photo);
                                        $photo_url = 'http://172.16.161.34:8080/hrms/images/users/' . $photo_filename;
                                    } else {
                                        $photo_url = base_url('assets/img/user-dummy-img.jpg');
                                    }
                                    ?>
                                    <img src="<?= $photo_url; ?>"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image" style="width: 150px; height: 150px;" />
                                </div>
                                <h6 class="fs-16 mb-1">
                                    <?= $this->session->userdata('fullname'); ?>
                                </h6>
                                <p class="text-muted mb-0">
                                    <?= isset($user->position) ? htmlspecialchars($user->position, ENT_QUOTES, 'UTF-8') : 'N/A' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Profile Info -->
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab">
                                            <i class="fas fa-user"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="fas fa-lock"></i> Change Username / Password
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <!-- Personal Details Tab -->
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" disabled value="<?php
                                                $fullname = $this->session->userdata('fullname');
                                                $parts = explode(',', $fullname);

                                                if (count($parts) > 1) {
                                                    $name_part = trim($parts[1]);
                                                    $words = explode(' ', $name_part);

                                                    if (count($words) > 1) {
                                                        array_pop($words);
                                                    }
                                                    echo implode(' ', $words);
                                                } else {
                                                    echo '';
                                                }
                                                ?>">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" disabled value="<?php
                                                $fullname = $this->session->userdata('fullname');
                                                $last_name = explode(',', $fullname)[0];
                                                echo trim($last_name);
                                                ?>">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label">Department</label>
                                                <input type="text" class="form-control" disabled
                                                    value="<?= isset($user->department) ? htmlspecialchars($user->department, ENT_QUOTES, 'UTF-8') : 'N/A' ?>">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label">Business Unit</label>
                                                <input type="text" class="form-control" disabled
                                                    value="<?= isset($user->business_unit) ? htmlspecialchars($user->business_unit, ENT_QUOTES, 'UTF-8') : 'N/A' ?>">
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label">User Type</label>
                                                <input type="text" class="form-control" disabled
                                                    value="<?= isset($user->user_type) ? htmlspecialchars($user->user_type, ENT_QUOTES, 'UTF-8') : 'N/A' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Change Password Tab -->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form id="profileForm" action="javascript:void(0);">
                                            <div class="row g-2">
                                                <div class="col-lg-6">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username"
                                                        value="<?= htmlspecialchars($user->username) ?>" />
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="newpassword" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="newpassword"
                                                        name="newpassword" placeholder="Enter new password" />
                                                </div>
                                                <div class="col-lg-12 mt-3 text-end">
                                                    <button type="submit" class="btn btn-primary">Save & Change</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#profileForm').submit(function () {
            $.ajax({
                url: "<?= base_url('User_cont/update_profile') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Back to Login',
                            cancelButtonText: 'Not Now'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?= base_url('User_cont/logout') ?>";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while submitting the form.',
                        icon: 'error'
                    });
                }
            });
            return false;
        });
    });
</script>