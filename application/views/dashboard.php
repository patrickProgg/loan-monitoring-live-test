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
        /* color: var(--dark); */
        margin-top: 5px;
    }

    .box-info li .text p {
        color: var(--dark);
    }

    .box-info .user-box {
        justify-self: start;
        width: 280px;
    }

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        /* background: linear-gradient(135deg, #dbe2e7 0%, #339af0 100%); */
        background: var(--light-blue);
        color: white;
        border-bottom: none;
        padding: 20px 25px;
    }

    .card-header .card-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .h4 {
        font-size: 1.5rem;
    }

    .bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
    }

    .progress {
        border-radius: 4px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 4px;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .font-weight-bold {
        font-weight: 600 !important;
    }

    #yearSelect {
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        font-weight: 500;
    }

    #yearSelect option {
        background-color: white;
        color: #495057;
    }

    #yearSelect:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .date-input-wrapper {
        position: relative;
    }

    .date-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 10;
    }

    .date-input {
        padding-left: 40px;
        height: 48px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.3s;
        font-size: 16px;
    }

    .date-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>
<?php if (!empty($show_greeting)): ?>
    <div id="greeting-toast" class="alert alert-primary" style="transition: opacity 1s;">
        <h4><?= $greeting ?></h4>
    </div>
<?php endif; ?>

<?php extract($data ?? [], EXTR_SKIP); ?>

