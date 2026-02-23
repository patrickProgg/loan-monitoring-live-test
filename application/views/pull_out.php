<style>
    .total-box {
        background: linear-gradient(135deg, var(--light-blue), #ffffff);
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid var(--light-blue);
        height: 58px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 130px;
    }

    .total-label {
        font-size: 10px;
        color: #6c757d;
        font-weight: 500;
    }

    .total-value {
        font-size: 16px;
        font-weight: 600;
        color: var(--blue);
        line-height: 1.2;
    }

    .top-bar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    /* Input focus effects */
    .form-control:focus,
    .form-select:focus {
        border-color: #f5576c;
        box-shadow: 0 0 0 0.2rem rgba(245, 87, 108, 0.25);
    }

    /* Quick amount buttons hover */
    .quick-amount:hover {
        background-color: #f5576c;
        border-color: #f5576c;
        color: white;
    }
</style>
<section id="content">
    <main>
        <div class="table-data">
            <div class="order pt-2" style="background-color:transparent">
                <div class="row">
                    <div class="col-12 d-flex">
                        <button class="btn btn-primary me-2" onclick="openModal('addPullOut')">
                            <i class="fas fa-list me-1"></i> Add New
                        </button>
                        <div class="ms-auto">
                            <button class="btn btn-success" id="withdrawBtn">
                                <i class="fas fa-download me-1"></i> Withdraw Pullout
                            </button>
                            <button class="btn btn-info" id="withdrawHistoryBtn">
                                <i class="fas fa-history me-1"></i> Withdraw History
                            </button>
                        </div>
                    </div>

                    <div id="customTotalsContainer" style="margin-bottom:10px; display:flex; gap:10px;">
                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-receipt me-1"></i> Processing Fee
                            </div>
                            <div class="total-value" id="totalFee">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-purchase-tag me-1"></i> Ticket
                            </div>
                            <div class="total-value" id="totalTicket">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-line-chart me-1"></i> Sharing Profit
                            </div>
                            <div class="total-value" id="totalProfit">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-bar-chart me-1"></i> Pull Out 2%
                            </div>
                            <div class="total-value" id="totalPullOut">₱0.00</div>
                        </div>
                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-wallet me-1"></i> Pull Out Capital
                            </div>
                            <div class="total-value" id="totalPullOutCapital">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-money me-1"></i> Total Amount
                            </div>
                            <div class="total-value" id="totalAmount">₱0.00</div>
                        </div>

                    </div>

                    <table id="pull_out_table" class="table table-hover mb-0 pb-0" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%; vertical-align: middle; text-align:center;">NO</th>
                                <th style="width: 10%; vertical-align: middle;">DATE</th>
                                <th style="width: 12%; vertical-align: middle;">PROCESSING FEE</th>
                                <th style="width: 12%; vertical-align: middle;">TICKET AMT</th>
                                <th style="width: 12%; vertical-align: middle;">SHARING PROFIT</th>
                                <th style="width: 12%; vertical-align: middle;">PULL OUT 2%</th>
                                <th style="width: 12%; vertical-align: middle;">PULL OUT CAPITAL</th>
                                <th style="width: 12%; vertical-align: middle;">TOTAL AMT</th>
                                <th style="width: 20%; vertical-align: middle; text-align: center;">ACTION</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addPullOut" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:700px; margin-top: 10px;">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-cogs me-2 text-danger"></i>
                            Pull Out Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container p-0">
                            <!-- Pull Out Form -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-money-bill-wave me-2 text-danger"></i>
                                        Pull Out Computation
                                    </h6>
                                </div>
                                <div class="card-body pb-4">
                                    <form id="pull_out_form">
                                        <!-- First Row -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-percent me-1"></i> PROCESSING FEE
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number" class="form-control form-control-lg"
                                                        placeholder="0.00" id="process_fee" name="process_fee"
                                                        autocomplete="off" min="0" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-ticket-alt me-1"></i> TICKET
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number" class="form-control form-control-lg"
                                                        placeholder="0.00" id="ticket" name="ticket" autocomplete="off"
                                                        min="0" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-hand-holding-usd me-1"></i> SHARING PROFIT
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number" class="form-control form-control-lg"
                                                        placeholder="0.00" id="profit" name="profit" min="0"
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second Row -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-chart-line me-1"></i> PULL OUT 2%
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number" class="form-control form-control-lg"
                                                        placeholder="0.00" id="pull_out" name="pull_out" min="0"
                                                        step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-coins me-1"></i> PULL OUT CAPITAL
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number" class="form-control form-control-lg"
                                                        placeholder="0.00" id="pull_out_capital" name="pull_out_capital"
                                                        min="0" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-calculator me-1"></i> TOTAL PULL OUT
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number"
                                                        class="form-control form-control-lg fw-bold text-danger"
                                                        id="total_amt" name="total_amt" readonly
                                                        style="background-color: #f8f9fa;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-calendar-alt me-1"></i> DATE PULL OUT
                                                </label>
                                                <input type="date" class="form-control form-control-lg" id="date_added"
                                                    name="date_added" value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" onclick="handleFormSubmit(currentAction, currentId)"
                                        id="submitBtn" name="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Pull Out
                                    </button>
                                    <button type="button" class="btn btn-light ms-2 " data-bs-dismiss="modal"
                                        id="closeModalBtn">
                                        <i class="fas fa-times me-1"></i> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="withdrawPullout" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:600px; margin-top: 10px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-hand-holding-usd me-2 text-danger"></i>
                            Pullout Withdrawal
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <!-- Pullout Balance Card -->
                            <div class="mb-4">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-auto">
                                            <div class="bg-gradient-danger h-100 px-4 d-flex align-items-center">
                                                <i class="fas fa-hand-holding-usd fs-1 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card-body p-4">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <label class="text-muted small text-uppercase fw-bold">
                                                        <i class="fas fa-circle me-2 text-danger"
                                                            style="font-size: 8px;"></i>
                                                        Available Pullout Balance
                                                    </label>
                                                </div>
                                                <div class="d-flex align-items-end">
                                                    <span class="text-muted me-2 fs-4 mb-1">₱</span>
                                                    <input type="text"
                                                        class="form-control border-0 p-0 fs-1 fw-bold text-dark"
                                                        id="total_pullout" value="0.00" readonly
                                                        style="background: transparent; height: auto;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Withdrawal Form -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 pt-2 px-4">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                        Withdrawal Details
                                    </h6>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <!-- Amount and Date in same row -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small mb-2">
                                                <i class="fas fa-coins me-1"></i> AMOUNT TO WITHDRAW
                                            </label>
                                            <div class="input-group">
                                                <!-- <span class="input-group-text bg-light border-0">
                                                    <i class="fas fa-peso-sign"></i>
                                                </span> -->
                                                <input type="number" class="form-control form-control-lg"
                                                    id="withdraw_amount" name="withdraw_amount" placeholder="0.00"
                                                    min="0" step="0.01" value="">
                                                <span class="input-group-text bg-light border-0">PHP</span>
                                            </div>
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Max withdrawable: ₱<span id="max_withdrawable">0.00</span>
                                            </small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small mb-2">
                                                <i class="fas fa-calendar-alt me-1"></i> WITHDRAWAL DATE
                                            </label>
                                            <input type="date" class="form-control form-control-lg" id="withdrawal_date"
                                                name="withdrawal_date" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>

                                    <!-- Withdrawal Reason / Notes -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-muted small mb-2">
                                            <i class="fas fa-pen me-1"></i> NOTES / REASON
                                        </label>
                                        <textarea class="form-control" id="withdrawal_notes" name="withdrawal_notes"
                                            rows="2"
                                            placeholder="Enter withdrawal reason or notes (optional)"></textarea>
                                    </div>

                                    <!-- Quick Amount Selector -->
                                    <div>
                                        <label class="form-label fw-bold text-muted small mb-2">
                                            <i class="fas fa-bolt me-1"></i> QUICK SELECT
                                        </label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                data-amount="100">₱100</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                data-amount="500">₱500</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                data-amount="1000">₱1,000</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                data-amount="5000">₱5,000</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                data-amount="10000">₱10,000</button>
                                            <button type="button" class="btn btn-outline-danger btn-sm quick-amount"
                                                id="max_amount">Max</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="process_withdrawal" name="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-1"></i> Process Withdrawal
                                    </button>
                                    <button type="button" class="btn btn-light ms-2" data-bs-dismiss="modal"
                                        id="closeModalBtn">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Withdraw History Modal -->
        <div class="modal fade" id="withdrawHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg" style="max-width:800px; margin-top: 10px;">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-history me-2 text-info"></i>
                            Withdrawal History
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pb-0">
                        <div class="container p-0">
                            <!-- History Table -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-list me-2 text-info"></i>
                                        Transaction List
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="withdrawalHistoryTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>DATE</th>
                                                    <th>AMOUNT</th>
                                                    <th>NOTES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">Loading data...</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <th colspan="3" class="text-end">Total:</th>
                                                    <th id="footerTotal">₱0.00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="pagination-container px-4 pb-4" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted small" id="pageInfo2"></span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-secondary btn-sm" id="firstPage"
                                                title="First Page">
                                                <i class="fas fa-angle-double-left"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" id="prevPage"
                                                title="Previous Page">
                                                <i class="fas fa-angle-left"></i>
                                            </button>

                                            <div class="d-flex align-items-center mx-2">
                                                <span class="mx-1">Page</span>
                                                <select class="form-select form-select-sm" id="pageSelector"
                                                    style="width: 80px;">
                                                    <option value="1">1</option>
                                                </select>
                                                <span class="mx-1">of <span id="totalPages">1</span></span>
                                            </div>

                                            <button class="btn btn-outline-secondary btn-sm" id="nextPage"
                                                title="Next Page">
                                                <i class="fas fa-angle-right"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" id="lastPage"
                                                title="Last Page">
                                                <i class="fas fa-angle-double-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
</section>

<script>
    let currentId = 0;

    var pull_out_table = $("#pull_out_table").DataTable({
        dom:
            "<'top-bar mb-0'lf>" +
            "rt" +
            "<'d-flex justify-content-between mt-0 pt-0'<'dataTables_info pt-0'i><'dataTables_paginate pt-0'p>>",

        columnDefs: [{ targets: '_all', orderable: true }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '<?php echo site_url('PullOut_cont/get_pull_out'); ?>',
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            },
            dataSrc: function (json) {
                if (json.total_amt !== undefined) {
                    $('#totalFee').text('₱' + parseFloat(json.total_fee).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                    $('#totalTicket').text('₱' + parseFloat(json.total_ticket).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                    $('#totalProfit').text('₱' + parseFloat(json.total_profit).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                    $('#totalPullOut').text('₱' + parseFloat(json.total_pull_out).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                    $('#totalPullOutCapital').text('₱' + parseFloat(json.total_pull_out_capital).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                    $('#totalAmount').text('₱' + parseFloat(json.total_amt).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
                }
                return json.data;
            }
        },
        columns: [
            {
                data: null,
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'date_added', class: 'text-center' },
            {
                data: 'process_fee',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'ticket',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'profit_share',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'pull_out',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'pull_out_capital',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'total_pull_out',
                class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-success me-1" onclick='openModal("editPullOut", ${JSON.stringify(row)})'>
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteBtn('${data}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    `;
                }
            }
        ],
        initComplete: function () {
            var $topBar = $('.top-bar');

            $('.dataTables_length').appendTo($topBar).addClass('me-3 pt-3 mb-0');

            $('#customTotalsContainer').appendTo($topBar).addClass('customTotals');
            $('.customTotals').css({
                display: 'flex',
                gap: '10px',
                position: 'absolute',
                marginLeft: '160px',
                justifyContent: 'flex-start',
                flexGrow: 1
            });

            $('.dataTables_filter').appendTo($topBar).addClass('ms-3 pt-3 mb-0');
        }
    });

    function deleteBtn(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will move data to history!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Deleting pullout...',
                    html: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: "<?php echo base_url('PullOut_cont/delete_id'); ?>",
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (res) {
                        Swal.close();
                        Swal.fire({
                            title: 'Deleted!',
                            text: res.message,
                            icon: 'success',
                            timer: 800,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            pull_out_table.ajax.reload();
                        });
                    },
                    error: function (err) {
                        Swal.close();
                        console.log(err);
                        Swal.fire('Error', 'Server error. Check console.', 'error');
                    }
                });
            }
        });
    }

    function calculateTotal() {
        let process_fee = parseFloat($('#process_fee').val()) || 0;
        let ticket = parseFloat($('#ticket').val()) || 0;
        let profit = parseFloat($('#profit').val()) || 0;
        let pull_out = parseFloat($('#pull_out').val()) || 0;
        let pull_out_capital = parseFloat($('#pull_out_capital').val()) || 0;

        let total = process_fee + ticket + profit + pull_out + pull_out_capital;

        $('#total_amt').val(total.toFixed(2));
    }

    $('#process_fee, #ticket, #profit, #pull_out, #pull_out_capital').on('input', calculateTotal);

    function openModal(action, row) {

        console.log(action);
        console.log(row);

        currentAction = action;

        if (row) {
            currentId = row.id;
        }
        console.log(currentId);

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = action.startsWith('add') ?
            '<i class="fas fa-plus me-1"></i> Add' :
            '<i class="fas fa-edit me-1"></i> Update';

        if (action === 'editPullOut' && row) {
            $('#process_fee').val(row.process_fee);
            $('#ticket').val(row.ticket);
            $('#profit').val(row.profit_share);
            $('#pull_out').val(row.pull_out);
            $('#pull_out_capital').val(row.pull_out_capital);
            $('#total_amt').val(row.total_pull_out);
            $('#date_added').val(row.date_added);
        }

        $('#addPullOut').modal('show');
    }

    $('#pull_out_form').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            handleFormSubmit(currentAction, currentId);
        }
    });

    function handleFormSubmit(action, id) {
        const formData = {
            process_fee: parseFloat($('#process_fee').val()) || 0,
            ticket: parseFloat($('#ticket').val()) || 0,
            profit: parseFloat($('#profit').val()) || 0,
            pull_out: parseFloat($('#pull_out').val()) || 0,
            pull_out_capital: parseFloat($('#pull_out_capital').val()) || 0,
            total_amt: parseFloat($('#total_amt').val()) || 0,
            date_added: $('#date_added').val().trim()
        };

        let url, method;
        switch (action) {
            case 'addPullOut':
                url = '<?php echo base_url("PullOut_cont/add_pull_out"); ?>';
                method = 'POST';
                break;

            case 'editPullOut':
                url = '<?php echo base_url("PullOut_cont/update_pull_out/"); ?>' + id;
                method = 'POST';
                break;

            default:
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Unknown action' });
                return;
        }

        if (formData.process_fee <= 0 && formData.ticket <= 0 && formData.profit <= 0 && formData.pull_out <= 0 && formData.total_amt <= 0) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please enter at least one value greater than 0' });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: action === 'addPullOut' ? 'You are about to add this record.' : 'You are about to update this record.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel',
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Processing...',
                    html: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    dataType: 'json',
                    success: function (res) {
                        Swal.close();
                        Swal.fire({
                            title: 'Success',
                            text: res.message,
                            icon: 'success',
                            timer: 800,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            document.getElementById('pull_out_form').reset();
                            pull_out_table.ajax.reload();
                            $('#addPullOut').modal('hide');
                        });
                    },
                    error: function (err) {
                        Swal.close();
                        console.log(err);
                        Swal.fire({ icon: 'error', title: 'Server Error', text: 'Check console for details' });
                    }
                });
            }
        });
    }

    document.getElementById('closeModalBtn').addEventListener('click', function () {
        document.getElementById('pull_out_form').reset();
    });

    $('#withdrawBtn').on('click', function () {

        Swal.fire({
            title: 'Loading...',
            html: 'Please wait while we fetch data.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo base_url("PullOut_cont/get_total_pullout"); ?>',
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                Swal.close();

                $('#total_pullout').val(parseFloat(res.total_pullout).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

                function updateMaxWithdrawable() {
                    let totalPullout = parseFloat($('#total_pullout').val().replace(/,/g, '')) || 0;

                    $('#max_withdrawable').text(totalPullout.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    $('#withdraw_amount').attr('max', totalPullout);
                }

                updateMaxWithdrawable();

                $('.quick-amount').click(function () {
                    let amount = $(this).data('amount');
                    let maxAmount = parseFloat($('#withdraw_amount').attr('max')) || 0;

                    $(this).addClass('active').siblings().removeClass('active');

                    if (amount > maxAmount) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Insufficient Balance',
                            text: 'Withdrawal amount exceeds available balance!',
                            timer: 2000
                        });
                        $('#withdraw_amount').val(maxAmount);
                    } else {
                        $('#withdraw_amount').val(amount);
                    }
                });

                $('#max_amount').click(function () {
                    let maxAmount = parseFloat($('#withdraw_amount').attr('max')) || 0;
                    $('#withdraw_amount').val(maxAmount);
                });

                $('#withdraw_amount').on('input', function () {
                    let amount = parseFloat($(this).val()) || 0;
                    let maxAmount = parseFloat($(this).attr('max')) || 0;

                    if (amount > maxAmount) {
                        $(this).val(maxAmount);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Amount Adjusted',
                            text: 'Amount cannot exceed available balance!',
                            timer: 1500,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false
                        });
                    }

                    if (amount < 0) {
                        $(this).val(0);
                    }
                });

                $('#process_withdrawal').click(function () {
                    let total_pullout = parseFloat($('#total_pullout').val().replace(/,/g, ''));
                    let amount = $('#withdraw_amount').val();
                    let date = $('#withdrawal_date').val();
                    let method = $('#payment_method').val();
                    let reference = $('#reference_no').val();
                    let notes = $('#withdrawal_notes').val();

                    if (!amount || parseFloat(amount) <= 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Amount',
                            text: 'Please enter a valid withdrawal amount'
                        });
                        return;
                    }

                    if (!date) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Date Required',
                            text: 'Please select a withdrawal date'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Confirm Withdrawal',
                        html: `Are you sure you want to withdraw <strong>₱${parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2 })}</strong>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, withdraw',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                title: 'Processing...',
                                html: 'Please wait',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });

                            console.log({
                                amount: amount,
                                date: date,
                                total_pullout: total_pullout,
                                notes: notes
                            });

                            $.ajax({
                                url: '<?php echo site_url('PullOut_cont/add_withdrawal'); ?>',
                                type: 'POST',
                                data: {
                                    amount: amount,
                                    date: date,
                                    total_pullout: total_pullout,
                                    notes: notes
                                },
                                dataType: 'json',
                                success: function (res) {
                                    Swal.close();
                                    Swal.fire({
                                        title: 'Success',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 800,
                                        timerProgressBar: true,
                                        showConfirmButton: false
                                    }).then(() => {
                                        pull_out_table.ajax.reload();
                                        $('#withdrawPullout').modal('hide');
                                    });
                                },
                                error: function (err) {
                                    Swal.close();
                                    console.log(err);
                                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Check console for details' });
                                }
                            });
                        }
                    });
                });

                $('#withdrawPullout').on('hidden.bs.modal', function () {
                    $('#withdraw_amount').val('');
                    $('#withdrawal_date').val('<?php echo date('Y-m-d'); ?>');
                    $('#payment_method').val('');
                    $('#reference_no').val('');
                    $('#withdrawal_notes').val('');
                    $('#reference_field').hide();
                });

                $('#withdrawPullout').modal('show');
            },
            error: function (err) {
                Swal.close();
                console.log(err);
                Swal.fire({ icon: 'error', title: 'Server Error', text: 'Check console for details' });
            }
        });


    });

    // View withdrawal history
    $(document).on('click', '#withdrawHistoryBtn', function () {
        Swal.fire({
            title: 'Loading...',
            html: 'Please wait while we fetch data.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        $.ajax({
            url: '<?= base_url() ?>PullOut_cont/get_withdrawal_history',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                Swal.close();

                if (response.status === 'success') {
                    $('#footerTotal').text('₱ ' + (response.total || '0.00'));

                    let tbody = $('#withdrawalHistoryTable tbody');
                    tbody.empty();

                    if (response.data.length > 0) {
                        let currentPage = 1;
                        const rowsPerPage = 5;
                        const totalRows = response.data.length;
                        const totalPages = Math.ceil(totalRows / rowsPerPage);

                        function displayTablePage(page) {
                            tbody.empty();
                            const start = (page - 1) * rowsPerPage;
                            const end = Math.min(start + rowsPerPage, totalRows);

                            for (let i = start; i < end; i++) {
                                const item = response.data[i];
                                let date = new Date(item.date_added);
                                let formattedDate = date.toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric',
                                });

                                let row = `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${formattedDate}</td>
                                        <td class="fw-bold text-info">₱ ${parseFloat(item.withdraw_amt).toLocaleString('en-US', { minimumFractionDigits: 2 })}</td>
                                        <td>${item.note || '<span class="text-muted">—</span>'}</td>
                                    </tr>
                                `;
                                tbody.append(row);
                            }

                            $('#pageInfo').text(`Showing ${start + 1} to ${end} of ${totalRows} entries`);
                            $('#prevPage').prop('disabled', page === 1);
                            $('#nextPage').prop('disabled', page === totalPages);
                            $('#currentPage').text(page);
                            $('#totalPages').text(totalPages);

                            // Update page selector
                            let pageSelector = $('#pageSelector');
                            pageSelector.empty();
                            for (let i = 1; i <= totalPages; i++) {
                                pageSelector.append(`<option value="${i}" ${i === page ? 'selected' : ''}>Page ${i}</option>`);
                            }
                        }

                        displayTablePage(1);

                        $('.pagination-container').show();

                        $('#prevPage').off('click').on('click', function () {
                            if (currentPage > 1) {
                                currentPage--;
                                displayTablePage(currentPage);
                            }
                        });

                        $('#nextPage').off('click').on('click', function () {
                            if (currentPage < totalPages) {
                                currentPage++;
                                displayTablePage(currentPage);
                            }
                        });

                        $('#pageSelector').off('change').on('change', function () {
                            currentPage = parseInt($(this).val());
                            displayTablePage(currentPage);
                        });

                        $('#firstPage').off('click').on('click', function () {
                            currentPage = 1;
                            displayTablePage(currentPage);
                        });

                        $('#lastPage').off('click').on('click', function () {
                            currentPage = totalPages;
                            displayTablePage(currentPage);
                        });

                        let totalAmount = response.data.reduce((sum, item) => sum + parseFloat(item.withdraw_amt), 0);
                        $('#footerTotal').text('₱ ' + totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 }));

                    } else {
                        tbody.append('<tr><td colspan="4" class="text-center py-5"><i class="fas fa-inbox fa-3x text-muted mb-3"></i><br><span class="text-muted">No withdrawal history found</span></td></tr>');
                        $('#footerTotal').text('₱0.00');
                        $('.pagination-container').hide();
                    }

                    $('#withdrawHistoryModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to load withdrawal history'
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while loading data'
                });
            }
        });
    });


</script>