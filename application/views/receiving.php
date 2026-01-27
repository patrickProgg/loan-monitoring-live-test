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
                    <h4 class="mb-sm-0 font-size-18">Receiving</h4>

                    <!-- Date Filter -->
                    <div class="d-flex align-items-end gap-2 p-0 m-0">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="head-title mt-0 mb-2">
            <ul class="breadcrumb nav-tabs-custom row">
                <li>
                    <a class="col-6 tab-link active" style="border-radius: 5px 0 0 5px ;"
                        data-tab="directory">SQL</a>
                </li>
                <li>
                    <a class="col-6 tab-link" style="border-radius: 0 5px 5px 0;" data-tab="uploaded">Uploaded</a>
                </li>
            </ul>
        </div>

        <div class="tab-content active mb-5" id="directory" role="tabpanel" aria-labelledby="uploaded-tab">
            <div class="table-data mt-0 pt-1">
                <div class="order" style="border-top-left-radius: 0 !important;">
                    <table id="directory-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>DOCUMENT NO</th>
                                <th>VENDOR CODE</th>
                                <th>VENDOR NAME</th>
                                <th>POSTING DATE</th>
                                <th>PR TYPE</th>
                                <th style="width: 80px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-content mb-5" id="uploaded" role="tabpanel" aria-labelledby="uploaded-tab">
            <div class="table-data mt-0 pt-1">
                <div class="order" style="border-top-left-radius: 0 !important;">
                    <table id="uploaded-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>DOCUMENT NO</th>
                                <th>VENDOR CODE</th>
                                <th>VENDOR NAME</th>
                                <th>POSTING DATE</th>
                                <th>STATUS</th>
                                <th>PR TYPE</th>
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
                                        <!-- <button type="button" class="btn btn-danger mt-3 mb-0" data-bs-dismiss="modal">Close</button> -->
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

    document.addEventListener('DOMContentLoaded', function () {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove "active" class
                tabLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                // Always safe
                const tabLink = e.currentTarget;
                tabLink.classList.add('active');

                const tabId = tabLink.getAttribute('data-tab');
                const content = document.getElementById(tabId);

                if (content) {
                    content.classList.add('active');
                }
            });
        });
    });


    var directory_table = $("#directory-table").DataTable({
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: false,
        autoWidth: false,
        ajax: {
            url: "<?php echo site_url('Receiving_cont/fetch_data_header'); ?>",
            type: "POST",
            data: function (d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw,
                    startDate: startDate,
                    endDate: endDate
                };
            },
            dataType: "json",
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            { data: "doc_no" },
            { data: "vendor_code" },
            { data: "vendor_name" },
            { data: "posting_date",
                render: function(data, type, row) {
                    if (!data) return '';
                    return data.split(' ')[0];
                }
            },
            { data: null,            
                defaultContent: "purchase receipt"},
            {data: 'doc_no',
            render: function (data, type, row) {
                return `<button class="btn btn-sm btn-primary" onclick='uploadData(${JSON.stringify(row)})'>
                            <i class="fas fa-upload"></i> Upload
                        </button>`;
            }
        }

        ]
    });

    var uploaded_table = $("#uploaded-table").DataTable({
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo site_url('Receiving_cont/fetch_txt_files_header'); ?>",
            type: "POST",
            data: function (d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw
                };
            },
            dataType: "json",
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            { data: "doc_no" },
            { data: "vendor_code" },
            { data: "vendor_name" },
            {
                data: "posting_date",
                render: function (data, type, row) {
                    if (!data) return '';

                    const date = new Date(data);
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return date.toLocaleDateString('en-US', options);
                }
            },
            { data: "status" },
            { data: "pr_type" },
            {
                data: 'prhd_id',
                render: function (data, type, row, uploaded_by) {
                    return `<button class="btn btn-sm btn-primary" onclick="openLineModal('${row.prhd_id}', '${row.doc_no}' , '${row.upload_date}' , '${row.upload_by}')"><i class="fas fa-eye"></i>
                    View</button>`;
                }
            }
        ]
    });

    function uploadData(data) {
        console.log(data);
        // return;  
        Swal.fire({
            title: 'Are you sure?',
            text: `Upload "${data.doc_no}" to WMS?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, upload it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('Receiving_cont/upload_data_lines'); ?>",
                    type: 'POST',
                    data: {
                        data: data
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Data uploaded successfully",
                                icon: 'success',
                                timer: 1000,       
                                showConfirmButton: false, 
                            }).then(() => {
                                location.reload();
                            });

                        }
                    },
                    error: function (xhr) {
                        Swal.fire('AJAX Error', xhr.statusText, 'error');
                    }
                });
            }
        });
    }

    var prhd_id_sel = 0;
    var uploader_id = 0;

    const prline_table = $('#line-table').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo site_url('Receiving_cont/fetch_lines'); ?>",
            type: 'POST',
            dataType: 'json',
            data: function (d) {
                d.id = prhd_id_sel;
                return d;
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", xhr.responseText);
                Swal.fire('Error', 'Failed to load data: ' + error, 'error');
            }
        },
        columns: [{
            data: 'item_code'
        },
        {
            data: 'item_desc'
        },
        {
            data: 'item_uom'
        },
        {
            data: 'item_qty'
        },
        {
            data: 'lot_no'
        },
        {   data: 'expiry_date',
            render: function (data, type, row) {
                if (!data || data === '0000-00-00') {
                    return '—';
                }else {
                    return data; 
                }
            }
        },
        {data: 'prln_id',
            render: function (data, type, row) {
                return `
                    <button class="btn btn-sm btn-primary" onclick="viewLineData('${row.prln_id}')">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button class="btn btn-sm btn-warning" 
                            onclick="editLineData(this, '${row.prln_id}', '${row.expiry_date}')">
                        <i class="fas fa-edit"></i>
                    </button>

                `;
            }
        }

        ],
    });

    function openLineModal(prhd_id, doc_no, upload_date, uploaded_by) {
        console.log("ID:", prhd_id);
        console.log("ID:", uploaded_by);

        prhd_id_sel = prhd_id;

        $.ajax({
            url: "<?php echo site_url('Receiving_cont/getUser'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: uploaded_by
            },
            success: function (response) {
                console.log(response);
                $('#line-uploaded_by').text(response || '—');
            }
        });

        prline_table.ajax.reload();
        $('#lineModal').modal('show');

        $('#line-docno').text(doc_no || '—');
        $('#line-upload_date').text(formatDate(upload_date));
        $('#line-uploaded_by').text(uploaded_by || '—');
    }

    function viewLineData(prln_id) {
        Swal.fire({
            icon: 'info',
            title: 'Hello!',
            text: 'You clicked line ID: ' + prln_id
        });
    }

    function editLineData(btn, prln_id, expiry_date) {
    
        let row = prline_table.row($(btn).closest('tr'));

        // if (expiry_date === "null" || expiry_date === '0000-00-00') {
            let cell = row.node().querySelector('td:nth-child(6)'); 
            cell.innerHTML = `<input type="date" class="form-control form-control-sm expiry-date" data-id="${prln_id}" value="" style="width: 120px">`;

            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-success');

            btn.onclick = function() {
                let newDate = cell.querySelector('input').value;
                
                if (!newDate) {
                    Swal.fire('Error', 'Please select a date', 'error');
                    btn.innerHTML = '<i class="fas fa-edit"></i>';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-warning');

                    prline_table.ajax.reload();

                    btn.onclick = function() {
                        editLineData(btn, prln_id, '0000-00-00');
                    };

                    return;
                }

                $.ajax({
                    url: "<?php echo site_url('Receiving_cont/update_expiry_date'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        prln_id: prln_id,
                        expiry_date: newDate
                    },
                    success: function (response) {

                        Swal.fire('Success', 'Expiry date saved', 'success');
                        btn.innerHTML = '<i class="fas fa-edit"></i>';
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-warning');

                        prline_table.ajax.reload();

                        btn.onclick = function() {
                            editLineData(btn, prln_id, '0000-00-00');
                        };
                    }
                });
            };
        // }
    }


    function formatDate(dateString) {
        if (!dateString || dateString === '0000-00-00') return '—';

        const date = new Date(dateString);
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return date.toLocaleDateString('en-US', options);
    }
</script>