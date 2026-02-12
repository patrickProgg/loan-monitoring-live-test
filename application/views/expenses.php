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
        width: 138px;
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

    .customTotals {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        /* left align by default */
    }
</style>
<section id="content">
    <main>
        <div class="table-data">
            <div class="order pt-2" style="background-color:transparent">
                <div class="row">
                    <div class="col-2 d-flex flex-column align-items-start gap-2">
                        <button class="btn btn-primary" onclick="openModal('addExpenses')">
                            <i class="fas fa-wallet me-1"></i> Add New
                        </button>
                    </div>

                    <div id="customTotalsContainer" style="margin-bottom:10px; display:flex; gap:10px;">
                        <div class="total-box">
                            <div class="total-label"><i class="bx bx-wallet me-1"></i>Total Amount</div>
                            <div class="total-value" id="totalAmt">₱0.00</div>
                        </div>
                    </div>

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

        <div class="modal fade" id="addExpenses" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog" style="margin-top:10px">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title">Expenses Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="expenses_form">
                        <div class="modal-body">
                            <div id="expenseRows">
                                <div class="row g-2 expense-row mb-2 align-items-end">
                                    <div class="col-7">
                                        <label>Type</label>
                                        <select class="form-control expense-type">
                                            <option value="">Select type</option>
                                            <option value="gas">Gas</option>
                                            <option value="meal">Meal</option>
                                            <option value="motor_shop">Motor Shop</option>
                                            <option value="ca">Cash Advance</option>
                                            <option value="other">Other</option>
                                        </select>

                                        <input type="text" class="form-control mt-2 other-expense d-none"
                                            placeholder="Enter other type" />
                                    </div>

                                    <div class="col-4">
                                        <label>Amount</label>
                                        <input type="number" class="form-control expense-amount" />
                                    </div>

                                    <div class="col-1">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary add-row-btn mb-1">+</button>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-2 mt-2">
                                <div class="col-4">
                                    <label>Date</label>
                                    <input type="date" class="form-control date-added" value="<?= date('Y-m-d') ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" onclick="handleFormSubmit(currentAction, currentId)" id="submitBtn"
                                name="submit" class="btn btn-outline-primary">Add</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
</section>

