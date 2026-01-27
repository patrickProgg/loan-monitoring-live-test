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


</style>

<section id="content">
    <main>
        <!-- PAGE TITLE -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Monitoring</h4>
                </div>
            </div>
        </div>

        <!-- ADD BUTTON -->
        <div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLoaner">
                <i class="fas fa-user-plus me-1"></i> Add New
            </button>
        </div>

        <div class="table-data mt-3 mb-5">
            <div class="order">
                <table id="client_table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:30px">ID #</th>
                            <th>FULLNAME</th>
                            <th>ADDRESS</th>
                            <th>CONTACT NO.</th>
                            <th style="width:200px">TRANSACTION COUNT</th>
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
            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <form id="client_form">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-12 position-relative">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Fullname" id="full_name" name="full_name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-12 position-relative">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" id="address" name="address">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Contact #</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Contact #" id="contact_no_1" name="contact_no_1" autocomplete="off"  maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Alt Contact #</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Contact #" id="contact_no_2" name="contact_no_2" autocomplete="off"  maxlength="11">
                                    </div>
                                    
                                    <div class="col-md-4 position-relative">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date_added" name="date_added" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-3">
                                        <label for="position" class="form-label">Amount</label>
                                        <input type="number" class="form-control" id="capital_amt" name="capital_amt">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Interest %</label>
                                        <input type="text" class="form-control" id="interest" name="interest" value="15">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Added Amount</label>
                                        <input type="number" class="form-control" id="added_amt" name="added_amt">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="department" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="total_amt" name="total_amt" readonly>
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
            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
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
                                        <input type="text" class="form-control"
                                            placeholder="Enter Fullname" id="edit_full_name" name="edit_full_name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-12 position-relative">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" id="edit_address" name="edit_address">
                                    </div>
                                </div>

                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Contact #</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Contact #" id="edit_contact_no_1" name="edit_contact_no_1" autocomplete="off"  maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Alt Contact #</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Contact #" id="edit_contact_no_2" name="edit_contact_no_2" autocomplete="off"  maxlength="11">
                                    </div>
                                    
                                    <div class="col-md-4 position-relative">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="edit_start_date" name="edit_start_date" value="<?= date('Y-m-d') ?>">
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

        <div class="modal fade" id="viewLoaner" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog" style="max-width:800px;  margin-top: 50px;">
                <div class="modal-content">

                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Monitoring</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <div>
                                        <label class="form-label">Name : 
                                            <span id="header_name" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">Address : 
                                            <span id="header_address" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
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
                                </div>

                                <div class="col-md-3">
                                    <div>
                                        <label class="form-label">
                                            Capital Amt : ₱ <span id="header_capital_amt" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Interest : % <span id="header_interest" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Added Amt : ₱ <span id="header_added_amt" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Status : <span id="header_status" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div>
                                        <label class="form-label">
                                            Total Amt : ₱ <span id="header_total_amt" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Running Bal : ₱ <span id="header_running_balance" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Date Completed : <span id="header_date_completed" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <select id="header_date_arr" class="form-select form-select-sm" style="cursor:pointer"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-data">
                        <div class="order pt-0 px-3" style="max-height: 400px; overflow-y: auto;">
                            <table id="payment_table" class="table table-hover table-bordered mb-0">
                                <thead class="bg-light sticky-top">
                                    <!-- sticky-top -->
                                    <tr>
                                        <th class="text-center" style="width:40%">DAY</th>
                                        <th class="text-center" style="width:30%">PAYMENT</th>
                                        <th class="text-center" style="width:30%">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <div class="fw-bold text-end text-black" style="width:410px">
                            TOTAL PAYMENT: ₱ <span id="total_payment"></span>
                        </div>

                        <div>
                            <button type="button" id="addNewLoan" class="btn btn-primary me-2" onclick="openAddNewLoanModal()">
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

        <!-- Overdue Modal -->
        <div class="modal fade" id="overdueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                <input id="new_capital_amt" type="number" class="form-control" />
                                <input id="new_type" type="hidden"/>
                            </div>
                            <div class="col-4">
                                <label>Interest (%)</label>
                                <input id="new_interest" type="number" class="form-control" value="15"/>
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

        <div class="modal fade" id="addLoanSameClient" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                <input id="new_type" type="hidden"/>
                            </div>
                            <div class="col-4">
                                <label>Interest (%)</label>
                                <input id="add_interest" type="number" class="form-control" value="15"/>
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


    </main>
</section>

