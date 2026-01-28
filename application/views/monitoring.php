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

    .modal-body .form-label {
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

    .modal-body .form-label:hover {
        background: #e0f0ff;
        /* highlight on hover */
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-body .form-label span {
        font-weight: bold;
        color: #333;
    }

    .modal-body .form-label span.currency {
        color: #0d6efd;
        /* blue for amounts */
    }

    .modal-body .form-label span.currency_red {
        color: #fd0d0d;
        /* blue for amounts */
    }

    .modal-body .form-label span.status {
        color: #28a745;
        /* green for active status */
    }

    .modal-body .form-label span.completed {
        color: #6c757d;
        /* gray for completed */
    }
</style>

<section id="content">
    <main>
        <div class="table-data">
            <div class="order">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between p-0 m-0">
                    <h4 class="mb-0 font-size-18">Client</h4>
                </div>
                <div class="row align-items-end mb-3">
                    <div class="col-auto me-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoaner">
                            <i class="fas fa-user-plus me-1"></i> Add New
                        </button>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="datefilter" id="datefilter"
                                placeholder="Filter date" autocomplete="off" />
                            <label for="datefilter">Filter Date</label>
                        </div>
                    </div>
                </div>
                <table id="client_table" class="table table-hover" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th style="width:50px; text-align:center">ID #</th>
                            <th>FULL NAME</th>
                            <th>ADDRESS</th>
                            <th>CONTACT NO.</th>
                            <th style="width:30px">COUNT</th>
                            <th>DATE ADDED</th>
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
                                    <div class="col-md-12 position-relative">
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
                                        <input type="number" class="form-control" id="capital_amt" name="capital_amt">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Interest %</label>
                                        <input type="text" class="form-control" id="interest" name="interest"
                                            value="15">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Added Amount</label>
                                        <input type="number" class="form-control" id="added_amt" name="added_amt">
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
                                        class="btn btn-primary ">Add</button>
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
                                    <div class="col-md-12 position-relative">
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
                                    <button type="button" id="update_client" name="submit"
                                        class="btn btn-primary ">Update</button>
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

                        <!-- <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-bold">Monitoring</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div> -->

                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-3" style="font-size: 14px;">
                                    <div class="col-md-5">
                                        <div class="mb-2">
                                            <label class="form-label">Name :
                                                <span id="header_name" style="font-weight: bold;"></span>
                                            </label>
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
                                                    class="currency"></span>
                                            </label>

                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">
                                                Running Bal : ₱ <span id="header_running_balance"
                                                    style="font-weight: bold;" class="currency_red"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="form-label">
                                                Date Completed : <span id="header_date_completed"
                                                    style="font-weight: bold;" class="completed"></span>
                                            </label>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <!-- <select id="header_date_arr" class="form-select form-select-sm me-2"
                                                style="cursor:pointer; width: 200px; height: 30px">
                                            </select> -->

                                            <div class="dropup" style="width: 167px;">
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

                                            <button class="btn btn-sm btn-success" id="editLoanDetails">
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
                            <div class="order pt-0 px-3" style="max-height: 420px; overflow-y: auto;">
                                <table id="payment_table" class="table pt-0 pb-0 mt-0 mb-0">
                                    <thead class="sticky-top">
                                        <tr>
                                            <th class="text-center" style="width:10%; color:#000;">NO.#</th>
                                            <th class="text-center" style="width:30%; color:#000;">DAY</th>
                                            <th class="text-center" style="width:30%; color:#000;">PAYMENT</th>
                                            <th class="text-center" style="width:30%; color:#000;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-end text-black" style="width:500px">
                                TOTAL PAYMENT: ₱ <span id="total_payment"></span>
                            </div>

                            <div>
                                <button type="button" id="addNewLoan" class="btn btn-primary me-2"
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

        <!-- Overdue Modal -->
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
                        <button type="button" class="btn btn-primary" id="modalContinueBtn">Continue</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Overdue Modal -->

        <!-- ADD LOAN SAME CLIENT -->
        <div class="modal fade" id="addLoanSameClient" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title">Overdue</h5>
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
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            // { data: 'id', class:'text-center'},
            {
                data: null,
                class: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'full_name' },
            { data: 'address' },
            { data: 'contact_no' },
            { data: 'loan_count', class: 'text-center' },
            { data: 'date_added', class: 'text-center' },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-success" onclick="openEditModal('${data}', '${row.full_name}', '${row.address}', '${row.contact_no_1}', '${row.contact_no_2}', '${row.date_added}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-primary" onclick="openViewModal('${data}', '${row.full_name}', '${row.address}')">
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
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Monitoring_cont/add_client'); ?>",
                    data: $('#client_form').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire('Success!', response.message, 'success');
                        $('#addLoaner').modal('hide');
                        client_table.ajax.reload();
                    }
                });
            }
        });
    });

    $('#full_name, #address, #edit_full_name, #edit_address').on('input', function () {
        let value = $(this).val().toLowerCase();
        let formatted = value.replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
        $(this).val(formatted);
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

    function openEditModal(id, fullname, address, contact_1, contact_2, date_added) {
        $('#editLoaner').modal('show');
        $('#edit_full_name').val(fullname);
        $('#edit_address').val(address);
        $('#edit_contact_no_1').val(contact_1);
        $('#edit_contact_no_2').val(contact_2);
        $('#edit_start_date').val(date_added);

        $("#update_client").on('click', function (e) {
            e.preventDefault();

            var name = $("#edit_full_name").val();

            if (!name) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: "Can't leave full name empty" });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to edit this client?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, edit it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Monitoring_cont/update_client'); ?>",
                        data: $('#edit_client_form').serialize() + '&id=' + id,
                        dataType: 'json',
                        success: function (response) {
                            Swal.fire('Success!', response.message, 'success');
                            $('#editLoaner').modal('hide');
                            client_table.ajax.reload();
                        }
                    });
                }
            });
        });
    }

    function openViewModal(id, fullname, address) {
        $('#viewLoaner').modal('show');

        console.log(id);
        console.log(fullname);
        console.log(address);

        $('#header_id').val(id);
        $('#header_name').text(fullname);
        $('#header_address').text(address);

        $.ajax({
            url: "<?php echo base_url('Monitoring_cont/get_start_due_date'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id },
            success: function (response) {
                // Clear existing options
                $('#header_date_arr').empty();

                console.log(response);

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

                    // let today = new Date();
                    let today = new Date("2026-05-22");
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
                                            <button class="btn btn-sm btn-success edit-btn" 
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
                                            <button class="btn btn-sm btn-success edit-btn" 
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

                            console.log(paymentAmt);

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
                                        <button class="btn btn-sm btn-success edit-btn" 
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
            const fullname = $('#header_name').text();
            const address = $('#header_address').text();

            let input = $(this);
            let payment = input.val().trim();
            let loan_id = $('#header_loan_id').val();

            let row = input.closest('tr');
            let textDate = row.find('td:eq(1)').text().trim();
            let parsed = new Date(textDate + ' UTC');

            let yyyy = parsed.getFullYear();
            let mm = String(parsed.getMonth() + 1).padStart(2, '0');
            let dd = String(parsed.getDate()).padStart(2, '0');

            let date = `${yyyy}-${mm}-${dd}`;

            if (!payment || isNaN(payment) || payment === "0") {
                Swal.fire('Invalid', 'Please enter a valid amount', 'warning');
                return;
            }

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
                            openViewModal(cl_id, fullname, address);
                            // $('#header_date_arr').trigger('change');

                        }
                    }
                });
            });
        }
    });

    function updateTotals(response, loanId, totalPayment, firstStatus) {

        console.log(response);

        const lastPaymentFor = response[response.length - 1].payment_for;

        $('#total_payment').text(Number(totalPayment).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

        const loanTotal = parseFloat(response[0].total_amt);
        const running_bal = loanTotal - totalPayment;
        const status = response[0].status;

        console.log(status);

        const due_date = response[0].due_date;
        const due_date_obj = new Date(due_date);
        const today = new Date("2026-05-22");
        // const today = new Date();

        const over_due = today - due_date_obj;

        const daysOverdue = Math.floor(over_due / (1000 * 60 * 60 * 24));

        console.log(daysOverdue);

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
        console.log('first', firstStatus);

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

            btn.removeClass('btn-primary').addClass('btn-danger');
            btn.html('<i class="fas fa-times"></i> Cancel');
        } else {
            input.prop('readonly', true);
            if (input.val()) input.addClass('text-success');

            btn.removeClass('btn-danger').addClass('btn-primary');
            btn.html('<i class="fas fa-edit"></i> Edit');
        }
    });

    function autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, action) {

        const completeDate = lastPaymentFor;

        console.log(action);

        if (action === "overdue") {
            openOverdueModal(loanId, running_bal, due_date, action, completeDate);
        } else {
            sendAjax();
        }

        cl_id = $('#header_id').val();
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
                        openViewModal(cl_id, fullname, address);

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
        let capital = parseFloat($('#header_capital_amt input').val()) || 0;
        let interestRaw = $('#header_interest input').val().replace('%', '');
        let interest = parseFloat(interestRaw) || 0;
        let added = parseFloat($('#header_added_amt input').val()) || 0;

        let total = capital + (capital * (interest / 100)) + added;

        const totalSpan = $('#header_total_amt');
        const totalInput = totalSpan.find('input');
        if (totalInput.length) {
            totalInput.val(total.toFixed(2));
        } else {
            totalSpan.text(total.toFixed(2));
        }
    }

    $('#editLoanDetails').off('click').on('click', function () {
        const btn = $(this);

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

            const numericFields = ['header_capital_amt', 'header_interest', 'header_added_amt', 'header_added_amt'];
            numericFields.forEach(id => {
                const span = document.getElementById(id);
                if (!span.querySelector('input')) {
                    const textNode = document.createTextNode(span.innerText + ' ');
                    span.innerHTML = '';
                    span.appendChild(textNode);

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = span.innerText.trim();
                    input.style.width = '80px';
                    input.classList.add('form-control', 'form-control-sm', 'd-inline');
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
                    data[id] = input.value;
                    span.innerText = input.value;
                } else {
                    data[id] = span.innerText;
                }
            });

            data['header_due_date'] = document.getElementById('header_due_date').innerText;

            data['loan_id'] = $('#header_loan_id').val();

            id = $('#header_id').val();
            full_name = $('#header_name').text();
            address = $('#header_address').text();

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

                    $('#header_date_arr').val($('#header_date_arr option:first').val()).trigger('change');
                    openViewModal(id, full_name, address);
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

    const viewLoanerEl = document.getElementById('viewLoaner');
    const overdueModalEl = document.getElementById('overdueModal');
    const addNewModalEl = document.getElementById('addLoanSameClient');

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



</script>