<div class="row px-3 pt-3" style="padding-top:10px">
    <ul class="box-info">

        <a href="<?= base_url(); ?>client" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(255, 99, 132, 1);">
                <i class='bx bx-group' style="background: rgba(255, 99, 132, 0.2); color: rgba(255, 99, 132, 1);"></i>
                <span class="text">
                    <h3><?php echo $total_client; ?></h3>
                    <p style="color:rgba(255, 99, 132, 1)">Active Clients</p>
                </span>
            </li>
        </a>

        <!-- background: linear-gradient(135deg, var(--light-blue), #ffffff); -->

        <!-- <a href="<?= base_url(); ?>masterfile" style="text-decoration: none; color: inherit;"> -->
        <li style="border-bottom: 2px solid rgba(255, 159, 64, 1);">
            <i class='bx bx-dollar-circle'
                style="background: rgba(255, 159, 64, 0.2); color: rgba(255, 159, 64, 1);"></i>
            <span class="text">
                <h3>₱<?= number_format($total_loan_amt, 2) ?></h3>
                <p style="color:rgba(255, 159, 64, 1)">Total Collectibles</p>
            </span>
        </li>
        <!-- </a> -->

        <!-- <a href="<?= base_url(); ?>location" style="text-decoration: none; color: inherit;"> -->
        <li style="border-bottom: 2px solid rgba(75, 192, 192, 1);">
            <i class='bx bx-wallet-alt' style="background: rgba(75, 192, 192, 0.2); color: rgba(75, 192, 192, 1);"></i>
            <span class="text">
                <h3>₱<?= number_format($total_loan_amt - $total_loan_payment, 2) ?></h3>
                <p style="color:rgba(75, 192, 192, 1)">Total Receivables</p>
            </span>
        </li>
        <!-- </a> -->

        <a href="<?= base_url(); ?>pull_out" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(153, 102, 255, 1);">
                <i class='bx bx-log-out'
                    style="background: rgba(153, 102, 255, 0.2); color: rgba(153, 102, 255, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_pull_out, 2) ?></h3>
                    <p style="color:rgba(153, 102, 255, 1)">Available Pull Out</p>
                </span>
            </li>
        </a>

        <a href="<?= base_url(); ?>expenses" style="text-decoration: none; color: inherit;">
            <li style="border-bottom: 2px solid rgba(54, 162, 235, 1); ">
                <i class='bx bxs-flame' style="background: rgba(54, 162, 235, 0.2); color: rgba(54, 162, 235, 1);"></i>
                <span class="text">
                    <h3>₱<?= number_format($total_expenses, 2) ?></h3>
                    <p style="color:rgba(54, 162, 235, 1)">Total Expenses</p>
                </span>
            </li>
        </a>
    </ul>
</div>


<div class="row mb-3">
    <!-- <div class="col-md-8 px-3">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0" style="display: flex; align-items: center; gap: 10px;">
                        <span>💰 Payment Filter</span>
                        <form method="GET" action="" id="dateForm" style="margin: 0;">
                            <input type="date"
                                style="width: 150px; display: inline-block; height: 28px; background-color: white; color: #444242; border-radius: 6px; border:1px solid var(--bs-info)"
                                class="form-control" id="selected_date" name="selected_date"
                                value="<?php echo $selected_date; ?>">
                        </form>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4 class="text-muted mb-3" id="dateRangeText">
                        </h4>

                        <div class="display-4 font-weight-bold text-success mb-3" id="rangeTotalDisplay">
                        </div>

                        <div class="text-muted" id="rangeInfoDisplay">
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <small class="text-muted">
                        Quick select:
                        <a href="#" data-range="day" data-date="<?php echo date('Y-m-d'); ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Today
                        </a>
                        <a href="#" data-range="week" data-date="<?php echo $selected_date; ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Week
                        </a>
                        <a href="#" data-range="month" data-date="<?php echo $selected_date; ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Month
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </div> -->

    <div class="col-md-8 px-3">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0" style="display: flex; align-items: center; gap: 10px;">
                        <span>💰 Daily</span>
                        <div style="display: flex; gap: 5px;">

                            <select id="dailyTypeSelect" class="form-control-sm border-info"
                                style="width: 120px; display: inline-block; height: 28px; color: #444242; border-radius: 6px;">
                                <option value="payments">Payments</option>
                                <option value="loan">Loan Released</option>
                                <option value="pullout">Pull Out</option>
                                <option value="expenses">Expenses</option>
                            </select>

                            <input type="date"
                                style="font-size: 12px; width: 150px; display: inline-block; height: 28px; background-color: white; color: #444242; border-radius: 6px; border:1px solid var(--bs-info)"
                                class="form-control" id="selected_date" name="selected_date"
                                value="<?php echo $selected_date; ?>">
                        </div>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4 class="text-muted mb-3" id="dateRangeText">
                            <!-- Will be updated via AJAX -->
                        </h4>

                        <div class="display-4 font-weight-bold text-success mb-3" id="rangeTotalDisplay">
                            <!-- Will be updated via AJAX -->
                        </div>

                        <div class="text-muted" id="rangeInfoDisplay">
                            <!-- Will be updated via AJAX -->
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <small class="text-muted">
                        Quick select:
                        <a href="#" data-range="day" data-date="<?php echo date('Y-m-d'); ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Today
                        </a>
                        <a href="#" data-range="week" data-date="<?php echo $selected_date; ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Week
                        </a>
                        <a href="#" data-range="month" data-date="<?php echo $selected_date; ?>"
                            class="btn btn-sm btn-outline-secondary quick-select">
                            Month
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 px-3">
        <div class="row h-100">
            <div class="col-md-12 d-flex">
                <div class="card border-left-success shadow h-100 w-100">
                    <div class="card-body py-2 d-flex flex-column justify-content-between">
                        <div class="row no-gutters align-items-center flex-grow-1">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Ongoing Loans
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $loan_status_counts['ongoing'] ?? 0; ?>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-primary text-primary">Active</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sync-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-flex mt-3">
                <div class="card border-left-warning shadow h-100 w-100">
                    <div class="card-body py-2 d-flex flex-column justify-content-between">
                        <div class="row no-gutters align-items-center flex-grow-1">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Overdue Loans
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $loan_status_counts['overdue'] ?? 0; ?>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-danger text-danger">Attention Needed</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-flex mt-3">
                <div class="card border-left-info shadow h-100 w-100">
                    <div class="card-body py-2 d-flex flex-column justify-content-between">
                        <div class="row no-gutters align-items-center flex-grow-1">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Completed Loans
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $loan_status_counts['completed'] ?? 0; ?>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-success text-success">Paid Off</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 px-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <span class="mr-2">📊 Yearly</span>
                        <select id="dataTypeSelect" class="form-control-sm border-info"
                            style="width: 120px; display: inline-block; height: 28px; color: #444242; border-radius: 6px;">
                            <option value="payments">Payments</option>
                            <option value="loan">Loan Released</option>
                            <option value="pullout">Pull Out</option>
                            <option value="expenses">Expenses</option>
                        </select>
                        <!-- <span class="mx-2">-</span> -->
                        <select id="yearSelect" class="form-control-sm border-info"
                            style="width: 80px; display: inline-block; height: 28px; background-color: white; color: #444242;">
                        </select>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="paymentChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">💰 Year
                                    <?php echo $current_year; ?> Summary
                                </h5>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Total</span>
                                        <span class="font-weight-bold text-success total-collection">
                                            ₱
                                            <?php echo number_format($year_total_payment, 2); ?>
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Average Monthly</span>
                                        <span class="font-weight-bold text-primary average-monthly">
                                            ₱
                                            <?php
                                            $avg_monthly = $year_total_payment / 12;
                                            echo number_format($avg_monthly, 2);
                                            ?>
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary"
                                            style="width: <?php echo min(100, ($avg_monthly / max($year_total_payment, 1)) * 100); ?>%">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <?php
                                    $max_month = $monthly_payments ? max($monthly_payments) : 0;
                                    $max_month_index = $max_month ? array_search($max_month, $monthly_payments) : 0;
                                    $max_month_name = $months[$max_month_index] ?? 'N/A';
                                    ?>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Highest Month (
                                            <?php echo $max_month_name; ?>)
                                        </span>
                                        <span class="font-weight-bold text-warning highest-month">
                                            ₱
                                            <?php echo number_format($max_month, 2); ?>
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning"
                                            style="width: <?php echo $max_month ? ($max_month / max($year_total_payment, 1)) * 100 : 0; ?>%">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <?php
                                    $min_month = $monthly_payments ? min(array_filter($monthly_payments)) : 0;
                                    $min_month_index = $min_month ? array_search($min_month, $monthly_payments) : 0;
                                    $min_month_name = $months[$min_month_index] ?? 'N/A';
                                    ?>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Lowest Month (
                                            <?php echo $min_month_name; ?>)
                                        </span>
                                        <span class="font-weight-bold text-info lowest-month">
                                            ₱
                                            <?php echo number_format($min_month, 2); ?>
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info"
                                            style="width: <?php echo $min_month ? ($min_month / max($year_total_payment, 1)) * 100 : 0; ?>%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 px-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">🏆 Top Good Payors</h3>
                    <!-- <span class="badge badge-danger" style="color: #444242;">Least Overduess</span> -->
                </div>
            </div>
            <div class="card-body pt-3 pb-3">
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="goodPayorsChart" style="min-height: 300px; height: 300px;"></canvas>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">📊 Performance Metrics</h5>

                                <div class="list-group">
                                    <?php if (!empty($good_payors)): ?>
                                        <?php foreach ($good_payors as $index => $payor):
                                            $completion_rate = $payor['total_loans'] > 0 ?
                                                round(($payor['completed_loans'] / $payor['total_loans']) * 100, 1) : 0;
                                            $overdue_rate = $payor['total_loans'] > 0 ?
                                                round(($payor['overdue_loans'] / $payor['total_loans']) * 100, 1) : 0;
                                            ?>
                                            <div
                                                class="list-group-item border-0 py-2 bg-transparent <?php echo $index === 0 ? 'bg-warning-light' : ''; ?>">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            <?php
                                                            // Capitalize first letter of each word
                                                            if (isset($payor['full_name'])) {
                                                                echo ucwords(strtolower($payor['full_name']));
                                                            }
                                                            ?>
                                                            <?php if ($index === 0): ?>
                                                                <span class="badge badge-warning ml-1">Top</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="small text-muted">
                                                            <?php echo $payor['total_loans']; ?> loans •
                                                            <?php echo $completion_rate; ?>% completed
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div
                                                            class="<?php echo $overdue_rate === 0 ? 'text-success' : 'text-warning'; ?> font-weight-bold">
                                                            <?php echo $overdue_rate; ?>% overdue
                                                        </div>
                                                        <div class="small text-muted">
                                                            ₱
                                                            <?php echo number_format($payor['total_paid'], 2); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No good payor data available</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {
        const ctx = document.getElementById('paymentChart').getContext('2d');
        const monthlyData = <?php echo json_encode($monthly_payments); ?>;
        const months = <?php echo json_encode($months); ?>;
        const currentYear = <?php echo $current_year; ?>;

        let paymentChart;

        // Function to format currency
        function formatCurrency(amount) {
            return '₱' + amount.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Create the chart with gradient
        paymentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Payment Amount',
                    data: monthlyData,
                    backgroundColor: function (context) {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;

                        if (!chartArea) {
                            return '#4dabf7';
                        }

                        const gradient = ctx.createLinearGradient(
                            0, chartArea.top,
                            0, chartArea.bottom
                        );

                        gradient.addColorStop(0, '#4dabf7');
                        gradient.addColorStop(0.7, '#a5d8ff');
                        gradient.addColorStop(1, '#ffffff');

                        return gradient;
                    },
                    borderColor: 'rgba(41, 128, 185, 0.8)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#4dabf7',
                        borderWidth: 1,
                        cornerRadius: 6,
                        callbacks: {
                            label: function (context) {
                                const value = context.raw;
                                const total = monthlyData.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return [
                                    formatCurrency(value),
                                    `(${percentage}% of total)`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6c757d',
                            callback: function (value) {
                                return formatCurrency(value);
                            }
                        },
                        title: {
                            display: true,
                            text: 'Amount (₱)',
                            color: '#495057',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#495057',
                            font: {
                                size: 13,
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });

        // Load available years
        $.ajax({
            url: '<?php echo site_url("View_ui_cont/get_years"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function (years) {
                const yearSelect = $('#yearSelect');
                yearSelect.empty();

                years.forEach(function (year) {
                    const selected = year == currentYear ? 'selected' : '';
                    yearSelect.append(`<option value="${year}" ${selected}>${year}</option>`);
                });
            }
        });

        // Handle data type change
        $('#dataTypeSelect').change(function () {
            const dataType = $(this).val();
            const year = $('#yearSelect').val();
            loadChartData(dataType, year);
        });

        // Handle year change
        $('#yearSelect').change(function () {
            const dataType = $('#dataTypeSelect').val();
            const year = $(this).val();
            loadChartData(dataType, year);
        });

        // Function to load chart data
        function loadChartData(dataType, year) {
            let url = '';

            switch (dataType) {
                case 'loan':
                    url = '<?php echo site_url("View_ui_cont/get_loan_chart_data/"); ?>' + year;
                    break;
                case 'payments':
                    url = '<?php echo site_url("View_ui_cont/get_payment_chart_data/"); ?>' + year;
                    break;
                case 'pullout':
                    url = '<?php echo site_url("View_ui_cont/get_pullout_chart_data/"); ?>' + year;
                    break;
                case 'expenses':
                    url = '<?php echo site_url("View_ui_cont/get_expenses_chart_data/"); ?>' + year;
                    break;
            }

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Update chart data
                        paymentChart.data.datasets[0].data = response.data;
                        paymentChart.data.datasets[0].label = response.label || getDataTypeLabel(dataType);
                        paymentChart.update();

                        // Update the year suffix only
                        $('#chartTitleSuffix').text(`${response.year}`);

                        // Update the data type select value
                        $('#dataTypeSelect').val(dataType);

                        // Update summary card
                        updateYearSummary(response.data, year, response.year_total);
                    }
                }
            });
        }

        function getDataTypeLabel(dataType) {
            switch (dataType) {
                case 'loan': return 'Loan Amount';
                case 'payments': return 'Payment Amount';
                case 'pullout': return 'Pull Out Amount';
                case 'expenses': return 'Expenses Amount';
                default: return 'Amount';
            }
        }

        function getDataTypeTitle(dataType) {
            switch (dataType) {
                case 'loan': return 'Monthly Loan Release';
                case 'payments': return 'Monthly Payments';
                case 'pullout': return 'Monthly Pull Out';
                case 'expenses': return 'Monthly Expenses';
                default: return 'Monthly Data';
            }
        }

        function updateYearSummary(data, year, yearTotal = null) {
            const total = yearTotal || data.reduce((a, b) => a + b, 0);
            const avgMonthly = total / 12;
            const maxMonthValue = Math.max(...data);
            const maxMonthIndex = data.indexOf(maxMonthValue);
            const maxMonthName = months[maxMonthIndex];
            const minMonthValue = Math.min(...data.filter(val => val > 0));
            const minMonthIndex = data.indexOf(minMonthValue);
            const minMonthName = months[minMonthIndex];

            // Update summary card
            $('.card-title.text-center').text('💰 Year ' + year + ' Summary');
            $('.total-collection').text('₱ ' + Number(total).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $('.average-monthly').text('₱ ' + Number(avgMonthly).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            $('.highest-month').text('₱ ' + maxMonthValue.toLocaleString('en-PH', { minimumFractionDigits: 2 }));
            // $('.highest-month').prev().find('span').text('Highest Month (' + maxMonthName + ')');
            $('.highest-month').prev('span').text('Highest Month (' + maxMonthName + ')');
            $('.lowest-month').text('₱ ' + minMonthValue.toLocaleString('en-PH', { minimumFractionDigits: 2 }));
            // $('.lowest-month').prev().find('span').text('Lowest Month (' + minMonthName + ')');
            $('.lowest-month').prev('span').text('Lowest Month (' + minMonthName + ')');

            // $('.average-monthly').text(formatCurrency(avgMonthly));
            // $('.highest-month').text(formatCurrency(maxMonthValue));
            // $('.highest-month').prev().find('span').text('Highest Month (' + maxMonthName + ')');
            // $('.lowest-month').text(formatCurrency(minMonthValue));
            // $('.lowest-month').prev().find('span').text('Lowest Month (' + minMonthName + ')');

            // Update progress bars (optional)
            $('.progress-bar.bg-success').css('width', '100%');
            $('.progress-bar.bg-primary').css('width', min(100, (avgMonthly / Math.max(total, 1)) * 100) + '%');
            $('.progress-bar.bg-warning').css('width', maxMonthValue ? (maxMonthValue / Math.max(total, 1)) * 100 : 0 + '%');
            $('.progress-bar.bg-info').css('width', minMonthValue ? (minMonthValue / Math.max(total, 1)) * 100 : 0 + '%');
        }

        // Helper functions
        function min(a, b) {
            return a < b ? a : b;
        }

        function max(a, b) {
            return a > b ? a : b;
        }
    });

    // $(document).ready(function () {
    //     const goodPayorsCtx = document.getElementById('goodPayorsChart').getContext('2d');
    //     let goodPayorsChart;

    //     // Initial data from PHP
    //     const initialGoodPayors = <?php echo json_encode($good_payors); ?>;

    //     // Sort the data by performance score (if not already sorted in PHP)
    //     const sortedPayors = [...initialGoodPayors].sort((a, b) => {
    //         // Calculate performance score if not already present
    //         const scoreA = a.performance_score || calculateScore(a);
    //         const scoreB = b.performance_score || calculateScore(b);
    //         return scoreB - scoreA; // Descending order
    //     });

    //     // Helper function to calculate performance score
    //     function calculateScore(payor) {
    //         let score = payor.completed_loans * 10;
    //         score -= payor.overdue_loans * 20;
    //         score += (payor.total_loans > 0) ? (payor.completed_loans / payor.total_loans) * 100 : 0;
    //         return score;
    //     }

    //     // Prepare chart data from SORTED payors
    //     const payorNames = sortedPayors.map(p => {
    //         if (!p.full_name) return '';
    //         return p.full_name.split(' ').map(word =>
    //             word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
    //         ).join(' ');
    //     });

    //     // Performance scores for the chart
    //     const performanceScores = sortedPayors.map(p =>
    //         p.performance_score || calculateScore(p)
    //     );

    //     // Create horizontal bar chart (already in your code, just need to update data source)
    //     function createHorizontalBarChart() {
    //         if (goodPayorsChart) {
    //             goodPayorsChart.destroy();
    //         }

    //         goodPayorsChart = new Chart(goodPayorsCtx, {
    //             type: 'bar',
    //             data: {
    //                 labels: payorNames,
    //                 datasets: [{
    //                     label: 'Performance Score (Higher is Better)',
    //                     data: performanceScores,
    //                     backgroundColor: function (context) {
    //                         const chart = context.chart;
    //                         const { ctx, chartArea } = chart;
    //                         const value = context.dataset.data[context.dataIndex];
    //                         const rank = context.dataIndex + 1;

    //                         if (!chartArea) {
    //                             if (rank === 1) return 'rgba(255, 193, 7, 0.8)'; // Gold for 1st
    //                             if (rank === 2) return 'rgba(192, 192, 192, 0.8)'; // Silver for 2nd
    //                             if (rank === 3) return 'rgba(205, 127, 50, 0.8)'; // Bronze for 3rd
    //                             if (value >= 80) return 'rgba(76, 175, 80, 0.7)';
    //                             if (value >= 50) return 'rgba(33, 150, 243, 0.7)';
    //                             return 'rgba(244, 67, 54, 0.7)';
    //                         }

    //                         // Right-to-left gradient
    //                         const gradient = ctx.createLinearGradient(
    //                             chartArea.right, 0,
    //                             chartArea.left, 0
    //                         );

    //                         if (rank === 1) {
    //                             gradient.addColorStop(0, 'rgba(255, 193, 7, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(255, 213, 79, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(255, 248, 200, 0.5)');
    //                         } else if (rank === 2) {
    //                             gradient.addColorStop(0, 'rgba(192, 192, 192, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(211, 211, 211, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(245, 245, 245, 0.5)');
    //                         } else if (rank === 3) {
    //                             gradient.addColorStop(0, 'rgba(205, 127, 50, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(210, 140, 70, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(255, 235, 215, 0.5)');
    //                         } else if (value >= 80) {
    //                             gradient.addColorStop(0, 'rgba(76, 175, 80, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(129, 199, 132, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(240, 255, 240, 0.5)');
    //                         } else if (value >= 50) {
    //                             gradient.addColorStop(0, 'rgba(33, 150, 243, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(100, 181, 246, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(227, 242, 253, 0.5)');
    //                         } else {
    //                             gradient.addColorStop(0, 'rgba(244, 67, 54, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(239, 83, 80, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(255, 235, 238, 0.5)');
    //                         }

    //                         return gradient;
    //                     },
    //                     borderColor: function (context) {
    //                         const value = context.dataset.data[context.dataIndex];
    //                         const rank = context.dataIndex + 1;

    //                         if (rank === 1) return 'rgba(218, 165, 32, 1)';
    //                         if (rank === 2) return 'rgba(169, 169, 169, 1)';
    //                         if (rank === 3) return 'rgba(139, 90, 43, 1)';
    //                         if (value >= 80) return 'rgba(56, 142, 60, 1)';
    //                         if (value >= 50) return 'rgba(25, 118, 210, 1)';
    //                         return 'rgba(198, 40, 40, 1)';
    //                     },
    //                     borderWidth: 2,
    //                     borderRadius: 8,
    //                     borderSkipped: false,
    //                 }]
    //             },
    //             options: {
    //                 indexAxis: 'y',
    //                 responsive: true,
    //                 maintainAspectRatio: false,
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         position: 'top',
    //                         labels: {
    //                             font: {
    //                                 size: 12,
    //                                 weight: 'bold'
    //                             }
    //                         }
    //                     },
    //                     title: {
    //                         display: true,
    //                         text: 'Top Good Payors - Performance Score Ranking',
    //                         font: {
    //                             size: 16,
    //                             weight: 'bold'
    //                         },
    //                         padding: {
    //                             top: 10,
    //                             bottom: 30
    //                         }
    //                     },
    //                     tooltip: {
    //                         callbacks: {
    //                             title: function (context) {
    //                                 const rank = context[0].dataIndex + 1;
    //                                 const rankText = rank === 1 ? '🥇' : rank === 2 ? '🥈' : rank === 3 ? '🥉' : `#${rank}`;
    //                                 return `${rankText} ${context[0].label}`;
    //                             },
    //                             label: function (context) {
    //                                 return `Score: ${context.parsed.x.toFixed(1)}`;
    //                             },
    //                             afterLabel: function (context) {
    //                                 const payor = sortedPayors[context.dataIndex];
    //                                 const score = performanceScores[context.dataIndex];
    //                                 const rank = context.dataIndex + 1;

    //                                 return [
    //                                     `Rank: ${rank}/${sortedPayors.length}`,
    //                                     `Total Loans: ${payor.total_loans}`,
    //                                     `Completed: ${payor.completed_loans} (${payor.total_loans > 0 ? Math.round((payor.completed_loans / payor.total_loans) * 100) : 0}%)`,
    //                                     `Overdue: ${payor.overdue_loans}`,
    //                                     `Ongoing: ${payor.ongoing_loans}`,
    //                                     `Amount Paid: ₱${parseFloat(payor.total_paid || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}`
    //                                 ];
    //                             }
    //                         }
    //                     }
    //                 },
    //                 scales: {
    //                     x: {
    //                         beginAtZero: true,
    //                         title: {
    //                             display: true,
    //                             text: 'Performance Score',
    //                             font: {
    //                                 size: 13,
    //                                 weight: 'bold'
    //                             }
    //                         },
    //                         grid: {
    //                             color: 'rgba(0, 0, 0, 0.1)'
    //                         }
    //                     },
    //                     y: {
    //                         grid: {
    //                             display: false
    //                         },
    //                         ticks: {
    //                             padding: 15,
    //                             font: {
    //                                 size: 12,
    //                                 weight: 'bold'
    //                             },
    //                             callback: function (value, index) {
    //                                 const rank = index + 1;
    //                                 const rankIcon = rank === 1 ? '🥇 ' : rank === 2 ? '🥈 ' : rank === 3 ? '🥉 ' : '';
    //                                 return rankIcon + this.getLabelForValue(value);
    //                             }
    //                         }
    //                     }
    //                 },
    //                 animation: {
    //                     duration: 1000,
    //                     easing: 'easeOutQuart'
    //                 }
    //             }
    //         });
    //     }

    //     // Alternative: Horizontal bar chart (better for long names)
    //     function createHorizontalBarChart() {
    //         if (goodPayorsChart) {
    //             goodPayorsChart.destroy();
    //         }

    //         goodPayorsChart = new Chart(goodPayorsCtx, {
    //             type: 'bar',
    //             data: {
    //                 labels: payorNames,
    //                 datasets: [{
    //                     label: 'Performance Score (Higher is Better)',
    //                     data: initialGoodPayors.map(p => {
    //                         let score = p.completed_loans * 10;
    //                         score -= p.overdue_loans * 20;
    //                         score += (p.total_loans > 0) ? (p.completed_loans / p.total_loans) * 100 : 0;
    //                         return score;
    //                     }),
    //                     backgroundColor: function (context) {
    //                         const chart = context.chart;
    //                         const { ctx, chartArea } = chart;
    //                         const value = context.dataset.data[context.dataIndex];

    //                         if (!chartArea) {
    //                             if (value >= 80) return 'rgba(76, 175, 80, 0.7)';
    //                             if (value >= 50) return 'rgba(255, 193, 7, 0.7)';
    //                             return 'rgba(244, 67, 54, 0.7)';
    //                         }

    //                         // Right-to-left gradient
    //                         const gradient = ctx.createLinearGradient(
    //                             chartArea.right, 0,   // start at the right
    //                             chartArea.left, 0     // end at the left
    //                         );

    //                         if (value >= 80) {
    //                             gradient.addColorStop(0, 'rgba(76, 175, 80, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(129, 199, 132, 0.7)');
    //                             gradient.addColorStop(1, 'rgb(255, 255, 255)');
    //                         } else if (value >= 50) {
    //                             gradient.addColorStop(0, 'rgba(255, 193, 7, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(255, 213, 79, 0.7)');
    //                             gradient.addColorStop(1, 'rgb(255, 255, 255)');
    //                         } else {
    //                             gradient.addColorStop(0, 'rgba(244, 67, 54, 0.9)');
    //                             gradient.addColorStop(0.7, 'rgba(239, 83, 80, 0.7)');
    //                             gradient.addColorStop(1, 'rgba(255, 255, 255, 0.99)');
    //                         }

    //                         return gradient;
    //                     },
    //                     borderColor: function (context) {
    //                         const value = context.dataset.data[context.dataIndex];
    //                         if (value >= 80) return 'rgba(56, 155, 60, 0.8)';
    //                         if (value >= 50) return 'rgba(235, 173, 0, 0.8)';
    //                         return 'rgba(224, 47, 34, 0.8)';
    //                     },
    //                     borderWidth: 1.5,
    //                     borderRadius: 6,
    //                     borderSkipped: false,
    //                 }]
    //             },
    //             options: {
    //                 indexAxis: 'y',
    //                 responsive: true,
    //                 maintainAspectRatio: false,
    //                 plugins: {
    //                     legend: {
    //                         position: 'top',
    //                     },
    //                     title: {
    //                         display: true,
    //                         text: 'Good Payors Performance Score'
    //                     },
    //                     tooltip: {
    //                         callbacks: {
    //                             afterLabel: function (context) {
    //                                 const payor = initialGoodPayors[context.dataIndex];
    //                                 return [
    //                                     `Total Loans: ${payor.total_loans}`,
    //                                     `Completed: ${payor.completed_loans} (${payor.total_loans > 0 ? Math.round((payor.completed_loans / payor.total_loans) * 100) : 0}%)`,
    //                                     `Overdue: ${payor.overdue_loans}`,
    //                                     `Amount Paid: ₱${parseFloat(payor.total_paid || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}`
    //                                 ];
    //                             }
    //                         }
    //                     }
    //                 },
    //                 scales: {
    //                     x: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             color: 'rgba(0, 0, 0, 0.05)'
    //                         },
    //                         border: {
    //                             display: false // ✅ removes the line under bars
    //                         },
    //                         title: {
    //                             display: true,
    //                             text: 'Performance Score'
    //                         }
    //                     }
    //                     ,
    //                     y: {
    //                         grid: {
    //                             display: false // Removes vertical grid lines
    //                         },
    //                         ticks: {
    //                             padding: 10 // Adds spacing between labels and bars
    //                         }
    //                     }
    //                 }
    //             }
    //         });
    //     }
    //     // Initialize with horizontal bar chart
    //     createHorizontalBarChart();
    // });

    $(document).ready(function () {
        const goodPayorsCtx = document.getElementById('goodPayorsChart').getContext('2d');
        let goodPayorsChart;

        // Initial data from PHP
        const initialGoodPayors = <?php echo json_encode($good_payors); ?>;

        // Sort the data by performance score (if not already sorted in PHP)
        const sortedPayors = [...initialGoodPayors].sort((a, b) => {
            // Calculate performance score if not already present
            const scoreA = a.performance_score || calculateScore(a);
            const scoreB = b.performance_score || calculateScore(b);
            return scoreB - scoreA; // Descending order
        });

        // Helper function to calculate performance score
        function calculateScore(payor) {
            let score = payor.completed_loans * 10;
            score -= payor.overdue_loans * 20;
            score += (payor.total_loans > 0) ? (payor.completed_loans / payor.total_loans) * 100 : 0;
            return score;
        }

        // Prepare chart data from SORTED payors
        const payorNames = sortedPayors.map(p => {
            if (!p.full_name) return '';
            return p.full_name.split(' ').map(word =>
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');
        });

        // Performance scores for the chart
        const performanceScores = sortedPayors.map(p =>
            p.performance_score || calculateScore(p)
        );

        // Create horizontal bar chart (already in your code, just need to update data source)
        function createHorizontalBarChart() {
            if (goodPayorsChart) {
                goodPayorsChart.destroy();
            }
            goodPayorsChart = new Chart(goodPayorsCtx, {
                type: 'bar',
                data: {
                    labels: payorNames,
                    datasets: [{
                        // label: 'Performance Score (Higher is Better)',
                        data: performanceScores,
                        backgroundColor: function (context) {
                            const chart = context.chart;
                            const { ctx, chartArea } = chart;
                            const value = context.dataset.data[context.dataIndex];
                            const rank = context.dataIndex + 1;

                            if (!chartArea) {
                                if (rank === 1) return 'rgba(255, 193, 7, 0.8)'; // Gold for 1st
                                if (rank === 2) return 'rgba(192, 192, 192, 0.8)'; // Silver for 2nd
                                if (rank === 3) return 'rgba(205, 127, 50, 0.8)'; // Bronze for 3rd
                                if (value >= 80) return 'rgba(76, 175, 80, 0.7)';
                                if (value >= 50) return 'rgba(33, 150, 243, 0.7)';
                                return 'rgba(244, 67, 54, 0.7)';
                            }

                            // Right-to-left gradient
                            const gradient = ctx.createLinearGradient(
                                chartArea.right, 0,
                                chartArea.left, 0
                            );

                            if (rank === 1) {
                                gradient.addColorStop(0, 'rgba(255, 193, 7, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(255, 213, 79, 0.7)');
                                gradient.addColorStop(1, 'rgba(255, 248, 200, 0.5)');
                            } else if (rank === 2) {
                                gradient.addColorStop(0, 'rgba(192, 192, 192, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(211, 211, 211, 0.7)');
                                gradient.addColorStop(1, 'rgba(245, 245, 245, 0.5)');
                            } else if (rank === 3) {
                                gradient.addColorStop(0, 'rgba(205, 127, 50, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(210, 140, 70, 0.7)');
                                gradient.addColorStop(1, 'rgba(255, 235, 215, 0.5)');
                            } else if (value >= 80) {
                                gradient.addColorStop(0, 'rgba(76, 175, 80, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(129, 199, 132, 0.7)');
                                gradient.addColorStop(1, 'rgba(240, 255, 240, 0.5)');
                            } else if (value >= 50) {
                                gradient.addColorStop(0, 'rgba(33, 150, 243, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(100, 181, 246, 0.7)');
                                gradient.addColorStop(1, 'rgba(227, 242, 253, 0.5)');
                            } else {
                                gradient.addColorStop(0, 'rgba(244, 67, 54, 0.9)');
                                gradient.addColorStop(0.7, 'rgba(239, 83, 80, 0.7)');
                                gradient.addColorStop(1, 'rgba(255, 235, 238, 0.5)');
                            }

                            return gradient;
                        },
                        borderColor: function (context) {
                            const value = context.dataset.data[context.dataIndex];
                            const rank = context.dataIndex + 1;

                            if (rank === 1) return 'rgba(218, 165, 32, 1)';
                            if (rank === 2) return 'rgba(169, 169, 169, 1)';
                            if (rank === 3) return 'rgba(139, 90, 43, 1)';
                            if (value >= 80) return 'rgba(56, 142, 60, 1)';
                            if (value >= 50) return 'rgba(25, 118, 210, 1)';
                            return 'rgba(198, 40, 40, 1)';
                        },
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        // legend: {
                        //     display: true,
                        //     position: 'top',
                        //     labels: {
                        //         font: {
                        //             size: 12,
                        //             weight: 'bold'
                        //         }
                        //     }
                        // },
                        // title: {
                        //     display: true,
                        //     text: 'Top Good Payors - Performance Score Ranking',
                        //     font: {
                        //         size: 16,
                        //         weight: 'bold'
                        //     },
                        //     padding: {
                        //         top: 10,
                        //         bottom: 30
                        //     }
                        // },
                        legend: {
                            display: false // This hides the entire legend
                        },
                        tooltip: {
                            callbacks: {
                                title: function (context) {
                                    const rank = context[0].dataIndex + 1;
                                    const rankText = rank === 1 ? '🥇' : rank === 2 ? '🥈' : rank === 3 ? '🥉' : `#${rank}`;
                                    return `${rankText} ${context[0].label}`;
                                },
                                label: function (context) {
                                    return `Score: ${context.parsed.x.toFixed(1)}`;
                                },
                                afterLabel: function (context) {
                                    const payor = sortedPayors[context.dataIndex];
                                    const score = performanceScores[context.dataIndex];
                                    const rank = context.dataIndex + 1;

                                    return [
                                        `Rank: ${rank}/${sortedPayors.length}`,
                                        `Total Loans: ${payor.total_loans}`,
                                        `Completed: ${payor.completed_loans} (${payor.total_loans > 0 ? Math.round((payor.completed_loans / payor.total_loans) * 100) : 0}%)`,
                                        `Overdue: ${payor.overdue_loans}`,
                                        `Ongoing: ${payor.ongoing_loans}`,
                                        `Amount Paid: ₱${parseFloat(payor.total_paid || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Performance Score',
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                padding: 15,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                callback: function (value, index) {
                                    const rank = index + 1;
                                    const rankIcon = rank === 1 ? '🥇 ' : rank === 2 ? '🥈 ' : rank === 3 ? '🥉 ' : '';
                                    return rankIcon + this.getLabelForValue(value);
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        // Initialize with horizontal bar chart
        createHorizontalBarChart();
    });

    // $(document).ready(function () {
    //     // Handle date input change
    //     $('#selected_date').change(function () {
    //         const selectedDate = $(this).val();
    //         const rangeType = getCurrentRangeType(); // You need to track the current range type
    //         loadPaymentFilterData(selectedDate, rangeType);
    //     });

    //     // Handle quick select clicks
    //     $('.quick-select').click(function (e) {
    //         e.preventDefault();
    //         const rangeType = $(this).data('range');
    //         const selectedDate = $(this).data('date');

    //         // Update the date input value
    //         $('#selected_date').val(selectedDate);

    //         // Load data
    //         loadPaymentFilterData(selectedDate, rangeType);
    //     });

    //     // Function to load payment filter data
    //     function loadPaymentFilterData(selectedDate, rangeType) {
    //         $.ajax({
    //             url: '<?php echo site_url("View_ui_cont/get_payment_filter_data"); ?>',
    //             method: 'GET',
    //             data: {
    //                 selected_date: selectedDate,
    //                 range_type: rangeType
    //             },
    //             dataType: 'json',
    //             success: function (response) {
    //                 if (response.success) {
    //                     updatePaymentFilterUI(response.data);
    //                 }
    //             },
    //             error: function (xhr, status, error) {
    //                 console.error('AJAX Error:', error);
    //             }
    //         });
    //     }

    //     // Function to update the UI
    //     function updatePaymentFilterUI(data) {
    //         // Update date range text
    //         let dateRangeHtml = '';
    //         if (data.is_single_day) {
    //             dateRangeHtml = `Payments for <span class="text-primary">${data.start_date_display}</span>`;
    //         } else {
    //             dateRangeHtml = `Payments from <span class="text-primary">${data.start_date_display}</span> to <span class="text-primary">${data.end_date_display}</span>`;
    //         }
    //         $('#dateRangeText').html(dateRangeHtml);

    //         // Update total amount
    //         $('#rangeTotalDisplay').text(data.range_total_formatted);

    //         // Update range info
    //         let rangeInfoHtml = `<i class="fas fa-calendar-alt"></i> `;
    //         if (data.is_single_day) {
    //             rangeInfoHtml += 'Single day';
    //         } else {
    //             rangeInfoHtml += data.days_count + ' day' + (data.days_count > 1 ? 's' : '');
    //         }

    //         if (data.is_today) {
    //             rangeInfoHtml += ` <span class="badge badge-success ml-2 text-muted">Today</span>`;
    //         }

    //         $('#rangeInfoDisplay').html(rangeInfoHtml);

    //         // Update quick select links with current selected date
    //         $('.quick-select[data-range="week"]').data('date', data.selected_date);
    //         $('.quick-select[data-range="month"]').data('date', data.selected_date);
    //     }

    //     // Helper function to get current range type
    //     function getCurrentRangeType() {
    //         // You can store this in a data attribute or variable
    //         // For now, we'll check the active quick select button
    //         const activeButton = $('.quick-select.active');
    //         if (activeButton.length) {
    //             return activeButton.data('range');
    //         }
    //         return 'day'; // default
    //     }

    //     // Initial load (optional - you can keep the PHP-rendered initial state)
    //     // or load via AJAX on page load
    //     <?php if (isset($selected_date) && isset($range_type)): ?>
        //         loadPaymentFilterData('<?php echo $selected_date; ?>', '<?php echo $range_type; ?>');
        //     <?php endif; ?>
    // });

    $(document).ready(function () {
        // Track current values
        let currentDate = $('#selected_date').val();
        let currentRangeType = getCurrentRangeType();
        let currentDailyType = $('#dailyTypeSelect').val();

        // Handle date input change
        $('#selected_date').change(function () {
            currentDate = $(this).val();
            currentRangeType = getCurrentRangeType();
            currentDailyType = $('#dailyTypeSelect').val();
            loadPaymentFilterData();
        });

        // Handle daily type select change
        $('#dailyTypeSelect').change(function () {
            currentDailyType = $(this).val();
            currentDate = $('#selected_date').val();
            currentRangeType = getCurrentRangeType();
            loadPaymentFilterData();
        });

        // Handle quick select clicks
        $('.quick-select').click(function (e) {
            e.preventDefault();

            // Update active state
            $('.quick-select').removeClass('active btn-secondary').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary').addClass('active btn-secondary');

            // Update current values
            currentRangeType = $(this).data('range');
            currentDate = $(this).data('date');
            currentDailyType = $('#dailyTypeSelect').val();

            // Update date input
            $('#selected_date').val(currentDate);

            // Load data
            loadPaymentFilterData();
        });

        // Main function to load payment filter data (similar to loadChartData)
        function loadPaymentFilterData() {
            // Construct URL based on daily type
            let url = getFilterDataUrl(currentDailyType);

            // Show loading state
            $('#rangeTotalDisplay').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#dateRangeText').html('Loading...');

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    selected_date: currentDate,
                    range_type: currentRangeType
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Update UI with response data
                        updatePaymentFilterUI(response.data);

                        // Update any additional elements
                        // updateFilterSummary(response.data, currentDailyType);

                        // Update the data type select value (optional, ensures consistency)
                        $('#dailyTypeSelect').val(currentDailyType);
                    } else {
                        console.error('Error in response:', response);
                        showErrorState();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showErrorState();
                }
            });
        }

        // Helper function to get URL based on daily type (similar to switch in loadChartData)
        function getFilterDataUrl(dailyType) {
            const urls = {
                'payments': '<?php echo site_url("View_ui_cont/get_payment_filter_data"); ?>',
                'loan': '<?php echo site_url("View_ui_cont/get_loan_filter_data"); ?>',
                'pullout': '<?php echo site_url("View_ui_cont/get_pullout_filter_data"); ?>',
                'expenses': '<?php echo site_url("View_ui_cont/get_expenses_filter_data"); ?>'
            };

            // Return URL for the selected type, default to payments URL if not found
            return urls[dailyType] || '<?php echo site_url("View_ui_cont/get_payment_filter_data"); ?>';
        }

        // Function to update the UI (similar structure to your chart update)
        function updatePaymentFilterUI(data) {
            // Update date range text with proper label
            const typeLabel = getDataTypeLabel(currentDailyType);
            let dateRangeHtml = '';

            if (data.is_single_day) {
                dateRangeHtml = `${typeLabel} for <span class="text-primary">${data.start_date_display}</span>`;
            } else {
                dateRangeHtml = `${typeLabel} from <span class="text-primary">${data.start_date_display}</span> to <span class="text-primary">${data.end_date_display}</span>`;
            }
            $('#dateRangeText').html(dateRangeHtml);

            // Update total amount with appropriate color
            const totalColor = getTotalColorClass(currentDailyType);
            $('#rangeTotalDisplay')
                .removeClass('text-success text-danger text-info text-warning')
                .addClass(totalColor)
                .text(data.range_total_formatted);

            // Update range info
            let rangeInfoHtml = `<i class="fas fa-calendar-alt"></i> `;
            if (data.is_single_day) {
                rangeInfoHtml += 'Single day';
            } else {
                rangeInfoHtml += data.days_count + ' day' + (data.days_count > 1 ? 's' : '');
            }

            if (data.is_today) {
                rangeInfoHtml += ` <span class="badge badge-success ml-2 text-muted">Today</span>`;
            }

            $('#rangeInfoDisplay').html(rangeInfoHtml);
        }

        // Helper function to get label for data type (similar to your chart label function)
        function getDataTypeLabel(dataType) {
            const labels = {
                'payments': 'Payments',
                'loan': 'Loan Releases',
                'pullout': 'Pull Outs',
                'expenses': 'Expenses'
            };
            return labels[dataType] || 'Transactions';
        }

        // Helper function to get color class based on data type
        function getTotalColorClass(dataType) {
            const colors = {
                'payments': 'text-success',
                'loan': 'text-info',
                'pullout': 'text-warning',
                'expenses': 'text-danger'
            };
            return colors[dataType] || 'text-success';
        }

        // Function to update summary/filter display (similar to updateYearSummary)
        function updateFilterSummary(data, dataType) {
            let badgeClass = '';
            let icon = '';

            switch (dataType) {
                case 'payments':
                    badgeClass = 'bg-success';
                    icon = '💰';
                    break;
                case 'loan':
                    badgeClass = 'bg-info';
                    icon = '🏦';
                    break;
                case 'pullout':
                    badgeClass = 'bg-warning';
                    icon = '💸';
                    break;
                case 'expenses':
                    badgeClass = 'bg-danger';
                    icon = '📝';
                    break;
                default:
                    badgeClass = 'bg-secondary';
                    icon = '📊';
            }

            // Add count if available
            const countText = data.count ? ` (${data.count} items)` : '';

            const filterHtml = `
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="badge ${badgeClass} text-white p-2">
                    <i class="fas fa-filter mr-1"></i> ${icon} ${getDataTypeLabel(dataType)}${countText}
                </span>
                <small class="text-muted">
                    <i class="fas fa-calendar-day"></i> ${data.start_date_display} - ${data.end_date_display}
                </small>
            </div>
        `;

            $('#filterTypeDisplay').html(filterHtml);
        }

        // Helper function to show error state
        function showErrorState() {
            $('#rangeTotalDisplay').text('Error loading data');
            $('#dateRangeText').text('Failed to load data');
            $('#rangeInfoDisplay').html('<i class="fas fa-exclamation-triangle text-danger"></i> Please try again');
        }

        // Helper function to get current range type
        function getCurrentRangeType() {
            const activeButton = $('.quick-select.active');
            if (activeButton.length) {
                return activeButton.data('range');
            }
            return 'day'; // default
        }

        // Set initial active state based on PHP variable
        <?php if (isset($range_type) && $range_type != 'day'): ?>
            $('.quick-select').removeClass('active btn-secondary').addClass('btn-outline-secondary');
            $(`.quick-select[data-range="<?php echo $range_type; ?>"]`).removeClass('btn-outline-secondary').addClass('active btn-secondary');
        <?php else: ?>
            $('.quick-select[data-range="day"]').removeClass('btn-outline-secondary').addClass('active btn-secondary');
        <?php endif; ?>

        // Initial load
        <?php if (isset($selected_date) && isset($range_type)): ?>
            // Set initial values
            currentDate = '<?php echo $selected_date; ?>';
            currentRangeType = '<?php echo $range_type; ?>';
            currentDailyType = '<?php echo isset($daily_type) ? $daily_type : 'payments'; ?>';

            // Set select values
            $('#dailyTypeSelect').val(currentDailyType);
            $('#selected_date').val(currentDate);

            // Load initial data
            loadPaymentFilterData();
        <?php endif; ?>
    });
</script>

<?php if ($this->session->flashdata('welcome_toast')): ?>

    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "<?= $this->session->flashdata('welcome_toast'); ?>",
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            width: '400px'
        });
    </script>

<?php endif; ?>