<script>
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
            },
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            { data: 'id' },
            { data: 'full_name' },
            { data: 'address' },
            { data: 'contact_no' },
            { data: 'loan_count' },
            { data: 'date_added' },
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

    $('#full_name, #address, #edit_full_name, #edit_address').on('input', function() {
        let value = $(this).val().toLowerCase();
        let formatted = value.replace(/\b\w/g, function(char) {
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

    function openEditModal(id, fullname, address, contact_1, contact_2, date_added){
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

    function openViewModal(id, fullname, address){
        $('#viewLoaner').modal('show');

        $('#header_id').val(id);
        $('#header_name').text(fullname);
        $('#header_address').text(address);

        $.ajax({
            url: "<?php echo base_url('Monitoring_cont/get_start_due_date'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id },
            success: function (response) {
                $('#header_date_arr').empty();

                const firstStatus = response[0][0].status;

                $.each(response[0], function(index, item) {
                    let parts = item.date_to_pay.split(" - ");

                    let start = new Date(parts[0]);
                    let due   = new Date(parts[1]);

                    let startMonth = start.toLocaleDateString('en-US', { month: 'short' });
                    let dueMonth   = due.toLocaleDateString('en-US', { month: 'short' });

                    let startDay   = start.getDate();
                    let dueDay     = due.getDate();

                    let startYear  = start.getFullYear();
                    let dueYear    = due.getFullYear();

                    let formattedDate = '';

                    if (startYear === dueYear) {
                        formattedDate = `${startMonth} ${startDay} - ${dueMonth} ${dueDay}, ${startYear}`;
                    } else {
                        formattedDate = `${startMonth} ${startDay}, ${startYear} - ${dueMonth} ${dueDay}, ${dueYear}`;
                    }

                    $('#header_date_arr').append(
                        `<option value="${item.id}" data-first_status="${firstStatus}">
                            ${formattedDate}
                        </option>`
                    );

                });
                $('#header_date_arr').val($('#header_date_arr option:first').val()).trigger('change');
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });

        $('#header_date_arr').on('change', function() {
            let loanId = $(this).val();
            let firstStatus = $('#header_date_arr option:selected').data('first_status');

            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/get_loan_details'); ?>",
                type: "POST",
                dataType: "json",
                data: { id: loanId },
                success: function(response) {

                    const loan = response[0];

                    const format = d => new Date(d).toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    $('#header_loan_date').text(format(loan.start_date));
                    $('#header_due_date').text(format(loan.due_date));
                    $('#header_capital_amt').text(loan.capital_amt);
                    $('#header_interest').text(loan.interest);
                    $('#header_added_amt').text(loan.added_amt);
                    $('#header_total_amt').text(loan.total_amt);
                    $('#header_date_completed').text(loan.complete_date);

                    let paymentMap = {};

                    response.forEach(item => {
                        if (item.payment_for) {
                            paymentMap[item.payment_for] = item.amt;
                        }
                    });

                    updateTotals(response, loanId);

                    const start = new Date(loan.start_date);

                    let due = new Date(loan.due_date);
                    let dueDateOnly = due.toISOString().split('T')[0];

                    let today = new Date("2026-05-22");
                    let todayDateOnly = today.toISOString().split('T')[0];

                    const status   = loan.status;
                    const complete_date   = new Date(loan.complete_date);

                    if(status === "completed" || status === "overdue" && loan.amt != null){
                        due   = complete_date;
                    }

                    if(firstStatus != status || firstStatus === "ongoing" && todayDateOnly < dueDateOnly){
                        $('#addNewLoan').hide();
                    } else if(firstStatus && status === "completed"){
                        $('#addNewLoan').show();
                    }

                    if (firstStatus === "ongoing" && todayDateOnly > dueDateOnly) {
                        console.log('OVERDUE');
                        $('#new_type').val("overdue");
                    } 
                    // else {
                    //     console.log('complete');
                    //     $('#new_type').val("complete");
                    // }

                    start.setDate(start.getDate() + 1);

                    let tableBody = '';
                    let current = new Date(start);

                    if (status === "overdue") {
                        Object.keys(paymentMap).forEach(dateStr => {
                            let paymentAmt = paymentMap[dateStr];

                            tableBody += `
                                <tr>
                                    <td class="text-center">${new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                                    <td class="text-center">
                                        <input type="text"
                                            class="form-control form-control-sm payment-input w-50 mx-auto text-success"
                                            value="${paymentAmt}"
                                            readonly />
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit-btn"> <i class="fas fa-edit"></i> Edit</button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        while (current <= due) {
                            let dateStr = current.toISOString().split('T')[0];
                            let paymentAmt = paymentMap[dateStr] || '';

                            tableBody += `
                                <tr>
                                    <td class="text-center">${current.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                                    <td class="text-center">
                                        <input type="text"
                                            class="form-control form-control-sm payment-input w-50 mx-auto ${paymentAmt ? 'text-success' : ''}"
                                            value="${paymentAmt}"
                                            ${paymentAmt ? 'readonly' : ''} />
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit-btn"> <i class="fas fa-edit"></i> Edit</button>
                                    </td>
                                </tr>
                            `;

                            current.setDate(current.getDate() + 1);
                        }
                    }

                    $('#payment_table tbody').html(tableBody);
                }

            });
        });

        $(document).on('keypress', '.payment-input', function (e) {
            if (e.which === 13) {
                e.preventDefault();

                let input   = $(this);
                let payment = input.val().trim();
                let id      = $('#header_date_arr').val();

                let row  = input.closest('tr');
                let textDate = row.find('td:first').text().trim();
                let parsed = new Date(textDate + ' UTC');

                let yyyy = parsed.getFullYear();
                let mm   = String(parsed.getMonth() + 1).padStart(2, '0');
                let dd   = String(parsed.getDate()).padStart(2, '0');

                let date = `${yyyy}-${mm}-${dd}`;

                if (!payment || isNaN(payment)|| payment === "0") {
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
                        document.addEventListener('keydown', function(e) {
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
                            loan_id: id,
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

                                $('#header_date_arr').trigger('change');
                            }
                        }
                    });
                });
            }
        });

        function updateTotals(response, loanId) {
            
            const lastPaymentFor = response[response.length - 1].payment_for;

            let totalPayment = 0;

            response.forEach(item => {
                if (item.payment_for) {
                    totalPayment += parseFloat(item.amt);
                }
            });

            $('#total_payment').text(totalPayment.toFixed(2));
            
            const loanTotal = parseFloat(response[0].total_amt);
            const running_bal = loanTotal - totalPayment;
            const status = response[0].status;

            const due_date = response[0].due_date;
            const due_date_obj = new Date(due_date);
            const today = new Date("2026-05-22");

            const over_due = today - due_date_obj;

            const daysOverdue = Math.floor(over_due / (1000 * 60 * 60 * 24));

            let statusText = "";
            let statusClass = "";

            if (status === 'completed') {
                statusText = "Completed";
                statusClass = "text-success";
            } else if (status === 'ongoing') {
                statusText = "Ongoing";
                statusClass = "text-primary";
            } else if (status === 'overdue') {
                statusText = "Overdue";
                statusClass = "text-danger";
            }

            $('#header_status')
                .text(statusText)
                .removeClass("text-success text-primary text-danger")
                .addClass(statusClass);

            $('#header_running_balance').text(running_bal.toFixed(2));

            if (running_bal === 0 && status !== "completed") {
                autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor,  "complete");
            } else if (running_bal !== 0 && status === "completed") {
                autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, "ongoing");
            } else if (running_bal !== 0 && daysOverdue > 0 && status === "ongoing"){
                autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, "overdue");
            }
        }

        $(document).on('click', '.edit-btn', function() {
            let row = $(this).closest('tr');
            let input = row.find('.payment-input');

            input.prop('readonly', false);     
            input.removeClass('text-success'); 
            input.focus();                     
        });
    }

    function autoCompleteLoan(loanId, running_bal, due_date, lastPaymentFor, action) {

        const completeDate = lastPaymentFor;

        if (action === "overdue") {
            openOverdueModal(loanId, running_bal, due_date, action, completeDate);
        } else {
            sendAjax();
        }

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
                        $('#header_date_arr').trigger('change');
                        const modalEl = document.getElementById('overdueModal');
                        if (modalEl) {
                            const modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        }
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

            console.log($('#new_type').val())

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

        $('#modalContinueBtn').off('click').on('click', function() {
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

        $('#addLoanBtn').off('click').on('click', function() {
            const cl_id = $('#header_id').val();
            const capital_amt = $('#add_capital_amt').val();
            const interest = $('#add_interest').val();
            const added_amt = $('#add_added_amt').val();
            const total_amt = $('#add_total_amt').val();
            const start_date = $('#add_start_date').val();
            const fullname = $('#header_name').val();
            const address = $('#header_address').val();

            $.ajax({
                url: "<?php echo base_url('Monitoring_cont/add_new_loan_same_client'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    cl_id : cl_id,
                    capital_amt : capital_amt,
                    interest : interest,
                    added_amt : added_amt,
                    total_amt : total_amt,
                    start_date : start_date
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