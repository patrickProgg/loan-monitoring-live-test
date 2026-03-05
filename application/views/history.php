<style>
    .btn-tab-container .btn-tab {
        margin: 0 5px;
        padding: 10px 25px;
        border-radius: 50px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-tab-container .btn-tab:hover {
        background-color: #0d6efd;
        color: white;
        transform: scale(1.05);
    }

    .btn-tab-container .btn-tab.active {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    #payment_table thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 2;
    }

    label {
        font-weight: normal !important;
    }

    #viewLoaner .modal-body .form-label {
        display: flex;
        justify-content: space-between;
        align-items: left;
        padding: 6px 12px;
        border-radius: 8px;
        /* background: linear-gradient(135deg, var(--light-blue), #ffffff); */
        background: #f8f9fa;
        /* subtle background */
        font-weight: 500;
        font-size: 14px;
        /* margin-bottom: 6px; */
        transition: background 0.3s, box-shadow 0.3s;
    }

    #viewLoaner .modal-body .form-label span {
        font-weight: bold;
        color: #333;
    }
</style>
<section id="content">
    <main>
        <div class="table-data mb-5">
            <div class="order pt-2" style="background-color:transparent">
                <div class="row">
                    <div class="btn-tab-container text-center">
                        <button class="btn btn-outline-primary btn-tab active" data-bs-target="#client">Client</button>
                        <button class="btn btn-outline-primary btn-tab" data-bs-target="#pull_out">Pull Out</button>
                        <button class="btn btn-outline-primary btn-tab" data-bs-target="#expenses">Expenses</button>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="client">
                            <table id="client_table" class="table table-hover" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width:100px; text-align:center">ACC NO</th>
                                        <th>FULL NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CONTACT NO</th>
                                        <th style="width:30px">COUNT</th>
                                        <th>TOTAL LOAN</th>
                                        <th style="width:110px">DATE ADDED</th>
                                        <th style="width:150px; text-align:center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="pull_out">

                            <table id="pull_out_table" class="table table-hover mb-0" style="width:100%">
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
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="expenses">
                            <table id="expenses_table" class="table table-hover" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 10%; text-align:center">NO</th>
                                        <th style="width: 20%">DATE ADDED</th>
                                        <th tyle="width: 30%">EXPENSE DESCRIPTION</th>
                                        <th style="width: 20%">AMOUNT</th>
                                        <th style="width:20%; text-align:center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="viewLoaner" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl" style="margin-top: 10px;">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-file-invoice me-2 text-primary"></i>
                            Loan Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-3 pb-0">
                        <div class="container-fluid px-0">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body pb-0 pt-0">

                                    <!-- Client Details - 3 Columns with Icons -->
                                    <div class="row mb-0">
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <div class="text-muted small"><i class="fas fa-hashtag me-1"></i>
                                                    Account Number</div>
                                                <span class="fw-bold fs-6" id="header_acc_no"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <div class="text-muted small"><i class="fas fa-user me-1"></i> Full Name
                                                </div>
                                                <span class="fw-bold fs-6" id="header_name"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <div class="text-muted small"><i class="fas fa-map-marker-alt me-1" "></i> Address</div>
                                                <span class=" fw-bold fs-6" id="header_address"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-content-between align-items-center mb-2 mt-2 pt-2 border-top">
                                            <h5 class="text-dark fw-bold mb-0"><i
                                                    class="fas fa-history me-2 text-primary"></i>Loan History</h5>
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Date Filter Dropdown -->
                                                <div class="dropdown" style="width: 167px;">
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary dropdown-toggle w-100 text-start"
                                                        type="button" id="dateDropdownBtn" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="height: 30px;">
                                                        <i class="fas fa-filter me-1"></i> Select Date Range
                                                    </button>
                                                    <ul class="dropdown-menu" id="header_date_arr"
                                                        style="max-height: 200px; overflow-y: auto; z-index: 9999;">
                                                        <!-- Options will be appended here -->
                                                    </ul>
                                                </div>

                                                <!-- Edit Button -->
                                                <!-- <button class="btn btn-sm btn-success" id="editLoanDetails">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" id="cancelEdit"
                                                    style="display: none;">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </button> -->
                                            </div>
                                        </div>
                                        <hr class="my-0">

                                        <!-- First Row - Dates and Amounts -->
                                        <div class="row mt-3 mb-2">
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <div class="text-muted small"><i
                                                            class="far fa-calendar-alt me-1"></i> Start Date</div>
                                                    <span class="fw-bold" id="header_loan_date"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <div class="text-muted small"><i
                                                            class="far fa-calendar-check me-1"></i> Due Date</div>
                                                    <span class="fw-bold" id="header_due_date"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <div class="text-muted small"><i class="fas fa-coins me-1"></i>
                                                        Amount</div>
                                                    <span class="fw-bold text-primary">₱ <span
                                                            id="header_capital_amt"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <div class="text-muted small"><i
                                                            class="fas fa-plus-circle me-1"></i> Added Amount</div>
                                                    <span class="fw-bold text-info">₱ <span
                                                            id="header_added_amt"></span></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second Row - Financial Details -->
                                        <div class="row mb-2">
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <div class="text-muted small"><i class="fas fa-percent me-1"></i>
                                                        Interest Rate</div>
                                                    <span class="fw-bold"><span id="header_interest">15</span>%</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <div class="text-muted small"><i
                                                            class="fas fa-file-invoice me-1"></i> Total Amount</div>
                                                    <span class="fw-bold text-success">₱ <span
                                                            id="header_total_amt"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <div class="text-muted small"><i class="fas fa-chart-line me-1"></i>
                                                        Running Balance</div>
                                                    <span class="fw-bold text-danger">₱ <span
                                                            id="header_running_balance"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <div class="text-muted small"><i
                                                            class="fas fa-check-circle me-1"></i> Status / <i
                                                            class="far fa-calendar-check me-1"></i> Date Completed</div>
                                                    <span class="fw-bold text-success">
                                                        <span id="header_status">ONGOING</span>
                                                        <span id="header_date_completed"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-3 pb-3">
                            <div class="table-responsive"
                                style="max-height: 365px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                                <table id="payment_table" class="table table-sm table-hover mb-0">
                                    <thead class="table-light sticky-top"
                                        style="background-color: #f8f9fa; height:40px; vertical-align: middle;">
                                        <tr>
                                            <th class="text-center"
                                                style="width:10%; background-color:var(--light-grey); color:var(--dark); font-weight: bold;">
                                                #
                                            </th>
                                            <th class="text-center"
                                                style="width:30%; background-color:var(--light-grey); color:var(--dark); font-weight: bold;">
                                                DATE</th>
                                            <th class="text-center"
                                                style="width:30%; background-color:var(--light-grey); color:var(--dark); font-weight: bold;">
                                                PAYMENT</th>
                                            <th class="text-center"
                                                style="width:30%; background-color:var(--light-grey); color:var(--dark); font-weight: bold;">
                                                ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="paymentTableBody">
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                No payment records found
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center w-100 pt-3">
                                <div style="width: 50px;"></div>

                                <div class="text-center">
                                    <span class="text-muted me-2">Total Payments:</span>
                                    <span class="fw-bold text-primary fs-5">₱ <span
                                            id="total_payment">0.00</span></span>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="header_id">
                        <input type="hidden" id="header_loan_id">
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>

