<style>
    .modal-dimmed {
        filter: brightness(0.4);
        pointer-events: none;
        transition: filter 0.2s ease;
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

    #bulk_payment_table th,
    #bulk_payment_table td {
        white-space: nowrap;
        font-size: 0.9rem;
    }

    #bulk_payment_table th {
        background-color: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    #bulk_payment_table tfoot td {
        background-color: #f8f9fa;
        font-weight: bold;
    }
</style>

<section id="content">
    <main>
        <div class="table-data">
            <div class="order pt-2" style="background-color:transparent">
                <div class="row align-items-end mb-3">
                    <div class="col-auto me-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoaner">
                            <i class="fas fa-user-plus me-1"></i> Add New
                        </button>
                        <button class="btn btn-success" id="generate_daily">
                            <i class="fas fa-download me-1"></i> Daily Report
                        </button>
                        <button class="btn btn-secondary" id="generate_weekly">
                            <i class="fas fa-download me-1"></i> Weekly Report
                        </button>
                        <button class="btn btn-warning" id="generate_monthly">
                            <i class="fas fa-download me-1"></i> Monthly Report
                        </button>
                        <button class="btn btn-info" id="bulk_payment">
                            <i class="fas fa-credit-card me-1"></i> Bulk Payment
                        </button>

                        <input type="date"
                            style="width: 140px; display: inline-block; height: 34px; background-color: white; color: #444242; border-radius: 6px; border:1px solid var(--bs-secondary)"
                            class="form-control" id="selected_date" name="selected_date" value="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="datefilter" id="datefilter"
                                placeholder="Filter date" autocomplete="off" />
                            <label for="datefilter">Filter Date</label>
                        </div>
                    </div> -->
                </div>
                <table id="client_table" class="table table-hover" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th style="width:100px; text-align:center">ACC NO</th>
                            <th>FULL NAME</th>
                            <th>ADDRESS</th>
                            <th style="width:220px">CONTACT NO</th>
                            <th style="width:30px">COUNT</th>
                            <th style="width:100px">TOTAL LOAN</th>
                            <th style="width:110px">DATE ADDED</th>
                            <th style="width:150px; text-align:center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div class="modal fade" id="addLoaner" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:600px; margin-top: 10px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Client Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <form id="client_form">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-3 position-relative">
                                        <label for="acc_no" class="form-label">Acc No.</label>
                                        <input type="text" class="form-control" placeholder="Enter Acc No." id="acc_no"
                                            name="acc_no" autocomplete="off">
                                    </div>
                                    <div class="col-md-9 position-relative">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Fullname"
                                            id="full_name" name="full_name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-12 position-relative">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" id="address"
                                            name="address">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Contact #</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact #"
                                            id="contact_no_1" name="contact_no_1" autocomplete="off" maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Alt Contact #</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact #"
                                            id="contact_no_2" name="contact_no_2" autocomplete="off" maxlength="11">
                                    </div>

                                    <div class="col-md-4 position-relative">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date_added" name="date_added"
                                            value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-3">
                                        <label for="position" class="form-label">Amount</label>
                                        <input type="number" class="form-control" id="capital_amt" name="capital_amt"
                                            placeholder="Enter Amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Interest %</label>
                                        <input type="text" class="form-control" id="interest" name="interest"
                                            value="15">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Added Amount</label>
                                        <input type="number" class="form-control" id="added_amt" name="added_amt"
                                            placeholder="Enter Added Amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="total_amt" name="total_amt"
                                            readonly>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="add_client" name="submit"
                                        class="btn btn-outline-primary">Add</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"
                                        id="closeModalBtn">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ADD MODAL -->

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editLoaner" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:600px;  margin-top: 10px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <form id="edit_client_form">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-3 position-relative">
                                        <label for="edit_acc_no" class="form-label">Acc No.</label>
                                        <input type="text" class="form-control" placeholder="Enter Acc No."
                                            id="edit_acc_no" name="edit_acc_no" autocomplete="off">
                                    </div>
                                    <div class="col-md-9 position-relative">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Fullname"
                                            id="edit_full_name" name="edit_full_name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-12 position-relative">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address"
                                            id="edit_address" name="edit_address">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Contact #</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact #"
                                            id="edit_contact_no_1" name="edit_contact_no_1" autocomplete="off"
                                            maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Alt Contact #</label>
                                        <input type="text" class="form-control" placeholder="Enter Contact #"
                                            id="edit_contact_no_2" name="edit_contact_no_2" autocomplete="off"
                                            maxlength="11">
                                    </div>

                                    <div class="col-md-4 position-relative">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="edit_start_date"
                                            name="edit_start_date" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="deleteBtn"
                                        class="btn btn-outline-danger me-2">Delete</button>
                                    <button type="button" id="update_client" name="submit"
                                        class="btn btn-outline-primary ">Update</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"
                                        id="closeModalBtn">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- EDIT MODAL -->

        <!-- VIEW MODAL -->
        <div class="modal fade" id="viewLoaner" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:1200px; margin-top: 10px;">
                <div class="table-data">
                    <div class="modal-content">
                        <div class="modal-body pb-0">
                            <div class="container">
                                <div class="row g-3" style="font-size: 14px;">
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-3">
                                                <label class="form-label">No :
                                                    <span id="header_acc_no" style="font-weight: bold;"></span>
                                                </label>
                                            </div>

                                            <div class="col-9">
                                                <label class="form-label">Full Name:
                                                    <span id="header_name" style="font-weight: bold;"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Address :
                                                <span id="header_address" style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Loan Date :
                                                <span id="header_loan_date" style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="form-label">Due Date :
                                                <span id="header_due_date" style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <input type="hidden" id="header_id">
                                        <input type="hidden" id="header_loan_id">
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Capital Amt : ₱ <span id="header_capital_amt"
                                                    style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Interest : % <span id="header_interest"
                                                    style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Added Amt : ₱ <span id="header_added_amt"
                                                    style="font-weight: bold;"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                Status : <span id="header_status" style="font-weight: bold;"
                                                    class="status"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Total Amt : ₱ <span id="header_total_amt" style="font-weight: bold;"
                                                    class="text-primary"></span>
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Running Bal : ₱ <span id="header_running_balance"
                                                    style="font-weight: bold;" class="text-danger"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                Date Closed : <span id="header_date_completed"
                                                    style="font-weight: bold;" class="text-secondary"></span>
                                            </label>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <!-- <select id="header_date_arr" class="form-select form-select-sm me-2"
                                                style="cursor:pointer; width: 200px; height: 30px">
                                            </select> -->

                                            <div class="dropdown" style="width: 167px;">
                                                <button
                                                    class="btn btn-sm btn-outline-secondary dropdown-toggle w-100 text-start"
                                                    type="button" id="dateDropdownBtn" data-bs-toggle="dropdown"
                                                    aria-expanded="false" style="height: 30px;">
                                                    Select Date Range
                                                </button>
                                                <ul class="dropdown-menu" id="header_date_arr"
                                                    style="max-height: 200px; overflow-y: auto; z-index: 9999;">
                                                    <!-- Options will be appended here -->
                                                </ul>
                                            </div>

                                            <button class="btn btn-sm btn-outline-success" id="editLoanDetails">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" id="cancelEdit" style="display:none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-data">
                            <div class="order pt-0 pb-0" style="max-height: 400px; overflow-y: auto; color:">
                                <table id="payment_table" class="table pt-0 pb-0 mt-0 mb-0 table-bordered">
                                    <thead class="sticky-top">
                                        <tr>
                                            <th class="text-center" style="width:10%; color:var(--dark);">NO.#</th>
                                            <th class="text-center" style="width:30%; color:var(--dark);">DAY</th>
                                            <th class="text-center" style="width:30%; color:var(--dark);">PAYMENT</th>
                                            <th class="text-center" style="width:30%; color:var(--dark);">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div class="text-end" style="width:610px">
                                TOTAL PAYMENT : ₱ <span class="text-primary" id="total_payment"
                                    style="font-weight: bold; "></span>
                            </div>

                            <div>
                                <button type="button" id="addNewLoan" class="btn btn-outline-primary me-1"
                                    onclick="openAddNewLoanModal()">
                                    Add New
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- VIEW MODAL -->

        <!-- OVERDUE -->
        <div class="modal fade" id="overdueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog" style="margin-top:10px">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title">Overdue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-4">
                                <label>Capital Amt</label>
                                <input id="new_capital_amt" type="number" class="form-control" />
                                <input id="new_type" type="hidden" />
                            </div>
                            <div class="col-4">
                                <label>Interest (%)</label>
                                <input id="new_interest" type="number" class="form-control" value="15" />
                            </div>
                            <div class="col-4">
                                <label>Added Amt</label>
                                <input id="new_added_amt" type="number" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>Total Amt</label>
                                <input id="new_total_amt" type="number" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>New Start Date</label>
                                <input id="new_start_date" type="date" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" id="modalContinueBtn">Continue</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- OVERDUE -->

        <!-- ADD LOAN SAME CLIENT -->
        <div class="modal fade" id="addLoanSameClient" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog" style="margin-top:10px">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title">Loan Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-4">
                                <label>Capital Amt</label>
                                <input id="add_capital_amt" type="number" class="form-control" />
                                <input id="new_type" type="hidden" />
                            </div>
                            <div class="col-4">
                                <label>Interest (%)</label>
                                <input id="add_interest" type="number" class="form-control" value="15" />
                            </div>
                            <div class="col-4">
                                <label>Added Amt</label>
                                <input id="add_added_amt" type="number" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>Total Amt</label>
                                <input id="add_total_amt" type="number" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label>New Start Date</label>
                                <input id="add_start_date" type="date" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="addLoanBtn">Continue</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD LOAN SAME CLIENT -->

        <!-- BULK PAYMENT -->
        <div class="modal fade" id="bulk_payment_modal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="width:600px; margin-top: 10px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Bulk Payment For - <span id="bulk_date"
                                style="font-weight: bold;"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="table-responsive" style="max-height: 580px; overflow-y: auto">
                            <table id="bulk_payment_table" class="table table-sm">
                                <thead>
                                    <tr>
                                        <!-- Headers will be dynamically generated -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be dynamically generated -->
                                </tbody>
                                <tfoot>
                                    <!-- Footer row for totals will be dynamically generated -->
                                </tfoot>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="d-flex justify-content-end">
                                <button type="button" id="save_bulk_payments" name="submit"
                                    class="btn btn-outline-success">Save</button>
                                <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"
                                    id="closeModalBtn">Close</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- BULK PAYMENT -->

    </main>
