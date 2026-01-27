<style>
    #content main .head-title .left .breadcrumb {
        display: flex;
        align-items: center;
        grid-gap: 16px;
        padding-left: 0;
    }

    #content main .table-data {
        padding-top: 17px;
    }

    .tab-content {
        visibility: hidden;
        position: absolute;
        height: 0;
        overflow: hidden;
    }

    .tab-content.active {
        visibility: visible;
        position: relative;
        height: auto;
    }

    .tab-link:hover {
        color: var(--bs-dark);
    }

    .nav-tabs-custom {
        display: flex;
        width: 100%;
        list-style: none;
        border: none;
        box-shadow: none;
        background: none;
        margin: 0;
        padding: 0;
        cursor: pointer;
    }

    .nav-tabs-custom li {
        flex: 1;
        text-align: center;
        box-shadow: none;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }

    .nav-tabs-custom a {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 36.53px;
        width: 100%;
        text-decoration: none;
        color: var(--bs-primary);
        /* transition: background 0.2s; */
        transition: background 0.5s;
        border-bottom: 1px solid var(--bs-primary);
    }

    .nav-tabs-custom a.active {
        background: var(--bs-primary);
        color: white;
    }
</style>
<section id="content">
    <main>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <!-- Page title -->
                    <h4 class="mb-sm-0 font-size-18">Releasing</h4>

                    <!-- Date Filter -->
                    <!-- <div class="d-flex align-items-end gap-2 p-0 m-0">
                        <div>
                            <input type="text"
                                class="form-control"
                                name="datefilter"
                                id="datefilter"
                                placeholder="Filter date"
                                autocomplete="off"
                                style="border: none; border-bottom: 1px solid var(--bs-primary); background-color: transparent;" />
                        </div>

                        <button type="button" class="btn btn-primary" id="filterBtn" style="font-size: 0.8rem;">
                            <span class="material-icons" style="font-size: 1rem; line-height: 1;">filter_alt</span>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- <div class="head-title mt-0 mb-2">
            <ul class="breadcrumb nav-tabs-custom row">
                <li>
                    <a class="col-6 tab-link active" style="border-radius: 5px 0 0 5px ;"
                        data-tab="releasing" data-value="releasing">RELEASING</a>
                </li>
                <li>
                    <a class="col-6 tab-link" style="border-radius: 0 5px 5px 0;" data-tab="releasing" data-value="history">HISTORY</a>
                </li>
            </ul>
        </div> -->

        <div class="tab-content active mb-5" id="releasing" role="tabpanel">
            <div class="table-data mt-0 pt-1">
                <div class="order" style="border-top-left-radius: 0 !important;">
                    <table id="releasing-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>DOCUMENT NO</th>
                                <th>CUSTOMER NAME</th>
                                <th>POSTING DATE</th>   
                                <th>STATUS</th>
                                <th>UPLOAD DATE</th>
                                <th style="width: 80px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Line Details Modal -->
        <div class="modal fade" id="lineModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="lineModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-start pt-3">
                        <h5 class="modal-title mb-0 mt-0">Purchase Receipt Details</h5>
                        <div class="text-muted d-flex align-items-start gap-5">
                            <h5 class="mb-0 mt-0">Doc No: <strong id="line-docno">—</strong></h5>
                            <div class="d-flex flex-column">
                                <h5 class="mb-2 mt-0">Uploaded by: <strong id="line-uploaded_by">—</strong></h5>
                                <h5 class="mb-0 mt-0">Upload date: <strong id="line-upload_date">—</strong></h5>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body pt-0">
                        <div class="table-data pt-0" id="line" role="tabpanel" aria-labelledby="line">
                            <div class="order">
                                <table id="line-table" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ITEM CODE</th>
                                            <th>DESCRIPTION</th>
                                            <th>UOM</th>
                                            <th>QUANTITY</th>
                                            <th>EXPIRY DATE</th>
                                            <th>STATUS</th>
                                            <th style="width: 100px;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger mt-3 mb-0" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Close
                                        </button>
                                    </div>
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

    $('#datefilter').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#datefilter').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format(
            'YYYY/MM/DD'));
    });

    $('#datefilter').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    let startDate = '';
    let endDate = '';

    $('#filterBtn').on('click', function() {

        const dateRange = $('#datefilter').val();
        if (dateRange) {
            const dates = dateRange.split(' - ');
            startDate = dates[0];
            endDate = dates[1];
        } else {
            startDate = '';
            endDate = '';
        }

        console.log(startDate);
        console.log(endDate);

        directory_table.ajax.reload();
    });

    var table_data = $("#releasing-table").DataTable({
        "language": {
            "infoFiltered": " ", 
        },  
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '<?php echo site_url('Releasing_cont/fetch_data_header'); ?>',
            type: 'POST',
            data: function(d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
            }
        },
        columns: [{
                data: 'document_no',
            },
            {
                data: 'customer_name'
            },
            {
                data: 'posting_date'
            },
            {
                data: 'status'
            },
            {
                data: 'upload_date'
            },
            {
                data: 'ordhd_id',
                render: function(data, type, row) {
                    return `
                        <div style="text-center">
                            ${row.r_status != 1 ? `
                                <button class="btn btn-primary btn-sm" 
                                        style="padding: 2px 6px; font-size: 12px;" 
                                        onclick="viewDetails('${data}', '${row.document_no}', '${row.customer_name}', '${row.posting_date}', '${row.status}', '${row.upload_date}')">
                                    <i class="fas fa-eye" style="font-size: 12px;"></i> View
                                </button>
                            ` : ''}
                        </div>
                    `;
                }
            }
        ]
    });

    function viewDetails(id, document_no, customer_name, posting_date, status, upload_date) {
       
        alert(id);
    }

</script>