<script>
    const tabs = document.querySelectorAll('.btn-tab');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('show', 'active'));
            tab.classList.add('active');
            const target = document.querySelector(tab.dataset.bsTarget);
            target.classList.add('show', 'active');
        });
    });

    var client_table = $("#client_table").DataTable({
        columnDefs: [{ targets: '_all', orderable: true }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: '<?php echo site_url('Monitoring_cont/get_client'); ?>',
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.history = true;
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            {
                data: 'acc_no',
                class: 'text-center'
            },
            {
                data: 'full_name',
                render: function (data) {
                    if (!data) return '';
                    return data.replace(/\b\w/g, char => char.toUpperCase());
                }
            },
            {
                data: 'address',
                render: function (data) {
                    if (!data) return '';
                    return data.replace(/\b\w/g, char => char.toUpperCase());
                }
            },
            {
                data: 'contact_no',
                render: function (data) {

                    let numbers = data.split('|')
                        .map(n => n.trim())
                        .filter(n => n !== '');

                    return numbers.length > 0 ? numbers.join(' | ') : '';
                }
            },
            { data: 'loan_count', class: 'text-center' },
            {
                data: 'total_loan_amount', class: 'text-end',
                render: function (data, type, row) {
                    return Number(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { data: 'date_added', class: 'text-center' },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-danger" onclick="recoverBtn('${data}','client')">
                            <i class="fas fa-undo"></i> Recover
                        </button>
                         <button class="btn btn-sm btn-primary" onclick="openViewModal('${data}', '${row.full_name}', '${row.address}', '${row.acc_no}')">
                            <i class="fas fa-eye"></i> View
                        </button>
                    `;
                }
            }

        ]
    });

    var pull_out_table = $("#pull_out_table").DataTable({
        columnDefs: [{ targets: '_all', orderable: true }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: '<?php echo site_url('PullOut_cont/get_pull_out'); ?>',
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.history = true;
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
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
                        <button class="btn btn-sm btn-danger" onclick="recoverBtn('${data}','pull_out')">
                            <i class="fas fa-undo"></i> Recover
                        </button>
                    `;
                }
            }
        ]
    });

    var expenses_table = $("#expenses_table").DataTable({
        columnDefs: [{ targets: '_all', orderable: true }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: '<?php echo site_url('Expenses_cont/get_expenses'); ?>',
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.history = true;
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
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
            { data: 'date_added' },
            {
                data: 'type',
                render: function (data) {
                    if (!data) return '';

                    if (data === 'ca') {
                        return 'Cash Advance';
                    } else if (data === 'motor_shop') {
                        return 'Motor Shop';
                    } else if (data === 'gas') {
                        return 'Gas';
                    } else if (data === 'meal') {
                        return 'Meal';
                    } else if (data === 'ca') {
                        return 'Cash Advance';
                    } else {
                        return data.replace(/\b\w/g, char => char.toUpperCase());
                    }
                }
            },
            {
                data: 'amt',
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
                        <button class="btn btn-sm btn-danger" onclick="recoverBtn('${data}','expenses')">
                            <i class="fas fa-undo"></i> Recover
                        </button>
                    `;
                }
            }

        ]
    });

    function recoverBtn(id, type) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will recover data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, recover it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading Swal
                Swal.fire({
                    title: 'Recovering...',
                    html: 'Please wait while data is being recovered.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "<?php echo base_url('Monitoring_cont/recover_id'); ?>",
                    type: 'POST',
                    data: {
                        id: id,
                        type: type
                    },
                    dataType: 'json',
                    success: function (res) {
                        Swal.close(); // Close loading Swal

                        Swal.fire({
                            title: 'Recovered!',
                            text: res.message,
                            icon: 'success',
                            timer: 800,
                            showConfirmButton: false,
                            timerProgressBar: true
                        }).then(() => {
                            if (type === "client") {
                                client_table.ajax.reload();
                            } else if (type === "pull_out") {
                                pull_out_table.ajax.reload();
                            } else {
                                expenses_table.ajax.reload();
                            }
                        });
                    },
                    error: function (err) {
                        Swal.close(); // Close loading Swal
                        console.log(err);
                        Swal.fire('Error', 'Server error. Check console.', 'error');
                    }
                });
            }
        });
    }


    function openViewModal(id, fullname, address, acc_no) {
        $('#viewLoaner').modal('show');

        $('#header_id').val(id);
        $('#header_acc_no').text(acc_no);
        $('#header_name').text(fullname.replace(/\b\w/g, c => c.toUpperCase()));
        $('#header_address').text(address.replace(/\b\w/g, c => c.toUpperCase()));

        $.ajax({
            url: "<?php echo base_url('Monitoring_cont/get_start_due_date'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id },
            success: function (response) {
                // Clear existing options
                $('#header_date_arr').empty();

                if (!response[0] || response[0].length === 0) {
                    $('#dateDropdownBtn').text('No Dates Available');

                    $('#selected_date_id').val('');
                    $('#header_loan_id').val('');

                    $('#payment_table tbody').html('<tr><td colspan="4" class="text-center">No data available</td></tr>');

                    return;
                }

                const firstStatus = response[0][0].status;
                let firstItemId = null;

                $.each(response[0], function (index, item) {
                    let parts = item.date_to_pay.split(" - ");
                    let start = new Date(parts[0]);
                    let due = new Date(parts[1]);

                    let startMonth = start.toLocaleDateString('en-US', { month: 'short' });
                    let dueMonth = due.toLocaleDateString('en-US', { month: 'short' });
                    let startDay = start.getDate();
                    let dueDay = due.getDate();
                    let startYear = start.getFullYear();
                    let dueYear = due.getFullYear();
                    let formattedDate = '';

                    if (startYear === dueYear) {
                        formattedDate = `${startMonth} ${startDay} - ${dueMonth} ${dueDay}, ${startYear}`;
                    } else {
                        formattedDate = `${startMonth} ${startDay}, ${startYear} - ${dueMonth} ${dueDay}, ${dueYear}`;
                    }

                    if (index === 0) {
                        firstItemId = item.id;
                    }

                    $('#header_date_arr').append(
                        `<li>
                            <a class="dropdown-item" href="#" 
                            data-id="${item.id}" 
                            data-first_status="${firstStatus}"
                            data-formatted="${formattedDate}">
                                ${formattedDate}
                            </a>
                        </li>`
                    );
                });

                if (firstItemId) {
                    let firstOption = $('#header_date_arr li:first-child .dropdown-item');
                    $('#dateDropdownBtn').text(firstOption.data('formatted'));
                    $('#selected_date_id').val(firstItemId);
                    $('#header_loan_id').val(firstItemId);

                    triggerLoanDetails(firstItemId, firstStatus);
                }
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });

        // Handle dropdown item selection
        $(document).on('click', '#header_date_arr .dropdown-item', function (e) {
            e.preventDefault();

            let loanId = $(this).data('id');
            let firstStatus = $(this).data('first_status');
            let formattedDate = $(this).data('formatted');

            // Update button text
            $('#dateDropdownBtn').text(formattedDate);

            // Store selected values
            $('#selected_date_id').val(loanId);
            $('#header_loan_id').val(loanId);

            // Trigger loan details load
            triggerLoanDetails(loanId, firstStatus);
        });

        // $('#header_date_arr').off('change').on('change', function () {
        function triggerLoanDetails(loanId, firstStatus) {
            $('#header_loan_id').val(loanId)

            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/get_loan_details'); ?>",
                type: "POST",
                dataType: "json",
                data: { id: loanId },
                success: function (response) {

                    const loan = response[0];

                    const format = d => new Date(d).toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    $('#header_loan_date').text(format(loan.start_date));
                    $('#header_due_date').text(format(loan.due_date));
                    $('#header_capital_amt').text(Number(loan.capital_amt).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $('#header_added_amt').text(Number(loan.added_amt).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $('#header_total_amt').text(Number(loan.total_amt).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $('#header_interest').text(loan.interest);
                    let dateDisplay = loan.complete_date ? format(loan.complete_date) : '';

                    if (dateDisplay) {
                        // If date exists, show dash, date, and checkmark
                        $('#header_date_completed').html(`
                            <span class="mx-1">—</span>
                            ${dateDisplay}
                            <i class="fas fa-check-circle ms-1" style="color: #28a745; font-size: 0.9rem;"></i>
                        `);
                    } else {
                        // If no date, show nothing (empty)
                        $('#header_date_completed').html('');
                    }
                    let paymentMap = {};

                    response.forEach(item => {
                        if (item.payment_for) {
                            paymentMap[item.payment_for] = item.amt;
                        }
                    });

                    const start = new Date(loan.start_date);

                    let due = new Date(loan.due_date);
                    let dueDateOnly = due.toISOString().split('T')[0];

                    let today = new Date();
                    // let today = new Date("2026-05-22");
                    let todayDateOnly = today.toISOString().split('T')[0];

                    const status = loan.status;
                    const complete_date = new Date(loan.complete_date);

                    if (status === "completed" || status === "overdue" && loan.amt != null) {
                        due = complete_date;
                    }

                    start.setDate(start.getDate() + 1);

                    let tableBody = '';
                    let current = new Date(start);
                    let totalPayment = 0;

                    // if (status !== "ongoing") {
                    // Only check for no payments when status is not ongoing
                    const paymentKeys = Object.keys(paymentMap);

                    if (paymentKeys.length === 0) {
                        tableBody = '<tr><td colspan="4" class="text-center">No data available</td></tr>';
                    } else {
                        let rowIndex = 0;
                        while (current <= due) {
                            let dateStr = current.toISOString().split('T')[0];
                            let paymentAmt = parseFloat(paymentMap[dateStr]) || 0;
                            let formattedAmt = paymentAmt !== 0 ? paymentAmt.toLocaleString('en-US') : '';

                            totalPayment += paymentAmt;

                            tableBody += `
                                    <tr>
                                        <td class="text-center">${rowIndex + 1}</td>
                                        <td class="text-center">${current.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                                        <td class="text-center">
                                            <input type="text"
                                                class="form-control form-control-sm payment-input w-50 mx-auto ${paymentAmt ? 'text-success' : ''}"
                                                value="${formattedAmt !== 0 ? formattedAmt : ''}"
                                                readonly />
                                        </td>
                                    </tr>
                                `;

                            current.setDate(current.getDate() + 1);
                            rowIndex++;
                        }
                    }
                    // }

                    updateTotals(response, loanId, totalPayment, firstStatus);

                    if (firstStatus === "ongoing" && todayDateOnly > dueDateOnly) {
                        $('#new_type').val("overdue");
                    }

                    $('#payment_table tbody').html(tableBody);

                }
            });
        };
    }

    function updateTotals(response, loanId, totalPayment, firstStatus) {

        const lastPaymentFor = response[response.length - 1].payment_for;

        $('#total_payment').text(Number(totalPayment).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        const loanTotal = parseFloat(response[0].total_amt);
        const running_bal = loanTotal - totalPayment;
        const status = response[0].status;

        const due_date = response[0].due_date;
        const due_date_obj = new Date(due_date);
        // const today = new Date("2026-04-05");
        const today = new Date();

        const over_due = today - due_date_obj;

        const daysOverdue = Math.floor(over_due / (1000 * 60 * 60 * 24));

        let statusText = "";
        let statusClass = "";

        if (status === 'completed') {
            statusText = "COMPLETED";
            statusClass = "text-success";
        } else if (status === 'ongoing') {
            statusText = "ONGOING";
            statusClass = "text-primary";
        } else if (status === 'overdue') {
            statusText = "OVERDUE";
            statusClass = "text-danger";
        }

        $('#header_status')
            .text(statusText)
            .removeClass("text-success text-primary text-danger")
            .addClass(statusClass);

        $('#header_running_balance').text(Number(running_bal).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

    }

</script>