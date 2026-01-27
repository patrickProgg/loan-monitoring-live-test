<style>
    #content main .table-data .order {
        padding-top: 0;
    }
</style>
<section id="content">
    <!-- MAIN -->
    <main>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Masterfile</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tools </a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-primary" onclick="extract()">
                <i class="fas fa-download"></i> Extract
            </button>
        </div>

        <div class="table-data mt-3 mb-5">
            <div class="order">
                <table id="item_masterfile-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ITEM CODE</th>
                            <th>ITEM DESCRITION</th>
                            <th>VENDOR CODE</th>
                            <th style="width: 100px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Item Details Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="lineModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="width: 600px;">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title mb-0" id="lineModalLabel">Item Code Details</h5>
                        <div class="text-muted">
                            <h5 class="mb-0">Item Code: <strong id="item_code">—</strong></h5>
                        </div>
                    </div>


                    <div class="modal-body pt-0">
                        <div class="table-data pt-1" id="line" role="tabpanel" aria-labelledby="line">
                            <div class="order">
                                <table id="item-table" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>BARCODE</th>
                                            <th>UOM</th>
                                            <th style="width: 80px; margin-right:auto">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger mt-3 mb-0" data-bs-dismiss="modal"> <i class="fas fa-times"></i> Close</button>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    window.jsPDF = window.jspdf.jsPDF;

    var masterfile_table = $("#item_masterfile-table").DataTable({
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
            url: '<?php echo site_url('Masterfile_cont/get_items'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw,
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [{
                data: 'item_code'
            },
            {
                data: 'item_desc'
            },
            {
                data: 'vend_code',
            },
            {
                data: 'item_id',
                render: function(data, type, row) {
                    return `
            <button class="btn btn-sm btn-primary" onclick="itemCodeData('${row.item_code}')"><i class="fas fa-eye"></i> View</button>
            <i class="fas fa-sync text-success ms-2" style="cursor: pointer; font-size: 14px;" onclick="syncItemCode('${row.item_code}')"></i>
        `;
                }
            }
        ]
    });

    function extract() {
        Swal.fire({
            title: 'Confirmation',
            text: "Do you want to extract all data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const loadingSwal = Swal.fire({
                    title: 'Loading...',
                    text: 'Extracting data, please wait.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "<?php echo site_url('Masterfile_cont/extract_from_nav'); ?>",
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        loadingSwal.close();
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success'
                            });
                            masterfile_table.ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'An error occurred.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        loadingSwal.close();
                        Swal.fire({
                            title: 'AJAX Error',
                            text: 'Something went wrong while extracting data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    function syncItemCode(item_code) {

        Swal.fire({
            title: 'Confirmation',
            text: "Do you want to update this item code :" + " " + item_code + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const loadingSwal = Swal.fire({
                    title: 'Loading...',
                    text: 'Extracting data, please wait.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "<?php echo site_url('Masterfile_cont/syncItemCode_from_nav'); ?>",
                    type: "POST",
                    data: {
                        item_code: item_code
                    },
                    dataType: "json",
                    success: function(response) {
                        loadingSwal.close();
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success'
                            });
                            masterfile_table.ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'An error occurred.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        loadingSwal.close();
                        Swal.fire({
                            title: 'AJAX Error',
                            text: 'Something went wrong while extracting data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    var global_item_code = 0;
    var uploader_id = 0;

    const item_table = $('#item-table').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: "<?php echo site_url('Masterfile_cont/getLineData'); ?>",
            type: 'POST',
            dataType: 'json',
            data: function(d) {
                d.item_code = global_item_code;
                return d;
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr.responseText);
                Swal.fire('Error', 'Failed to load data: ' + error, 'error');
            }
        },
        columns: [{
                data: 'barcode'
            },
            {
                data: 'uom'
            },
            {
                data: 'ib_id',
                render: function(data, type, row) {
                    return `
            <button class="btn btn-sm btn-primary" onclick="printBarcode('${row.barcode}')"><i class="fas fa-barcode"></i> Generate</button>
        `;
                }
            }
        ],
    });


    function itemCodeData(item_code) {
        console.log("ID:", item_code);

        global_item_code = item_code;

        item_table.ajax.reload();

        $('#itemModal').modal('show');
        $('#item_code').text(item_code || '—');
    }

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
            success: function(response) {
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

    function printBarcode(barcode) {
        console.log("barcode:", barcode);

        Swal.fire({
            title: 'Generated Barcode',
            html: `
            <div id="barcodePreview"></div>
        `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-print"></i> Print',
            cancelButtonText: '<i class="fas fa-times"></i> Close',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            allowOutsideClick: false,
            didOpen: () => {
                const canvas = document.createElement('canvas');
                JsBarcode(canvas, barcode, {
                    format: "CODE128",
                    displayValue: false,
                    fontSize: 16
                });

                document.getElementById('barcodePreview').appendChild(canvas);
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const canvas = document.createElement('canvas');
                JsBarcode(canvas, barcode, {
                    format: "CODE128",
                    displayValue: false,
                    fontSize: 16
                });

                Swal.fire({
                    title: 'Loading...',
                    text: 'Preparing QR code, please wait.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Create and submit form
                const form = document.createElement('form');
                form.action = "<?php echo site_url('Masterfile_cont/generate_pdf_barcode'); ?>";
                form.method = 'POST';
                form.target = '_blank';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'barcode';
                input.value = barcode;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                Swal.close();

            }



            // const imgData = canvas.toDataURL('image/png');

            // const doc = new jsPDF({
            //     orientation: "landscape",
            //     unit: "mm",
            //     format: [60, 30]
            // });

            // doc.addImage(imgData, 'PNG', 5, 5, 50, 20);

            // const blob = doc.output('blob');
            // const blobUrl = URL.createObjectURL(blob);
            // const newTab = window.open(blobUrl, '_blank');
            // }
        });
    }
</script>