<style>
    .total-box {
        background: linear-gradient(135deg, var(--light-blue), #ffffff);
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid var(--light-blue);
        min-height: 58px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 165px;
    }

    .total-label {
        font-size: 11px;
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
</style>
<section id="content">
    <main>
        <div class="table-data mb-5">
            <div class="order">
                <div class="row">
                    <div class="col-2">
                        <button class="btn btn-outline-primary" onclick="openModal('addPullOut')">
                            <i class="fas fa-list me-1"></i> Add New
                        </button>
                    </div>

                    <div id="customTotalsContainer" style="margin-bottom:10px; display:flex; gap:10px;">
                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-receipt me-1"></i> Total Processing Fee
                            </div>
                            <div class="total-value" id="totalFee">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-purchase-tag me-1"></i> Total Ticket
                            </div>
                            <div class="total-value" id="totalTicket">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-line-chart me-1"></i> Total Sharing Profit
                            </div>
                            <div class="total-value" id="totalProfit">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-bar-chart me-1"></i> Total Pull Out 2%
                            </div>
                            <div class="total-value" id="totalPullOut">₱0.00</div>
                        </div>

                        <div class="total-box">
                            <div class="total-label">
                                <i class="bx bx-money me-1"></i> Total Amount
                            </div>
                            <div class="total-value" id="totalAmount">₱0.00</div>
                        </div>

                    </div>

                    <table id="pull_out_table" class="table table-hover mb-0" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%; vertical-align: middle; text-align:center;">NO. #</th>
                                <th style="width: 10%; vertical-align: middle;">DATE</th>
                                <th style="width: 12%; vertical-align: middle;">PROCESSING FEE</th>
                                <th style="width: 12%; vertical-align: middle;">TICKET AMT</th>
                                <th style="width: 12%; vertical-align: middle;">PULL OUT <br>SHARING PROFIT</th>
                                <th style="width: 12%; vertical-align: middle;">PULL OUT 2%</th>
                                <th style="width: 12%; vertical-align: middle;">TOTAL AMT <br>PULL OUT</th>
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
            <div class="modal-dialog" style="max-width:600px; margin-top: 10px;">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">Pull Out Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <form id="client_form">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-4 position-relative">
                                        <label class="form-label">Processing Fee</label>
                                        <input type="number" class="form-control" placeholder="Enter Processing Fee"
                                            id="process_fee" name="process_fee" autocomplete="off" maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label class="form-label">Ticket</label>
                                        <input type="number" class="form-control" placeholder="Enter Ticket" id="ticket"
                                            name="ticket" autocomplete="off" maxlength="11">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pull Out Sharing Profit</label>
                                        <input type="number" class="form-control" placeholder="Enter Sharing Profit"
                                            id="profit" name="profit">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <label class="form-label">Pull Out 2%</label>
                                        <input type="number" class="form-control" placeholder="Enter Pull Out"
                                            id="pull_out" name="pull_out">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Total Amount Pull Out</label>
                                        <input type="number" class="form-control" id="total_amt" name="total_amt"
                                            readonly>
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label class="form-label">Date Pull Out</label>
                                        <input type="date" class="form-control" id="date_added" name="date_added"
                                            value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" onclick="handleFormSubmit(currentAction, currentId)"
                                        id="submitBtn" name="submit" class="btn btn-outline-primary">Add</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"
                                        id="closeModalBtn">Close</button>
                                </div>
                            </div>
                        </div>
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
            "<'d-flex justify-content-between mt-2'<'dataTables_info'i><'dataTables_paginate'p>>",

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
                        <button class="btn btn-sm btn-outline-success me-1" onclick='openModal("editPullOut", ${JSON.stringify(row)})'>
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
                justifyContent: 'flex-start',
                flexGrow: 1
            });

            $('.dataTables_filter').appendTo($topBar).addClass('ms-3 pt-3 mb-0');
        }
    });

    function deleteBtn(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete expense permanently!",
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
                    url: "<?php echo base_url('PullOut_cont/delete_id'); ?>",
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: res.message,
                            icon: 'success',
                            timer: 800,
                            showConfirmButton: false
                        }).then(() => {
                            pull_out_table.ajax.reload();
                        });
                    },
                    error: function (err) {
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

        let total = process_fee + ticket + profit + pull_out;

        $('#total_amt').val(total.toFixed(2));
    }

    $('#process_fee, #ticket, #profit, #pull_out').on('input', calculateTotal);

    function openModal(action, row) {

        console.log(action);
        console.log(row);

        currentAction = action;

        if (row) {
            currentId = row.id;
        }
        console.log(currentId);

        const submitBtn = document.getElementById('submitBtn');

        submitBtn.textContent = action.startsWith('add') ? 'Add' : 'Update';

        if (action === 'editPullOut' && row) {
            $('#process_fee').val(row.process_fee);
            $('#ticket').val(row.ticket);
            $('#profit').val(row.profit_share);
            $('#pull_out').val(row.pull_out);
            $('#total_amt').val(row.total_pull_out);
            $('#date_added').val(row.date_added);
        }

        $('#addPullOut').modal('show');
    }

    $('#client_form').on('keypress', function (e) {
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
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire({
                            title: 'Success',
                            text: res.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            pull_out_table.ajax.reload();
                            $('#addPullOut').modal('hide');
                        });
                    },
                    error: function (err) {
                        console.log(err);
                        Swal.fire({ icon: 'error', title: 'Server Error', text: 'Check console for details' });
                    }
                });
            }
        });
    }

    document.getElementById('closeModalBtn').addEventListener('click', function () {
        document.getElementById('client_form').reset();
    });

</script>