<script>
    let currentId = 0;

    var expenses_table = $("#expenses_table").DataTable({
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
            url: '<?php echo site_url('Expenses_cont/get_expenses'); ?>',
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
                    $('#totalAmt').text('₱' + parseFloat(json.total_amt).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
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
                        <button class="btn btn-sm btn-outline-success me-1" onclick='openModal("editExpenses", ${JSON.stringify(row)})'>
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

    // $(document).ready(function () {

    //     $(document).on("click", ".add-row-btn", function () {
    //         const newRow = $(`
    //         <div class="row g-2 expense-row mb-2 align-items-end">
    //             <div class="col-7">
    //                 <input type="text" class="form-control expense-type" placeholder="Type" />
    //             </div>
    //             <div class="col-4">
    //                 <input type="number" class="form-control expense-amount" placeholder="Amount" />
    //             </div>
    //             <div class="col-1">
    //                 <button type="button" class="btn btn-sm btn-danger remove-row-btn mb-1">
    //                     −
    //                 </button>
    //             </div>
    //         </div>
    //     `);

    //         $("#expenseRows").append(newRow);
    //         newRow.find(".expense-type").focus();
    //     });

    //     $(document).on("click", ".remove-row-btn", function () {
    //         $(this).closest(".expense-row").remove();
    //     });


    // });

    $(document).ready(function () {

        $(document).on("click", ".add-row-btn", function () {
            const newRow = $(`
            <div class="row g-2 expense-row mb-2 align-items-end">
                <div class="col-7">
                    <label>Type</label>
                    <select class="form-control expense-type">
                        <option value="">Select type</option>
                        <option value="gas">Gas</option>
                        <option value="meal">Meal</option>
                        <option value="motor_shop">Motor Shop</option>
                        <option value="ca">Cash Advance</option>
                        <option value="other">Other</option>
                    </select>

                    <input type="text"
                        class="form-control mt-2 other-expense d-none"
                        placeholder="Enter other type" />
                </div>

                <div class="col-4">
                    <label>Amount</label>
                    <input type="number" class="form-control expense-amount" placeholder="Amount" />
                </div>

                <div class="col-1">
                    <button type="button"
                        class="btn btn-sm btn-danger remove-row-btn mb-1">−</button>
                </div>
            </div>
        `);

            $("#expenseRows").append(newRow);
            newRow.find(".expense-type").focus();
        });

        $(document).on("click", ".remove-row-btn", function () {
            $(this).closest(".expense-row").remove();
        });

        // Show "Other" input when selected
        $(document).on("change", ".expense-type", function () {
            const $row = $(this).closest(".expense-row");
            const $other = $row.find(".other-expense");

            if ($(this).val() === "other") {
                $other.removeClass("d-none").focus();
            } else {
                $other.addClass("d-none").val("");
            }
        });

    });


    $(document).on('change', '.expense-type', function () {
        const row = $(this).closest('.expense-row');
        const otherInput = row.find('.other-expense');

        if ($(this).val() === 'other') {
            otherInput.removeClass('d-none').prop('required', true);
        } else {
            otherInput.addClass('d-none').prop('required', false).val('');
        }
    });

    function openModal(action, row) {
        currentAction = action;

        if (row) currentId = row.id;

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.textContent = action.startsWith('add') ? 'Add' : 'Update';
        if (action === 'editExpenses' && row) {
            $("#expenseRows").empty();

            const isPreset = ['gas', 'meal', 'motor_shop', 'ca'].includes(row.type);

            const editRow = $(`
                <div class="row g-2 expense-row mb-2 align-items-end">
                    <div class="col-7">
                        <label>Type</label>
                        <select class="form-control expense-type">
                            <option value="">Select type</option>
                            <option value="gas">Gas</option>
                            <option value="meal">Meal</option>
                            <option value="motor_shop">Motor Shop</option>
                            <option value="ca">Cash Advance</option>
                            <option value="other">Other</option>
                        </select>

                        <input type="text"
                            class="form-control mt-2 other-expense d-none"
                            placeholder="Enter other type">
                    </div>

                    <div class="col-4">
                        <label>Amount</label>
                        <input type="number"
                            class="form-control expense-amount"
                            value="${row.amt}">
                    </div>
                </div>
            `);

            $("#expenseRows").append(editRow);

            if (isPreset) {
                editRow.find('.expense-type').val(row.type);
            } else {
                editRow.find('.expense-type').val('other').trigger('change');
                editRow.find('.other-expense').val(row.type);
            }

            $(".add-row-btn").hide();
            $('.date-added').val(row.date_added);
        }


        $('#addExpenses').modal('show');
    };

    $('#expenses_form').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            handleFormSubmit(currentAction, currentId);
        }
    });

    // function handleFormSubmit(action, id = null) {
    //     const expenses = [];
    //     $("#expenseRows .expense-row").each(function () {
    //         const type = $(this).find(".expense-type").val().trim();
    //         const amt = parseFloat($(this).find(".expense-amount").val()) || 0;
    //         if (type !== "" || amt !== 0) expenses.push({ type, amt });
    //     });

    //     const formData = {
    //         date: $('.date-added').val(),
    //         expenses: expenses
    //     };

    //     console.log("Submitting:", formData);

    //     let url, method;
    //     switch (action) {
    //         case 'addExpenses':
    //             url = '<?php echo base_url("Expenses_cont/add_expenses"); ?>';
    //             method = 'POST';
    //             break;
    //         case 'editExpenses':
    //             url = '<?php echo base_url("Expenses_cont/update_expenses/"); ?>' + id;
    //             method = 'POST';
    //             break;
    //     }

    //     if (expenses.length === 0) {
    //         Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fill at least one.' });
    //         return;
    //     }
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: action === 'addExpenses' ? 'You are about to add this record.' : 'You are about to update this record.',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, proceed!',
    //         cancelButtonText: 'Cancel',
    //         allowEnterKey: false
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: url,
    //                 type: method,
    //                 data: formData,
    //                 dataType: 'json',
    //                 success: function (res) {
    //                     Swal.fire({
    //                         title: 'Success',
    //                         text: res.message,
    //                         icon: 'success',
    //                         timer: 500,
    //                         showConfirmButton: false
    //                     }).then(() => {
    //                         expenses_table.ajax.reload();
    //                         $('#addExpenses').modal('hide');
    //                     });
    //                 },
    //                 error: function (err) {
    //                     console.log(err);
    //                     alert('Server error. Check console.');
    //                 }
    //             });
    //         }
    //     });
    // };

    function handleFormSubmit(action, id = null) {
        const expenses = [];

        $("#expenseRows .expense-row").each(function () {
            let type = $(this).find(".expense-type").val();
            const otherType = $(this).find(".other-expense").val().trim();
            const amt = parseFloat($(this).find(".expense-amount").val()) || 0;

            if (type === 'other') {
                type = otherType;
            }

            if (type && amt > 0) {
                expenses.push({ type, amt });
            }
        });

        if (expenses.length === 0) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fill at least one.' });
            return;
        }

        const formData = {
            date: $('.date-added').val(),
            expenses: expenses
        };

        console.log("Submitting:", formData);

        let url = '';
        switch (action) {
            case 'addExpenses':
                url = '<?php echo base_url("Expenses_cont/add_expenses"); ?>';
                break;
            case 'editExpenses':
                url = '<?php echo base_url("Expenses_cont/update_expenses/"); ?>' + id;
                break;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: action === 'addExpenses'
                ? 'You are about to add this record.'
                : 'You are about to update this record.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed!'
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
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (res) {
                        Swal.close();
                        // Loading Swal will be auto-replaced by success/error Swal
                        Swal.fire({
                            title: 'Success',
                            text: res.message,
                            icon: 'success',
                            timer: 800,
                            showConfirmButton: false,
                            timerProgressBar: true
                        }).then(() => {
                            document.getElementById('expenses_form').reset();
                            expenses_table.ajax.reload();
                            $('#addExpenses').modal('hide');
                        });
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
    }


    $(document).ready(function () {

        $('#addExpenses').on('hidden.bs.modal', function () {
            $("#expenseRows").empty();

            const defaultRow = $(`
                <div class="row g-2 expense-row mb-2 align-items-end">
                    <div class="col-7">
                        <label>Type</label>
                        <input type="text" class="form-control expense-type" placeholder="Type" />
                    </div>
                    <div class="col-4">
                        <label>Amount</label>
                        <input type="number" class="form-control expense-amount" placeholder="Amount" />
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-sm btn-outline-primary add-row-btn mb-1">+</button>
                    </div>
                </div>
            `);

            $("#expenseRows").append(defaultRow);

            $('.date-added').val(new Date().toISOString().split('T')[0]);

            $(".add-row-btn").show();

            currentAction = 'addExpenses';
            currentId = 0;
        });

    });

    function deleteBtn(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the expense permanently!",
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
                    url: "<?php echo base_url('Expenses_cont/delete_id'); ?>",
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: res.message,
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                        }).then(() => {
                            expenses_table.ajax.reload();
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