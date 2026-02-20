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

    /* Form control focus effects */
    .form-control:focus,
    .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    /* Quick amount buttons hover */
    .quick-capital:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    /* Summary display */
    .bg-light {
        background-color: #f8f9fa !important;
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
                            <div class="total-label"><i class="bx bx-wallet me-1"></i>Total Expenses</div>
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
            <div class="modal-dialog" style="max-width:600px; margin-top:10px">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-receipt me-2 text-warning"></i>
                            Expenses Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="expenses_form">
                        <div class="modal-body pb-0">
                            <!-- Expenses Card -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-list-alt me-2 text-warning"></i>
                                        Expense Details
                                    </h6>
                                </div>
                                <div class="card-body px-4">
                                    <div id="expenseRows">
                                        <!-- First expense row -->
                                        <div class="row g-2 expense-row mb-3 align-items-end">
                                            <div class="col-7">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-tag me-1"></i> EXPENSE TYPE
                                                </label>
                                                <select class="form-select  expense-type">
                                                    <option value="">Select type</option>
                                                    <option value="gas">⛽ Gas</option>
                                                    <option value="meal">🍽️ Meal</option>
                                                    <option value="motor_shop">🔧 Motor Shop</option>
                                                    <option value="ca">💰 Cash Advance</option>
                                                    <option value="other">📌 Other</option>
                                                </select>

                                                <input type="text"
                                                    class="form-control form-control-lg mt-3 other-expense d-none"
                                                    placeholder="Enter other expense type" />
                                            </div>

                                            <div class="col-4">
                                                <label class="form-label fw-bold text-muted small mb-2">
                                                    <i class="fas fa-coins me-1"></i> AMOUNT
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                                                    <input type="number"
                                                        class="form-control form-control-lg expense-amount"
                                                        placeholder="0.00" min="0" step="0.01" />
                                                </div>
                                            </div>

                                            <div class="col-1">
                                                <button type="button" class="btn btn-primary rounded-circle add-row-btn"
                                                    style="width: 38px; height: 38px;" title="Add another expense">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date and Additional Info -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small mb-2">
                                                <i class="fas fa-calendar-alt me-1"></i> EXPENSE DATE
                                            </label>
                                            <input type="date" class="form-control form-control-lg date-added"
                                                value="<?= date('Y-m-d') ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" onclick="handleFormSubmit(currentAction, currentId)" id="submitBtn"
                                name="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Expenses
                            </button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
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
            "<'d-flex justify-content-between mt-0 pt-0'<'dataTables_info pt-0'i><'dataTables_paginate pt-0'p>>",

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
                        <button class="btn btn-sm btn-success me-1" onclick='openModal("editExpenses", ${JSON.stringify(row)})'>
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
        // Initialize total display
        updateExpenseSummary();

        // Add new expense row
        $(document).on("click", ".add-row-btn", function () {
            const newRow = $(`
            <div class="row g-2 expense-row mb-3 align-items-end">
                <div class="col-7">
                    <label class="form-label fw-bold text-muted small mb-2">
                        <i class="fas fa-tag me-1"></i> EXPENSE TYPE
                    </label>
                    <select class="form-select  expense-type">
                        <option value="">Select type</option>
                        <option value="gas">⛽ Gas</option>
                        <option value="meal">🍽️ Meal</option>
                        <option value="motor_shop">🔧 Motor Shop</option>
                        <option value="ca">💰 Cash Advance</option>
                        <option value="other">📌 Other</option>
                    </select>

                    <input type="text"
                        class="form-control form-control-lg mt-3 other-expense d-none"
                        placeholder="Enter other expense type" />
                </div>

                <div class="col-4">
                    <label class="form-label fw-bold text-muted small mb-2">
                        <i class="fas fa-coins me-1"></i> AMOUNT
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                        <input type="number" class="form-control form-control-lg expense-amount" 
                            placeholder="0.00" min="0" step="0.01" />
                    </div>
                </div>

               <div class="col-1">
                    <button type="button"
                        class="btn btn-danger rounded-circle remove-row-btn" 
                        style="width: 38px; height: 38px;"
                        title="Remove expense">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);

            $("#expenseRows").append(newRow);

            // Add animation
            newRow.hide().slideDown(300);
            newRow.find(".expense-type").focus();

            // Update summary
            updateExpenseSummary();
        });

        // Remove expense row with animation
        $(document).on("click", ".remove-row-btn", function () {
            const row = $(this).closest(".expense-row");

            // Check if there are multiple rows
            if ($(".expense-row").length > 1) {
                row.slideUp(300, function () {
                    $(this).remove();
                    updateExpenseSummary();
                });
            } else {
                row.find('.expense-type').val('');
                row.find('.expense-amount').val('');
                row.find('.other-expense').addClass('d-none').val('');
                updateExpenseSummary();

                row.css('background-color', '#fff3cd');
                setTimeout(() => {
                    row.css('background-color', '');
                }, 300);
            }
        });

        $(document).on("change", ".expense-type", function () {
            const $row = $(this).closest(".expense-row");
            const $other = $row.find(".other-expense");
            const selectedValue = $(this).val();

            if (selectedValue === "other") {
                $other.removeClass("d-none").hide().slideDown(200).focus();
            } else {
                $other.slideUp(200, function () {
                    $(this).addClass("d-none").val("");
                });
            }

            // Log selection (optional)
            console.log('Expense type selected:', selectedValue);
        });

        // Update total when amount changes
        $(document).on("input", ".expense-amount", function () {
            updateExpenseSummary();

            // Highlight the changed field
            $(this).addClass('bg-light');
            setTimeout(() => {
                $(this).removeClass('bg-light');
            }, 200);
        });

        // Function to update expense summary
        function updateExpenseSummary() {
            let total = 0;
            let count = 0;
            let details = [];

            $(".expense-row").each(function (index) {
                let type = $(this).find(".expense-type").val();
                let otherType = $(this).find(".other-expense").val();
                let amount = parseFloat($(this).find(".expense-amount").val()) || 0;

                if (amount > 0) {
                    total += amount;
                    count++;

                    // Get display type
                    let displayType = type;
                    if (type === 'other') {
                        displayType = otherType || 'Other';
                    } else if (type) {
                        // Capitalize and format
                        displayType = type.split('_').map(word =>
                            word.charAt(0).toUpperCase() + word.slice(1)
                        ).join(' ');
                    }

                    if (type && amount > 0) {
                        details.push({
                            type: displayType,
                            amount: amount
                        });
                    }
                }
            });

            // Update display
            if ($("#totalExpensesDisplay").length) {
                $("#totalExpensesDisplay").text('₱' + total.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }

            if ($("#expenseCountDisplay").length) {
                $("#expenseCountDisplay").text(count).toggleClass('text-muted', count === 0);
            }

            // Update button states
            $(".remove-row-btn").prop('disabled', $(".expense-row").length === 1);

            // Store total in data attribute for form submission
            $("#expenses_form").data('total', total);
            $("#expenses_form").data('details', details);

            // Log summary
            console.log('Expense Summary:', { total, count, details });
        }

        // Keyboard shortcuts
        $(document).on('keydown', '.expense-amount', function (e) {
            // Press Enter to add new row
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                $('.add-row-btn').first().click();
            }
        });

        // Quick fill with sample data (for testing)
        $("#quickFillBtn").click(function () {
            const sampleData = [
                { type: 'gas', amount: 500 },
                { type: 'meal', amount: 250 },
                { type: 'motor_shop', amount: 1200 }
            ];

            $(".expense-row").remove();

            sampleData.forEach((item, index) => {
                if (index === 0) {
                    // Use first existing row
                    $(".expense-row").find('.expense-type').val(item.type).trigger('change');
                    $(".expense-row").find('.expense-amount').val(item.amount);
                } else {
                    // Add new rows
                    $('.add-row-btn').click();
                    let newRow = $(".expense-row").last();
                    newRow.find('.expense-type').val(item.type).trigger('change');
                    newRow.find('.expense-amount').val(item.amount);
                }
            });

            updateExpenseSummary();

            Swal.fire({
                icon: 'success',
                title: 'Sample Data Loaded',
                text: 'Sample expense data has been filled',
                timer: 1500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        });

        // Reset validation on input change
        $(document).on('input change', '.expense-type, .expense-amount, .other-expense', function () {
            $(this).removeClass('is-invalid');
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
        submitBtn.innerHTML = action.startsWith('add') ?
            '<i class="fas fa-plus me-1"></i> Add' :
            '<i class="fas fa-edit me-1"></i> Update';
        if (action === 'editExpenses' && row) {
            $("#expenseRows").empty();

            const isPreset = ['gas', 'meal', 'motor_shop', 'ca'].includes(row.type);

            const editRow = $(`
                <div class="row g-3 expense-row mb-3 align-items-end">
                    <div class="col-7">
                        <label class="form-label fw-bold text-muted small mb-2">
                            <i class="fas fa-tag me-1"></i> TYPE
                        </label>
                        <select class="form-select  expense-type">
                            <option value="">Select type</option>
                            <option value="gas">⛽ Gas</option>
                            <option value="meal">🍽️ Meal</option>
                            <option value="motor_shop">🔧 Motor Shop</option>
                            <option value="ca">💰 Cash Advance</option>
                            <option value="other">📌 Other</option>
                        </select>

                        <input type="text"
                            class="form-control form-control-lg mt-3 other-expense d-none"
                            placeholder="Enter other expense type">
                    </div>

                    <div class="col-5">
                        <label class="form-label fw-bold text-muted small mb-2">
                            <i class="fas fa-coins me-1"></i> AMOUNT
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 fw-bold">₱</span>
                            <input type="number"
                                class="form-control form-control-lg expense-amount"
                                value="${row.amt}"
                                min="0"
                                step="0.01"
                                placeholder="0.00">
                        </div>
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
            $('.date-added').val(row.date_added || new Date().toISOString().split('T')[0]);

            // Update summary if function exists
            if (typeof updateExpenseSummary === 'function') {
                updateExpenseSummary();
            }
        }

        $('#addExpenses').modal('show');
    };

    $('#expenses_form').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            handleFormSubmit(currentAction, currentId);
        }
    });

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
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire({
                            title: 'Success',
                            text: res.message,
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                        }).then(() => {
                            document.getElementById('expenses_form').reset();
                            expenses_table.ajax.reload();
                            $('#addExpenses').modal('hide');
                        });
                    }
                });
            }
        });
    }


    $(document).ready(function () {
        $('#addExpenses').on('hidden.bs.modal', function () {
            // Reset all form inputs
            $('#expenses_form')[0].reset();

            // Reset date to today
            $('.date-added').val(new Date().toISOString().split('T')[0]);
        });
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