</section>

<script>

    let startDate = '';
    let endDate = '';

    $('#datefilter').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#datefilter').on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('YYYY/MM/DD');
        endDate = picker.endDate.format('YYYY/MM/DD');

        $(this).val(startDate + ' - ' + endDate);

        client_table.ajax.reload();
    });

    $('#datefilter').on('cancel.daterangepicker', function () {
        startDate = '';
        endDate = '';

        $(this).val('');

        client_table.ajax.reload();
    });

    var client_table = $("#client_table").DataTable({
        columnDefs: [{ targets: '_all', orderable: true }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '<?php echo site_url('Monitoring_cont/get_client'); ?>',
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.startDate = startDate;
                d.endDate = endDate;
            },
            xhrFields: {
                withCredentials: true
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            // {
            //     data: null,
            //     class: 'text-center',
            //     render: function (data, type, row, meta) {
            //         return meta.row + meta.settings._iDisplayStart + 1;
            //     }
            // },
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
                        <button class="btn btn-sm btn-outline-success me-1" onclick="openEditModal('${data}', '${row.acc_no}', '${row.full_name}', '${row.address}', '${row.contact_no_1}', '${row.contact_no_2}', '${row.date_added}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="openViewModal('${data}', '${row.full_name}', '${row.address}', '${row.acc_no}')">
                            <i class="fas fa-eye"></i> View
                        </button>
                    `;
                }
            }

        ]
    });

    $("#add_client").on('click', function (e) {
        e.preventDefault();

        var name = $("#full_name").val();
        var amt = $("#capital_amt").val();
        var interest = $("#interest").val();

        if (!name || !amt || !interest) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'All fields are required' });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to add this client?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                // 🔥 SHOW LOADING SWAL
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Monitoring_cont/add_client'); ?>",
                    data: $('#client_form').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        if (response.status === "success") {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            document.getElementById('client_form').reset();
                            $('#addLoaner').modal('hide');
                            client_table.ajax.reload();
                        } else if (response.status === "exist") {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 800,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            return;
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong: ' + error,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    $('#client_form').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#add_client').trigger('click');
        }
    });

    function calculateTotal() {
        let capital = parseFloat($('#capital_amt').val()) || 0;
        let interestRaw = $('#interest').val().replace('%', '');
        let interest = parseFloat(interestRaw) || 0;
        let added = parseFloat($('#added_amt').val()) || 0;

        let total = (capital * (interest / 100)) + added + capital;

        $('#total_amt').val(total.toFixed(2));
    }

    $('#capital_amt, #interest, #added_amt').on('input', calculateTotal);

    function openEditModal(id, acc_no, fullname, address, contact_1, contact_2, date_added) {
        $('#editLoaner').modal('show');
        $('#edit_acc_no').val(acc_no);
        $('#edit_full_name').val(fullname);
        $('#edit_address').val(address);
        $('#edit_contact_no_1').val(contact_1);
        $('#edit_contact_no_2').val(contact_2);
        $('#edit_start_date').val(date_added);

        $('#edit_client_form').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#update_client').trigger('click');
            }
        });

        $("#update_client").on('click', function (e) {
            e.preventDefault();

            var name = $("#edit_full_name").val();

            if (!name) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: "Can't leave full name empty" });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update this client?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                allowEnterKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Monitoring_cont/update_client'); ?>",
                        data: $('#edit_client_form').serialize() + '&id=' + id,
                        dataType: 'json',
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 500,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            $('#editLoaner').modal('hide');
                            client_table.ajax.reload();
                        }
                    });
                }
            });
        });

        $("#deleteBtn").on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete client permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                allowEnterKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Monitoring_cont/delete_id'); ?>",
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 500,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            $('#editLoaner').modal('hide');
                            client_table.ajax.reload();
                        }
                    });
                }
            });
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
                    $('#header_date_completed').text(
                        loan.complete_date ? format(loan.complete_date) : ''
                    );

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

                    if (status !== "ongoing") {
                        // Only check for no payments when status is not ongoing
                        const paymentKeys = Object.keys(paymentMap);

                        if (paymentKeys.length === 0) {
                            tableBody = '<tr><td colspan="4" class="text-center">No data available</td></tr>';
                        } else if (status === "overdue") {
                            paymentKeys.forEach((dateStr, rowIndex) => {
                                let paymentAmt = parseFloat(paymentMap[dateStr]) || 0;
                                let formattedAmt = paymentAmt !== 0 ? paymentAmt.toLocaleString('en-US') : '';
                                totalPayment += paymentAmt;

                                tableBody += `
                                    <tr>
                                        <td class="text-center">${rowIndex + 1}</td>        
                                        <td class="text-center">${new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                                        <td class="text-center">
                                            <input type="text"
                                                class="form-control form-control-sm payment-input w-50 mx-auto ${paymentAmt ? 'text-success' : ''}"
                                                value="${formattedAmt !== 0 ? formattedAmt : ''}"
                                                ${paymentAmt !== 0 ? 'readonly' : ''} />
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-success edit-btn" 
                                                style="${!paymentAmt ? 'display:none;' : ''}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
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
                                                ${paymentAmt !== 0 ? 'readonly' : ''} />
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-success edit-btn" 
                                                style="${!paymentAmt ? 'display:none;' : ''}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                current.setDate(current.getDate() + 1);
                                rowIndex++;
                            }
                        }
                    } else {
                        // For ongoing loans, generate full schedule even if no payments exist
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
                                            ${paymentAmt !== 0 ? 'readonly' : ''} />
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success edit-btn" 
                                            style="${!paymentAmt ? 'display:none;' : ''}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            `;

                            current.setDate(current.getDate() + 1);
                            rowIndex++;
                        }
                    }

                    updateTotals(response, loanId, totalPayment, firstStatus);

                    if (firstStatus === "ongoing" && todayDateOnly > dueDateOnly) {
                        $('#new_type').val("overdue");
                    }

                    $('#payment_table tbody').html(tableBody);

                }
            });
        };
    }

    $(document).on('keypress', '.payment-input', function (e) {
        if (e.which === 13) {
            e.preventDefault();

            const cl_id = $('#header_id').val();
            const acc_no = $('#header_acc_no').val();
            const fullname = $('#header_name').text();
            const address = $('#header_address').text();
            const running_bal = Number(
                $('#header_running_balance').text().replace(/,/g, '')
            );


            let input = $(this);
            let payment = input.val().trim();
            let loan_id = $('#header_loan_id').val();
            // console.log(running_bal);
            // console.log(payment);

            // if (payment > running_bal) {
            //     Swal.fire('Invalid', 'Payment must not exceed running balance', 'warning');
            //     return;
            // }

            let correctedRunningBal = running_bal < 0 ? 0 : running_bal;

            console.log('Corrected running balance:', correctedRunningBal);

            if (payment > correctedRunningBal) {
                Swal.fire('Invalid', 'Payment must not exceed running balance', 'warning');
                return;
            }

            let row = input.closest('tr');
            let textDate = row.find('td:eq(1)').text().trim();
            let parsed = new Date(textDate + ' UTC');

            let yyyy = parsed.getFullYear();
            let mm = String(parsed.getMonth() + 1).padStart(2, '0');
            let dd = String(parsed.getDate()).padStart(2, '0');

            let date = `${yyyy}-${mm}-${dd}`;

            // if (!payment || isNaN(payment) || payment === "0") {
            //     Swal.fire('Invalid', 'Please enter a valid amount', 'warning');
            //     return;
            // }

            Swal.fire({
                title: 'Confirm Payment',
                html: `
                        <div class="text-start text-center">
                            <label class="form-label d-block">Payment Date :</label>
                            <input type="date"
                                id="swal_payment_date"
                                class="form-control w-50 mx-auto text-center"
                                value="${date}">
                        </div>

                        <div class="mt-2">
                            Amount: <b>₱ ${payment}</b>
                        </div>
                    `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                didOpen: () => {
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            Swal.clickConfirm();
                        }
                    }, { once: true });
                },

                preConfirm: () => {
                    const selectedDate = document.getElementById('swal_payment_date').value;
                    if (!selectedDate) {
                        Swal.showValidationMessage('Please select a date');
                    }
                    return selectedDate;
                }
            }).then((result) => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "<?php echo base_url('Monitoring_cont/save_payment'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        loan_id: loan_id,
                        payment_for: date,
                        payment_date: result.value,
                        amount: payment
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            input.prop('readonly', true);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 500,
                                timerProgressBar: true,

                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                stopKeydownPropagation: true
                            });
                            openViewModal(cl_id, fullname, address, acc_no);
                            // $('#header_date_arr').trigger('change');

                        }
                    }
                });
            });
        }
    });

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

        // if (firstStatus && status != 'completed') {
        if (firstStatus != "completed") {
            $('#addNewLoan').hide();
        } else {
            $('#addNewLoan').show();
        }

        $('#header_status')
            .text(statusText)
            .removeClass("text-success text-primary text-danger")
            .addClass(statusClass);

        $('#header_running_balance').text(Number(running_bal).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));


        if (running_bal === 0 && status !== "completed") {
            autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, "completed");
        } else if (running_bal !== 0 && status === "completed") {
            autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, "ongoing");
        } else if (running_bal !== 0 && daysOverdue > 0 && status === "ongoing") {
            autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, "overdue");
        }
    }

    $(document).on('click', '.edit-btn', function () {
        let btn = $(this);
        let row = btn.closest('tr');
        let input = row.find('.payment-input');

        if (btn.text().trim() === 'Edit') {
            input.prop('readonly', false);
            input.removeClass('text-success');
            input.focus();

            btn.removeClass('btn-outline-success').addClass('btn-danger');
            btn.html('<i class="fas fa-times"></i> Cancel');
        } else {
            input.prop('readonly', true);
            if (input.val()) input.addClass('text-success');

            btn.removeClass('btn-danger').addClass('btn-outline-success');
            btn.html('<i class="fas fa-edit"></i> Edit');
        }
    });

    function autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, action) {

        const completeDate = lastPaymentFor;

        if (action === "overdue") {
            openOverdueModal(loanId, running_bal, due_date, action, completeDate);
        } else {
            sendAjax();
        }

        cl_id = $('#header_id').val();
        acc_no = $('#header_acc_no').text();
        fullname = $('#header_name').text();
        address = $('#header_address').text();

        function sendAjax(values = {}) {
            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/complete_payment'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    loan_id: loanId,
                    running_bal: values.running_bal ?? $('#new_capital_amt').val() ?? $('#running_bal').val(),
                    interest: values.interest ?? $('#new_interest').val() ?? $('#interest').val(),
                    added_amt: values.added_amt ?? $('#new_added_amt').val() ?? $('#added_amt').val(),
                    total_amt: values.total_amt ?? $('#new_total_amt').val() ?? $('#total_amt').val(),
                    due_date: due_date,
                    new_start_date: $('#new_start_date').val(),
                    action: action,
                    complete_date: completeDate
                },
                success: function (res) {
                    if (res.status === 'success') {

                        if (res.data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Loan Added!',
                                text: 'New loan record has been successfully inserted.',
                                timer: 1000,
                                showConfirmButton: false
                            });
                        }
                        openViewModal(cl_id, fullname, address, acc_no);

                        $('#overdueModal').modal('hide');

                    }
                }
            });
        }

        function openOverdueModal(loanId, running_bal, due_date, action, completeDate) {
            $('#new_capital_amt').val(running_bal);
            $('#new_interest').val('15');
            $('#new_added_amt').val('');
            $('#new_total_amt').val(running_bal.toFixed(2));
            $('#new_start_date').val(due_date);

            function calculateNewTotal() {
                let capital = parseFloat($('#new_capital_amt').val()) || 0;
                let interest = parseFloat($('#new_interest').val()) || 0;
                let added = parseFloat($('#new_added_amt').val()) || 0;

                let total = capital + (capital * (interest / 100)) + added;
                $('#new_total_amt').val(total.toFixed(2));
            }

            $('#new_capital_amt, #new_interest, #new_added_amt').off('input').on('input', calculateNewTotal);

            calculateNewTotal();

            $('#overdueModal').modal('show');
        }

        $('#modalContinueBtn').off('click').on('click', function () {
            sendAjax();
        });
    }


    function openAddNewLoanModal() {
        $('#addLoanSameClient').modal('show');

        function calculateNewTotal() {
            let capital = parseFloat($('#add_capital_amt').val()) || 0;
            let interest = parseFloat($('#add_interest').val()) || 0;
            let added = parseFloat($('#add_added_amt').val()) || 0;

            let total = capital + (capital * (interest / 100)) + added;
            $('#add_total_amt').val(total.toFixed(2));
        }

        $('#add_capital_amt, #add_interest, #add_added_amt').off('input').on('input', calculateNewTotal);

        calculateNewTotal();

        $('#addLoanBtn').off('click').on('click', function () {
            const cl_id = $('#header_id').val();
            const capital_amt = $('#add_capital_amt').val();
            const interest = $('#add_interest').val();
            const added_amt = $('#add_added_amt').val();
            const total_amt = $('#add_total_amt').val();
            const start_date = $('#add_start_date').val();
            const fullname = $('#header_name').text();
            const address = $('#header_address').text();

            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/add_new_loan_same_client'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    cl_id: cl_id,
                    capital_amt: capital_amt,
                    interest: interest,
                    added_amt: added_amt,
                    total_amt: total_amt,
                    start_date: start_date
                },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,

                        });
                        $('#addNewLoan').show();
                        openViewModal(cl_id, fullname, address)
                        $('#addLoanSameClient').modal('hide');
                    }
                }
            });

        });
    }

    function calculateTotalHeader() {
        // Remove commas before parsing
        let capital = parseFloat($('#header_capital_amt input').val().replace(/,/g, '')) || 0;
        let interestRaw = $('#header_interest input').val().replace(/,/g, '').replace('%', '');
        let interest = parseFloat(interestRaw) || 0;
        let added = parseFloat($('#header_added_amt input').val().replace(/,/g, '')) || 0;

        // Calculate total
        let total = capital + (capital * (interest / 100)) + added;

        // Format total with 2 decimals
        let formattedTotal = total.toFixed(2);

        // Update the span or input
        const totalSpan = $('#header_total_amt');
        const totalInput = totalSpan.find('input');
        if (totalInput.length) {
            totalInput.val(formattedTotal);
        } else {
            totalSpan.text(formattedTotal);
        }
    }


    $('#editLoanDetails').off('click').on('click', function () {
        const btn = $(this);

        $('#dateDropdownBtn').prop('disabled', true);

        $('#cancelEdit').show();

        if (!btn.data('original')) {
            btn.data('original', {
                header_capital_amt: $('#header_capital_amt').text(),
                header_interest: $('#header_interest').text(),
                header_added_amt: $('#header_added_amt').text(),
                header_total_amt: $('#header_total_amt').text(),
                header_loan_date: $('#header_loan_date').text(),
                header_due_date: $('#header_due_date').text()
            });
        }

        if (!btn.data('mode') || btn.data('mode') === 'edit') {
            btn.data('mode', 'save');
            btn.html('<i class="fas fa-save"></i> Save');

            const numericFields = ['header_capital_amt', 'header_interest', 'header_added_amt'];
            numericFields.forEach(id => {
                const span = document.getElementById(id);
                if (!span.querySelector('input')) {
                    const currentText = span.innerText.trim();
                    const numericValue = currentText.replace(/,/g, ''); // remove commas

                    const input = document.createElement('input');
                    input.type = 'number';
                    input.value = numericValue;
                    input.style.width = '100px';
                    input.classList.add('form-control', 'form-control-sm', 'd-inline');
                    span.innerHTML = ''; // clear old text
                    span.appendChild(input);

                    $(input).on('input', calculateTotalHeader);
                }
            });

            const loanDateSpan = document.getElementById('header_loan_date');
            const dueDateSpan = document.getElementById('header_due_date');

            if (!loanDateSpan.querySelector('input')) {
                const currentText = loanDateSpan.innerText.trim();

                // Add text node so input is beside text
                const textNode = document.createTextNode(currentText + ' ');
                loanDateSpan.innerHTML = '';
                loanDateSpan.appendChild(textNode);

                const input = document.createElement('input');
                input.type = 'date';
                if (currentText) {
                    const date = new Date(currentText);
                    if (!isNaN(date)) {
                        const yyyy = date.getFullYear();
                        const mm = String(date.getMonth() + 1).padStart(2, '0'); // months are 0-based
                        const dd = String(date.getDate()).padStart(2, '0');
                        input.value = `${yyyy}-${mm}-${dd}`; // set input in YYYY-MM-DD format
                    }

                    // Set due date immediately
                    const dueDate = new Date(date);
                    dueDate.setDate(dueDate.getDate() + 58);
                    const dueY = dueDate.getFullYear();
                    const dueM = String(dueDate.getMonth() + 1).padStart(2, '0');
                    const dueD = String(dueDate.getDate()).padStart(2, '0');
                    dueDateSpan.innerText = `${dueY}-${dueM}-${dueD}`;
                }


                input.style.width = '140px';
                input.classList.add('form-control', 'form-control-sm', 'd-inline');
                loanDateSpan.appendChild(input);

                input.addEventListener('input', function () {
                    const loanDate = new Date(this.value);
                    if (!isNaN(loanDate)) {
                        const dueDate = new Date(loanDate);
                        dueDate.setDate(dueDate.getDate() + 58);
                        dueDateSpan.innerText = dueDate.toISOString().split('T')[0];

                        calculateTotalHeader();
                    }
                });
            }

        } else {
            btn.data('mode', 'edit');
            btn.html('<i class="fas fa-edit"></i> Edit');

            const editableFields = [
                'header_capital_amt',
                'header_interest',
                'header_added_amt',
                'header_total_amt',
                'header_loan_date'
            ];

            let data = {};
            editableFields.forEach(id => {
                const span = document.getElementById(id);
                const input = span.querySelector('input');
                if (input) {
                    // remove commas before sending
                    const numericValue = input.value.replace(/,/g, '');
                    data[id] = numericValue;
                    span.innerText = Number(numericValue).toLocaleString(); // format with commas
                } else {
                    data[id] = span.innerText.replace(/,/g, '');
                }
            });

            data['header_due_date'] = document.getElementById('header_due_date').innerText;
            data['loan_id'] = $('#header_loan_id').val();

            const id = $('#header_id').val();
            const acc_no = $('#header_acc_no').text();
            const full_name = $('#header_name').text();
            const address = $('#header_address').text();

            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/update_loan_data'); ?>",
                type: 'POST',
                data: data,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 500,
                        timerProgressBar: true,
                    });

                    $('#dateDropdownBtn').prop('disabled', false);
                    $('#header_date_arr').val($('#header_date_arr option:first').val()).trigger('change');
                    openViewModal(id, full_name, address, acc_no);
                    $('#cancelEdit').hide();
                },
                error: function (xhr, status, error) {
                    alert('Error saving loan details: ' + error);
                }
            });
        }

        $('#cancelEdit').off('click').on('click', function () {
            const btn = $('#editLoanDetails');
            const original = btn.data('original');

            if (!original) return;

            $('#header_capital_amt').text(original.header_capital_amt);
            $('#header_interest').text(original.header_interest);
            $('#header_added_amt').text(original.header_added_amt);
            $('#header_total_amt').text(original.header_total_amt);
            $('#header_loan_date').text(original.header_loan_date);
            $('#header_due_date').text(original.header_due_date);

            btn.data('mode', 'edit');
            btn.html('<i class="fas fa-edit"></i> Edit');

            btn.removeData('original');
            $('#cancelEdit').hide();
        });
    });

    $(document).on('click', '#generate_daily', function () {
        // const today = new Date();
        // const yyyy = today.getFullYear();
        // const mm = String(today.getMonth() + 1).padStart(2, '0');
        // const dd = String(today.getDate()).padStart(2, '0');
        // const formattedDate = `${yyyy}-${mm}-${dd}`;

        const selectedDate = $('#selected_date').val();

        // Swal.fire({
        //     title: 'Select Date for Report',
        //     // input: 'date',
        //     // inputLabel: 'Date',
        //     // inputValue: formattedDate,
        //     // inputAttributes: {
        //     //     style: 'display: block; margin: 0 auto; text-align: center; width: 200px;'
        //     // },
        //     showCancelButton: true,
        //     confirmButtonText: 'Download',
        //     cancelButtonText: 'Cancel'
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         const selectedDate = result.value;

        if (!selectedDate) {
            Swal.fire('Error', 'Please select a valid date.', 'error');
            return;
        }

        // Swal.fire({
        //     title: 'Generating Excel Report...',
        //     html: 'Please wait while we generate your report.<br><br><div class="spinner-border text-primary" role="status"></div>',
        //     allowOutsideClick: false,
        //     allowEscapeKey: false,
        //     showConfirmButton: false,
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });

        // $.ajax({
        //     url: '<?php echo site_url('Monitoring_cont/get_daily_report'); ?>',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { date: selectedDate },
        //     success: function (response) {
        //         console.log(response);
        //         if (response.status === "warning") {
        //             Swal.fire('Warning!', response.message, 'warning');
        //         } else {
        //             Swal.fire('Saved!', 'Daily report has been saved.', 'success');
        //         }
        //     },
        //     error: function () {
        //         Swal.fire('Error', 'Something went wrong.', 'error');
        //     }
        // });
        // Change your AJAX call
        $.ajax({
            url: '<?php echo site_url('Monitoring_cont/get_daily_report'); ?>',
            type: 'POST',
            data: { date: selectedDate },
            xhrFields: {
                responseType: 'blob' // Handle binary response
            },
            success: function (blob, status, xhr) {
                // Get filename from headers
                var filename = 'Daily_Report_' + selectedDate + '.xlsx';
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }

                // Create download link
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);

                Swal.fire('Success!', 'Report downloaded to your computer.', 'success');
            },
            error: function () {
                Swal.fire('Error', 'Failed to generate report.', 'error');
            }
        });
    });

    $(document).on('click', '#generate_weekly', function () {
        const selectedDate = $('#selected_date').val();

        if (!selectedDate) {
            Swal.fire('Error', 'Please select a valid date.', 'error');
            return;
        }

        console.log(selectedDate);

        // $.ajax({
        //     url: '<?php echo site_url('Monitoring_cont/get_weekly_report'); ?>',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { date: selectedDate },
        //     success: function (response) {
        //         console.log(response);
        //         if (response.status === "warning") {
        //             Swal.fire('Warning!', response.message, 'warning');
        //         } else {
        //             Swal.fire('Saved!', 'Weekly report has been saved.', 'success');
        //         }
        //     },
        //     error: function () {
        //         Swal.fire('Error', 'Something went wrong.', 'error');
        //     }
        // });

        $.ajax({
            url: '<?php echo site_url('Monitoring_cont/get_weekly_report'); ?>',
            type: 'POST',
            data: { date: selectedDate },
            xhrFields: {
                responseType: 'blob' // Handle binary response
            },
            success: function (blob, status, xhr) {
                // Get filename from headers
                var filename = 'Daily_Report_' + selectedDate + '.xlsx';
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }

                // Create download link
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);

                Swal.fire('Success!', 'Report downloaded to your computer.', 'success');
            },
            error: function () {
                Swal.fire('Error', 'Failed to generate report.', 'error');
            }
        });
    });

    $(document).on('click', '#generate_monthly', function () {
        const selectedDate = $('#selected_date').val();

        if (!selectedDate) {
            Swal.fire('Error', 'Please select a valid date.', 'error');
            return;
        }

        console.log(selectedDate);

        // $.ajax({
        //     url: '<?php echo site_url('Monitoring_cont/get_monthly_report'); ?>',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { date: selectedDate },
        //     success: function (response) {
        //         console.log(response);
        //         if (response.status === "warning") {
        //             Swal.fire('Warning!', response.message, 'warning');
        //         } else {
        //             Swal.fire('Saved!', 'Monthly report has been saved.', 'success');
        //         }
        //     },
        //     error: function () {
        //         Swal.fire('Error', 'Something went wrong.', 'error');
        //     }
        // });

        $.ajax({
            url: '<?php echo site_url('Monitoring_cont/get_monthly_report'); ?>',
            type: 'POST',
            data: { date: selectedDate },
            xhrFields: {
                responseType: 'blob' // Handle binary response
            },
            success: function (blob, status, xhr) {
                // Get filename from headers
                var filename = 'Daily_Report_' + selectedDate + '.xlsx';
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }

                // Create download link
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);

                Swal.fire('Success!', 'Report downloaded to your computer.', 'success');
            },
            error: function () {
                Swal.fire('Error', 'Failed to generate report.', 'error');
            }
        });
    });

    let bulkPaymentData = {
        selected_date: null,
        payments: []
    };

    // Update the original bulk payment click handler to store the date
    // $(document).on('click', '#bulk_payment', function () {
    //     const date = $('#selected_date').val();
    //     bulkPaymentData.selected_date = date;

    //     console.log(date);
    //     $('#bulk_date').text(formatDate(date));

    //     $.ajax({
    //         url: '<?php echo site_url('Monitoring_cont/get_bulk_payment'); ?>',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: { date: date },
    //         success: function (response) {
    //             console.log(response);
    //             populateBulkPaymentTable(response);
    //             $('#bulk_payment_modal').modal('show');
    //         },
    //         error: function () {
    //             Swal.fire('Error', 'Something went wrong.', 'error');
    //         }
    //     });
    // });

    // function populateBulkPaymentTable(response) {
    //     const table = $('#bulk_payment_table');
    //     const tbody = table.find('tbody');
    //     const thead = table.find('thead tr');
    //     const tfoot = table.find('tfoot');

    //     // Clear existing content
    //     tbody.empty();
    //     thead.empty();
    //     tfoot.empty();

    //     // Check if we have data
    //     if (!response.date_columns || response.date_columns.length === 0) {
    //         showNoDataMessage(tbody, 2);
    //         return;
    //     }

    //     // Create table headers (with balance column)
    //     createTableHeaders(thead, response.date_columns);

    //     // Create table rows
    //     if (response.data && response.data.length > 0) {
    //         response.data.forEach(client => {
    //             const row = $('<tr></tr>');
    //             const clientId = client.id || client.client_id;
    //             const loanId = client.loan_id;

    //             row.data('client-data', {
    //                 originalBalance: parseFloat(client.running_balance || 0),
    //                 totalPaid: parseFloat(client.total_paid || 0),
    //                 totalLoan: parseFloat(client.total_loan_amount || 0)
    //             });

    //             // Add client name
    //             row.append(`<td>${client.full_name.toLowerCase().replace(/\b\w/g, char => char.toUpperCase())
    //                 }</td>`);

    //             // Add running balance column
    //             const runningBalance = parseFloat(client.running_balance || 0).toFixed(2);
    //             const balanceClass = client.running_balance > 0 ? 'text-danger font-weight-bold' : 'text-success font-weight-bold';
    //             row.append(`<td class="text-center ${balanceClass} running-balance-cell" 
    //                     data-original-balance="${runningBalance}">
    //                     ${runningBalance}
    //                 </td>`);

    //             let rowTotal = 0;

    //             // Add payment amounts for each date
    //             response.date_columns.forEach(date => {
    //                 const amount = client.payments && client.payments[date] ? client.payments[date] : 0;
    //                 const numAmount = parseFloat(amount);
    //                 rowTotal += numAmount;

    //                 // Create cell - input field only if amount is 0
    //                 if (numAmount === 0) {
    //                     // Empty cell - make it editable
    //                     row.append(`
    //                     <td class="text-center editable-cell" data-amount="0">
    //                         <input type="number" 
    //                             class="form-control form-control-sm bulk-payment-input text-center" 
    //                             value="" 
    //                             placeholder="" 
    //                             data-client-id="${clientId}" 
    //                             data-loan-id="${loanId}" 
    //                             data-date="${date}"
    //                             data-original-amount="0"
    //                             step="0.01" 
    //                             min="0" 
    //                             style="width: 60px; height:margin: 0 auto; padding: 2px 5px; 
    //                                     border: none; border-bottom: 1px solid #ccc; 
    //                                     border-radius: 0; background: transparent;">
    //                     </td>
    //                 `);
    //                 } else {
    //                     // Existing amount - show as plain text with data attributes
    //                     const formattedAmount = numAmount.toFixed(2);
    //                     row.append(`
    //                     <td class="text-center text-success font-weight-bold" 
    //                         title="${date} - Amount: ${formattedAmount}"
    //                         data-amount="${numAmount}"
    //                         data-client-id="${clientId}" 
    //                         data-loan-id="${loanId}" 
    //                         data-date="${date}">
    //                         ${formattedAmount}
    //                     </td>
    //                 `);
    //                 }
    //             });

    //             // Add total column
    //             row.append(`<td class="text-center font-weight-bold row-total">${rowTotal.toFixed(2)}</td>`);

    //             tbody.append(row);
    //         });

    //         // Now create the footer for column totals
    //         createFooterTotals(response);

    //         // Initialize all totals
    //         calculateAllTotals();

    //     } else {
    //         showNoDataMessage(tbody, response.date_columns.length + 3); // +3 for name, balance, and total columns
    //     }
    // }

    // // Create headers function (you should already have this)
    // function createTableHeaders(thead, dateColumns) {
    //     thead.append('<th style="width:20%; color:#000; font-size:13px">FULL NAME</th>');

    //     thead.append('<th style="width:10%; color:#000; font-size:13px" class="text-center">RUNNING BAL.</th>');

    //     let previousDate = null;
    //     dateColumns.forEach(date => {
    //         const formattedDate = formatSmartDate(date, previousDate);
    //         previousDate = date;
    //         thead.append(`<th class="text-center" style="color:#000;  font-size:13px" title="${date}">${formattedDate}</th>`);
    //     });

    //     thead.append('<th class="text-center" style="color:#000; width:15%; font-size:13px">TOTAL</th>');
    // }

    // // Add this function to create footer totals
    // function createFooterTotals(response) {
    //     const tfoot = $('#bulk_payment_table tfoot');
    //     tfoot.empty();

    //     if (!response.data || response.data.length === 0) {
    //         return;
    //     }

    //     const footerRow = $('<tr class="font-weight-bold"></tr>');

    //     // Add TOTAL label
    //     footerRow.append('<td>TOTAL</td>');

    //     // Calculate running balance total from response data
    //     let runningBalanceTotal = 0;
    //     let columnTotals = new Array(response.date_columns.length).fill(0);
    //     let grandTotal = 0;

    //     response.data.forEach(client => {
    //         // Add client's running balance
    //         runningBalanceTotal += parseFloat(client.running_balance || 0);

    //         let clientTotal = 0;
    //         response.date_columns.forEach((date, index) => {
    //             const amount = client.payments && client.payments[date] ? client.payments[date] : 0;
    //             columnTotals[index] += parseFloat(amount);
    //             clientTotal += parseFloat(amount);
    //         });
    //         grandTotal += clientTotal;
    //     });

    //     // Add running balance total cell
    //     footerRow.append(`<td class="text-center">${runningBalanceTotal.toFixed(2)}</td>`);

    //     // Add column totals to footer
    //     columnTotals.forEach(total => {
    //         footerRow.append(`<td class="text-center">${total.toFixed(2)}</td>`);
    //     });

    //     // Add grand total
    //     footerRow.append(`<td class="text-center">${grandTotal.toFixed(2)}</td>`);

    //     tfoot.append(footerRow);
    // }

    // // Helper function to calculate all totals
    // function calculateAllTotals() {
    //     const table = $('#bulk_payment_table');
    //     const tbody = table.find('tbody');

    //     let runningBalanceTotal = 0;
    //     let rowTotalsSum = 0;

    //     // Calculate all row totals
    //     tbody.find('tr').each(function () {
    //         const row = $(this);
    //         let rowTotal = 0;

    //         // Get all date cells (skip: name(1), balance(2), total(last))
    //         const dateCells = row.find('td').slice(2, -1);

    //         dateCells.each(function () {
    //             const cell = $(this);
    //             const input = cell.find('.bulk-payment-input');

    //             if (input.length > 0) {
    //                 rowTotal += parseFloat(input.val()) || 0;
    //             } else {
    //                 // Get amount from data attribute or text
    //                 const amount = parseFloat(cell.data('amount')) || parseFloat(cell.text().trim()) || 0;
    //                 rowTotal += amount;
    //             }
    //         });

    //         row.find('.row-total').text(rowTotal.toFixed(2));
    //         rowTotalsSum += rowTotal;

    //         // Calculate running balance for this row
    //         const runningBalanceCell = row.find('.running-balance-cell');
    //         const runningBalance = parseFloat(runningBalanceCell.text().trim()) || 0;
    //         runningBalanceTotal += runningBalance;
    //     });

    //     // Update the running balance total in footer
    //     updateRunningBalanceTotal(runningBalanceTotal);

    //     // Calculate column totals
    //     updateColumnTotals();
    // }

    // // New function to update running balance total
    // function updateRunningBalanceTotal(total) {
    //     const table = $('#bulk_payment_table');
    //     const footerRow = table.find('tfoot tr');

    //     if (footerRow.length > 0) {
    //         // Update the second cell (index 1) which is for running balance total
    //         footerRow.find('td:nth-child(2)').text(total.toFixed(2));
    //     }
    // }

    // function updateColumnTotals() {
    //     const table = $('#bulk_payment_table');
    //     const columns = table.find('thead tr th').length - 3; // Minus name, balance, and total columns

    //     // Calculate running balance total from all rows
    //     let runningBalanceTotal = 0;
    //     table.find('tbody tr').each(function () {
    //         const runningBalanceCell = $(this).find('.running-balance-cell');
    //         const runningBalance = parseFloat(runningBalanceCell.text().trim()) || 0;
    //         runningBalanceTotal += runningBalance;
    //     });

    //     // Update running balance total in footer
    //     table.find('tfoot tr td:nth-child(2)').text(runningBalanceTotal.toFixed(2));

    //     // Update each date column total
    //     for (let i = 0; i < columns; i++) {
    //         let columnTotal = 0;
    //         const cells = table.find(`tbody tr td:nth-child(${i + 3})`); // +3 because: 1=name, 2=balance, 3=first date column

    //         cells.each(function () {
    //             const cell = $(this);
    //             const input = cell.find('.bulk-payment-input');

    //             if (input.length > 0) {
    //                 columnTotal += parseFloat(input.val()) || 0;
    //             } else {
    //                 columnTotal += parseFloat(cell.data('amount')) || parseFloat(cell.text().trim()) || 0;
    //             }
    //         });

    //         table.find(`tfoot tr td:nth-child(${i + 3})`).text(columnTotal.toFixed(2));
    //     }

    //     updateGrandTotal();
    // }

    // function updateGrandTotal() {
    //     const table = $('#bulk_payment_table');
    //     let grandTotal = 0;

    //     table.find('tbody tr .row-total').each(function () {
    //         grandTotal += parseFloat($(this).text()) || 0;
    //     });

    //     table.find('tfoot tr td:last-child').text(grandTotal.toFixed(2));
    // }

    // $(document).on('input', '.bulk-payment-input', function () {
    //     const row = $(this).closest('tr');
    //     const input = $(this);
    //     const cell = input.closest('td');
    //     const clientId = input.data('client-id');
    //     const date = input.data('date');

    //     // Update the data-amount attribute when input changes
    //     const newValue = parseFloat(input.val()) || 0;
    //     const oldValue = parseFloat(cell.data('amount')) || 0;
    //     cell.data('amount', newValue);

    //     // Calculate the change in payment amount
    //     const amountChange = newValue - oldValue;

    //     // Update row total
    //     let rowTotal = 0;
    //     const dateCells = row.find('td').slice(2, -1);

    //     dateCells.each(function () {
    //         const dateCell = $(this);
    //         const dateInput = dateCell.find('.bulk-payment-input');

    //         if (dateInput.length > 0) {
    //             rowTotal += parseFloat(dateInput.val()) || 0;
    //         } else {
    //             rowTotal += parseFloat(dateCell.data('amount')) || parseFloat(dateCell.text().trim()) || 0;
    //         }
    //     });

    //     row.find('.row-total').text(rowTotal.toFixed(2));

    //     // UPDATE RUNNING BALANCE
    //     updateRunningBalance(row, amountChange);

    //     // Update column totals
    //     updateColumnTotals();
    // });

    // function updateRunningBalance(row, amountChange) {
    //     const runningBalanceCell = row.find('.running-balance-cell');
    //     const currentBalance = parseFloat(runningBalanceCell.text().trim()) || 0;

    //     // Calculate new balance (subtract the payment increase)
    //     const newBalance = currentBalance - amountChange;

    //     // Update the display
    //     runningBalanceCell.text(newBalance.toFixed(2));

    //     // Update the color based on balance
    //     if (newBalance > 0) {
    //         runningBalanceCell.removeClass('text-success').addClass('text-danger font-weight-bold');
    //     } else {
    //         runningBalanceCell.removeClass('text-danger').addClass('text-success font-weight-bold');
    //     }

    //     // Update the data attribute
    //     runningBalanceCell.data('current-balance', newBalance);
    // }

    // // Save button click handler
    // $(document).on('click', '#save_bulk_payments', function () {
    //     saveBulkPayments();
    // });

    // function saveBulkPayments() {
    //     const payments = [];
    //     const updatedBalances = [];
    //     const table = $('#bulk_payment_table');

    //     // Collect payments and balances first
    //     table.find('tbody tr').each(function () {
    //         const row = $(this);
    //         const runningBalanceCell = row.find('.running-balance-cell');
    //         const runningBalance = parseFloat(runningBalanceCell.text().trim()) || 0;
    //         const firstInput = row.find('.bulk-payment-input').first();
    //         const clientId = firstInput.data('client-id');
    //         const loanId = firstInput.data('loan-id');

    //         if (clientId) {
    //             updatedBalances.push({
    //                 client_id: clientId,
    //                 loan_id: loanId,
    //                 running_balance: runningBalance
    //             });
    //         }

    //         row.find('.bulk-payment-input').each(function () {
    //             const input = $(this);
    //             const value = parseFloat(input.val()) || 0;

    //             if (value > 0) {
    //                 payments.push({
    //                     client_id: input.data('client-id'),
    //                     loan_id: input.data('loan-id'),
    //                     date: input.data('date'),
    //                     amount: value
    //                 });
    //             }
    //         });
    //     });

    //     console.log(updatedBalances);

    //     if (payments.length === 0) {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'No Payments',
    //             text: 'No payments to save. Please enter some amounts first.'
    //         });
    //         return;
    //     }

    //     // Calculate total amount
    //     const totalAmount = payments.reduce((sum, payment) => sum + payment.amount, 0);
    //     const numberOfPayments = payments.length;
    //     const numberOfClients = new Set(payments.map(p => p.client_id)).size;

    //     // Show confirmation dialog
    //     Swal.fire({
    //         title: 'Confirm Save',
    //         html: `
    //         <div class="text-left">
    //             <p>You are about to save:</p>
    //             <ul>
    //                 <li><strong>${numberOfPayments}</strong> payment(s)</li>
    //                 <li><strong>${numberOfClients}</strong> client(s)</li>
    //                 <li><strong>₱${totalAmount.toFixed(2)}</strong> total amount</li>
    //             </ul>
    //             <p>Are you sure you want to proceed?</p>
    //         </div>
    //     `,
    //         icon: 'question',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, save payments!',
    //         cancelButtonText: 'Cancel'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             proceedWithSave(payments, updatedBalances, totalAmount);
    //         }
    //     });
    // }

    // function proceedWithSave(payments, updatedBalances, totalAmount) {
    //     // Show loading
    //     const saveButton = $('#save_bulk_payments');
    //     const originalText = saveButton.html();
    //     saveButton.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    //     saveButton.prop('disabled', true);

    //     // Prepare data
    //     const data = {
    //         selected_date: bulkPaymentData.selected_date,
    //         payments: payments,
    //         updated_balances: updatedBalances
    //     };

    //     // Send to server
    //     $.ajax({
    //         url: '<?php echo site_url('Monitoring_cont/save_bulk_payments'); ?>',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: JSON.stringify(data),
    //         contentType: 'application/json',
    //         success: function (response) {
    //             console.log('Save response:', response);

    //             if (response.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Saved Successfully!',
    //                     html: `
    //                     <div class="text-left">
    //                         <p>${response.message}</p>
    //                         <ul>
    //                             <li><strong>${response.saved_count || payments.length}</strong> payments saved</li>
    //                             <li><strong>₱${totalAmount.toFixed(2)}</strong> total amount</li>
    //                             ${response.failed_count ? `<li><strong>${response.failed_count}</strong> failed</li>` : ''}
    //                         </ul>
    //                     </div>
    //                 `,
    //                     timer: 1000,
    //                     timerProgressBar: true,
    //                     showConfirmButton: false
    //                 }).then(() => {
    //                     $('#bulk_payment_modal').modal('hide');
    //                     client_table.ajax.reload();

    //                 });
    //             } else {
    //                 Swal.fire('Error', response.message || 'Failed to save payments.', 'error');
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error('Save error:', error);
    //             console.error('Status:', status);
    //             console.error('Response:', xhr.responseText);
    //             Swal.fire('Error', 'Something went wrong while saving payments.', 'error');
    //         },
    //         complete: function () {
    //             // Restore button
    //             saveButton.html(originalText);
    //             saveButton.prop('disabled', false);
    //         }
    //     });
    // }

    $(document).on('click', '#bulk_payment', function () {
        const date = $('#selected_date').val();
        bulkPaymentData.selected_date = date;

        console.log(date);
        $('#bulk_date').text(formatDate(date));

        $.ajax({
            url: '<?php echo site_url('Monitoring_cont/get_bulk_payment'); ?>',
            type: 'POST',
            dataType: 'json',
            data: { date: date },
            success: function (response) {
                console.log(response);
                populateBulkPaymentTable(response, date);
                $('#bulk_payment_modal').modal('show');
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });
    });

    function populateBulkPaymentTable(response, date) {
        const table = $('#bulk_payment_table');
        const tbody = table.find('tbody');
        const thead = table.find('thead tr');

        // Clear existing content
        tbody.empty();
        thead.empty();

        // Create table headers
        thead.append('<th style="width:20%; color:var(--dark); background-color:var(--light-grey); font-size:13px" class="text-center  align-middle">ACC NO</th>');
        thead.append('<th style="width:65%; color:var(--dark); background-color:var(--light-grey); font-size:13px" class="align-middle">FULL NAME</th>');
        thead.append('<th style="width:15%; color:var(--dark); background-color:var(--light-grey); font-size:13px; height:40px" class="text-center align-middle">AMOUNT</th>');

        // Check if we have data
        if (!response.data || response.data.length === 0) {
            tbody.append(`
            <tr>
                <td colspan="3" class="text-center">No clients found for the selected date</td>
            </tr>
        `);
            return;
        }

        // Create table rows
        response.data.forEach(client => {
            const row = $('<tr></tr>');

            // Add account number
            row.append(`<td class="text-center">${client.acc_no || 'N/A'}</td>`);

            // Add client name (proper case)
            const formattedName = client.full_name.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
            row.append(`<td>${formattedName}</td>`);

            // Add BLANK amount column for input
            const hasPayment = client.amt && client.amt > 0;
            const inputValue = hasPayment ? client.amt : '';

            row.append(`
                <td class="text-center">
                    <input ${hasPayment ? 'type="text"' : 'type="number"'} 
                        class="form-control form-control-sm bulk-payment-input text-center ${hasPayment ? 'bg-light text-success font-weight-bold' : ''}"   
                        value="${inputValue}" 
                        data-client-id="${client.client_id}" 
                        data-loan-id="${client.loan_id}" 
                        data-date="${date}"
                        ${hasPayment ? 'readonly' : ''}
                        ${hasPayment ? 'title="Payment already recorded"' : ''}
                        step="0.01" 
                        min="0" 
                        style="width: 100px; margin: 0 auto;">
                </td>
            `);

            tbody.append(row);
        });
    }

    // Helper function for showing no data message
    function showNoDataMessage(tbody, colSpan) {
        const row = $(`<tr><td colspan="${colSpan}" class="text-center">No data found</td></tr>`);
        tbody.append(row);
    }

    $(document).on('click', '#save_bulk_payments', function () {
        const date = bulkPaymentData.selected_date;
        const payments = [];

        // Collect all payment inputs that are NOT readonly
        $('.bulk-payment-input').each(function () {
            const input = $(this);

            // Skip readonly inputs (existing payments)
            if (input.prop('readonly')) {
                return true; // continue to next iteration
            }

            const amount = parseFloat(input.val()) || 0;

            // Only include if amount is greater than 0
            if (amount > 0) {
                payments.push({
                    client_id: input.data('client-id'),
                    loan_id: input.data('loan-id'),
                    payment_date: input.data('date'), // The selected date
                    amount: amount
                });
            }
        });

        if (payments.length === 0) {
            Swal.fire('Warning', 'No payments to save. Please enter amounts.', 'warning');
            return;
        }

        // Calculate total amount
        const totalAmount = payments.reduce((sum, payment) => sum + payment.amount, 0);

        // Show confirmation SweetAlert
        Swal.fire({
            title: 'Confirm Bulk Payment',
            html: `
                <div style="text-align: center;">
                    <p>Are you sure you want to save <strong>${payments.length}</strong> payment(s)?</p>
                    <p><strong>Total Amount:</strong> ₱${totalAmount.toFixed(2)}</p>
                    <p><strong>Payment Date:</strong> ${formatDate(date)}</p>
                    <p>This action cannot be undone.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save payments!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.ajax({
                        url: '<?php echo site_url('Monitoring_cont/save_bulk_payments'); ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            date: date,
                            payments: payments
                        },
                        success: function (response) {
                            resolve(response);
                        },
                        error: function () {
                            Swal.showValidationMessage('Something went wrong while saving.');
                            resolve(false);
                        }
                    });
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value.success) {
                Swal.fire({
                    title: 'Success!',
                    html: `
                        <div style="text-align: center;">
                            <p>${result.value.message}</p>
                            <p><strong>Payments saved:</strong> ${payments.length}</p>
                            <p><strong>Total amount:</strong> ₱${totalAmount.toFixed(2)}</p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#bulk_payment_modal').modal('hide');
                    client_table.ajax.reload();
                });
            } else {
                Swal.fire('Error', result.value.message || 'Failed to save payments', 'error');
            }
        });
    });


    function formatSmartDate(dateString, previousDate = null) {
        const date = new Date(dateString);

        let includeYear = false;
        if (previousDate) {
            const prevDate = new Date(previousDate);
            if (date.getFullYear() !== prevDate.getFullYear()) {
                includeYear = true;
            }
        }

        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = monthNames[date.getMonth()];
        const day = date.getDate();

        if (includeYear) {
            const year = date.getFullYear().toString().substr(-2); // Last 2 digits
            return `${month} ${day} '${year}`;
        }

        return `${month} ${day}`;
    }

    function formatMonthDay(dateString) {
        const date = new Date(dateString);

        // Get month abbreviation
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = monthNames[date.getMonth()];

        // Get day without leading zero
        const day = date.getDate();

        return `${month} ${day}`;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    const viewLoanerEl = document.getElementById('viewLoaner');
    const overdueModalEl = document.getElementById('overdueModal');
    const addNewModalEl = document.getElementById('addLoanSameClient');

    viewLoanerEl.addEventListener('hidden.bs.modal', () => {
        $('#dateDropdownBtn').prop('disabled', false);

        $('#cancelEdit').hide();
        const btn = $('#editLoanDetails');

        btn.data('mode', 'edit');
        btn.prop('disabled', false);
        btn.html('<i class="fas fa-edit"></i> Edit');
    });

    overdueModalEl.addEventListener('show.bs.modal', () => {
        viewLoanerEl.classList.add('modal-dimmed');
        addNewModalEl.classList.add('modal-dimmed');
    });

    overdueModalEl.addEventListener('hidden.bs.modal', () => {
        viewLoanerEl.classList.remove('modal-dimmed');
        addNewModalEl.classList.remove('modal-dimmed');
    });

    addNewModalEl.addEventListener('show.bs.modal', () => {
        viewLoanerEl.classList.add('modal-dimmed');
    });

    addNewModalEl.addEventListener('hidden.bs.modal', () => {
        viewLoanerEl.classList.remove('modal-dimmed');
    });

    // let clickAttempts = 0;

    // document.getElementById('generate_weekly').addEventListener('mouseenter', function (e) {
    //     const button = e.target;
    //     clickAttempts++;

    //     // Make it harder to catch over time
    //     const difficulty = Math.min(1.5, 1 + (clickAttempts * 0.1));

    //     const maxX = window.innerWidth - button.offsetWidth;
    //     const maxY = window.innerHeight - button.offsetHeight;

    //     // Teleport to random position
    //     const randomX = Math.random() * maxX;
    //     const randomY = Math.random() * maxY;

    //     button.style.position = 'fixed';
    //     button.style.left = `${randomX}px`;
    //     button.style.top = `${randomY}px`;
    //     button.style.zIndex = '9999';
    //     button.style.transition = `all ${0.3 / difficulty}s ease-out`;

    //     // Show taunting message
    //     const messages = [
    //         "Can't catch me!",
    //         "Try again!",
    //         "Almost got it!",
    //         "Too slow!",
    //         "Nope!",
    //         "Missed me!"
    //     ];

    //     if (clickAttempts > 3) {
    //         const randomMsg = messages[Math.floor(Math.random() * messages.length)];
    //         button.innerHTML = `<i class="fas fa-running me-1"></i> ${randomMsg}`;

    //         // Make it smaller and faster
    //         button.style.transform = `scale(${1 / difficulty})`;
    //     }
    // });

    // // Reset button after 5 seconds of no interaction
    // let resetTimeout;
    // document.getElementById('generate_weekly').addEventListener('mouseleave', function () {
    //     clearTimeout(resetTimeout);
    //     resetTimeout = setTimeout(() => {
    //         const button = document.getElementById('generate_weekly');
    //         button.innerHTML = `<i class="fas fa-download me-1"></i> Weekly Report`;
    //         button.style.position = '';
    //         button.style.left = '';
    //         button.style.top = '';
    //         button.style.transform = '';
    //         clickAttempts = 0;
    //     }, 5000);
    // });
</script>