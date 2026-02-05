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
</style>
<section id="content">
    <main>
        <div class="table-data mb-5">
            <div class="order">
                <div class="row">

                    <div class="btn-tab-container mb-4 text-center">
                        <button class="btn btn-outline-primary btn-tab active" data-bs-target="#client1">Client</button>
                        <button class="btn btn-outline-primary btn-tab" data-bs-target="#client2">Pull Out</button>
                        <button class="btn btn-outline-primary btn-tab" data-bs-target="#pullout">Expenses</button>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="client1">
                            <table id="client_table" class="table table-hover" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width:100px; text-align:center">ACC #</th>
                                        <th>FULL NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CONTACT NO.</th>
                                        <th style="width:30px">COUNT</th>
                                        <th>TOTAL LOAN</th>
                                        <th style="width:110px">DATE</th>
                                        <th style="width:150px; text-align:center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="client2">

                            <table id="pull_out_table" class="table table-hover mb-0" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 5%; vertical-align: middle; text-align:center;">NO. #</th>
                                        <th style="width: 10%; vertical-align: middle;">DATE</th>
                                        <th style="width: 12%; vertical-align: middle;">PROCESSING FEE</th>
                                        <th style="width: 12%; vertical-align: middle;">TICKET AMT</th>
                                        <th style="width: 12%; vertical-align: middle;">PULL OUT <br>SHARING PROFIT</th>
                                        <th style="width: 12%; vertical-align: middle;">PULL OUT 2%</th>
                                        <th style="width: 12%; vertical-align: middle;">PULL OUT CAPITAL</th>
                                        <th style="width: 12%; vertical-align: middle;">TOTAL AMT <br>PULL OUT</th>
                                        <th style="width: 20%; vertical-align: middle; text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="pullout">
                            <table id="expenses_table" class="table table-hover" style="width:100%">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 10%; text-align:center">NO. #</th>
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
                $.ajax({
                    url: "<?php echo base_url('Monitoring_cont/recover_id'); ?>",
                    type: 'POST',
                    data: {
                        id: id,
                        type: type
                    },
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire({
                            title: 'Recovered!',
                            text: res.message,
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
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
                        console.log(err);
                        Swal.fire('Error', 'Server error. Check console.', 'error');
                    }
                });
            }
        });
    }
</script>