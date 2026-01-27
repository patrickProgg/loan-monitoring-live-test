<section id="content">
    <main>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pull Out</h4>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-primary btn-sm" onclick="openModal('addPullOut')">
                <i class="fas fa-file me-1"></i> Add New
            </button>
        </div>

        <div class="table-data mt-3 mb-5">
            <div class="order">
                <table id="pull_out_table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>PROCESSING FEE</th>
                            <th>TICKET</th>
                            <th>PULL OUT SHARING PROFIT</th>
                            <th>PULL OUT 2%</th>
                            <th>TOTAL AMT PULL OUT</th>
                            <th style="width:150px; text-align:center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="addPullOut" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
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
                                        <label for="fullName" class="form-label">Processing Fee</label>
                                        <input type="number" class="form-control"
                                            placeholder="Enter Processing Fee" id="process_fee" name="process_fee" autocomplete="off"  maxlength="11">
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="fullName" class="form-label">Ticket</label>
                                        <input type="number" class="form-control"
                                            placeholder="Enter Ticket" id="ticket" name="ticket" autocomplete="off"  maxlength="11">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="position" class="form-label">Pull Out Sharing Profit</label>
                                        <input type="number" class="form-control" placeholder="Enter Sharing Profit" id="profit" name="profit">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Pull Out 2%</label>
                                        <input type="number" class="form-control" placeholder="Enter Pull Out" id="pull_out" name="pull_out">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Total Amount Pull Out</label>
                                        <input type="number" class="form-control" id="total_amt" name="total_amt" readonly>
                                    </div>
                                    <div class="col-md-4 position-relative">
                                        <label for="date" class="form-label">Date Pull Out</label>
                                        <input type="date" class="form-control" id="date_added" name="date_added" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" onclick="handleFormSubmit(currentAction, currentId)" id="submitBtn" name="submit"
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

    </main>
</section>

<script>

    let currentId = 0;

    var pull_out_table = $("#pull_out_table").DataTable({
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
            }
        },
        columns: [
            { data: 'date_added' },
            { data: 'process_fee' },
            { data: 'ticket' },
            { data: 'profit_share' },
            { data: 'pull_out' },
            { data: 'total_pull_out' },
            {
                data: 'id',
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-success" onclick='openModal("editPullOut", ${JSON.stringify(row)})'>
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    `;
                }
            }

        ]
    });

    $("#add_pull_out").on('click', function (e) {
        e.preventDefault();

        var process_fee = $("#process_fee").val();

        if (!process_fee) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'All fields are required' });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to add this pull out?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('PullOut_cont/add_pull_out'); ?>",
                    data: $('#client_form').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire('Success!', response.message, 'success');
                        $('#addPullOut').modal('hide');
                        pull_out_table.ajax.reload();
                    }
                });
            }
        });
    });

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

    function handleFormSubmit(action, id = null) {

        const formData = {
            process_fee: $('#process_fee').val(),
            ticket: $('#ticket').val(),
            profit: $('#profit').val(),
            pull_out: $('#pull_out').val(),
            total_amt: $('#total_amt').val(),
            date_added: $('#date_added').val()
        };
        
       switch(action) {
            case 'addPullOut':
                url = '<?php echo base_url("PullOut_cont/add_pull_out"); ?>';
                method = 'POST';
                break;

            case 'editPullOut':
                url = '<?php echo base_url("PullOut_cont/update_pull_out/"); ?>' + id;
                method = 'POST';
                break;
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            success: function(res) {
                Swal.fire({ 
                    title: 'Success', 
                    text: res.message, 
                    icon: 'success', 
                    timer: 500, 
                    showConfirmButton: false 
                }).then(() => { 
                    pull_out_table.ajax.reload(); 
                    
                }); 
            },
            error: function(err) {
                console.log(err);
                alert('Server error. Check console.');
            }
        });
        
        $('#addPullOut').modal('hide');
    }
</script>