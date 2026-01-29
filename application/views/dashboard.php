<style>
    .box-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        grid-gap: 24px;
        padding-left: 0;
        padding-right: 0;
    }

    .box-info li {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        padding: 15px;
        padding-left: 22px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        grid-gap: 24px;
    }

    .box-info li:hover {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        transform: scale(1.05) translateY(-5px);
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .box-info li .bx {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        font-size: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box-info li .text h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--dark);
        margin-top: 5px;
    }

    .box-info li .text p {
        color: var(--dark);
    }

    .box-info .user-box {
        justify-self: start;
        width: 280px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
            <div id="container" class="ms-auto"></div>
        </div>
    </div>
</div>

<?php if (!empty($show_greeting)): ?>
    <div id="greeting-toast" class="alert alert-primary" style="transition: opacity 1s;">
        <h4><?= $greeting ?></h4>
    </div>
<?php endif; ?>

<div class="row mb-5">
    <ul class="box-info">

        <a href="<?= base_url(); ?>user" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(255, 99, 132, 1);">
                <i class='bx bxs-group' style="background: rgba(255, 99, 132, 0.2); color: rgba(255, 99, 132, 1);"></i>
                <span class="text">
                    <h3><?php echo $total_client; ?></h3>
                    <p>Clients</p>
                </span>
            </li>
        </a>

        <!-- background: linear-gradient(135deg, var(--light-blue), #ffffff); -->

        <a href="<?= base_url(); ?>masterfile" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(255, 159, 64, 1);">
                <i class='bx bx-dollar-circle'
                    style="background: rgba(255, 159, 64, 0.2); color: rgba(255, 159, 64, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_loan_amt, 2) ?></h3>
                    <p>Total Loan Amt.</p>
                </span>
            </li>
        </a>

        <a href="<?= base_url(); ?>location" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(75, 192, 192, 1);">
                <i class='bx bx-wallet-alt'
                    style="background: rgba(75, 192, 192, 0.2); color: rgba(75, 192, 192, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_loan_amt - $total_loan_payment, 2) ?></h3>
                    <p>Total Receivables</p>
                </span>
            </li>
        </a>

        <a href="<?= base_url(); ?>receiving" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(153, 102, 255, 1);">
                <i class='bx bx-log-out'
                    style="background: rgba(153, 102, 255, 0.2); color: rgba(153, 102, 255, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_pull_out, 2) ?></h3>
                    <p>Total Pull Out</p>
                </span>
            </li>
        </a>

        <a href="<?= base_url(); ?>releasing" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(54, 162, 235, 1); ">
                <i class='bx bxs-flame' style="background: rgba(54, 162, 235, 0.2); color: rgba(54, 162, 235, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_expenses, 2) ?></h3>
                    <p>Total Expenses</p>
                </span>
            </li>
        </a>
    </ul>
</div>

<script>

</script>