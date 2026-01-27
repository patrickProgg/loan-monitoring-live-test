<style>
    .form-check {
        font-size: 14px;
        margin-left: 15px;
    }

    .form-check-input {
        transform: scale(1.5);
        margin-right: 10px;
    }

    #rackInfoModal .modal-dialog {
        max-width: 1200px;
        width: 100%;
    }

    #rackInfoModal .modal-content {
        max-height: 92vh;
        overflow: hidden;
    }

    #rackInfoModal .modal-body {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 95vh;
    }

    #rackInfoModal .row {
        flex: 1;
        overflow: hidden;
    }

    .col-12.col-md-3.d-flex.flex-column {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    #rack-cards-container {
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 10px;
        box-sizing: border-box;
        margin-top: 5px;
    }

    #rack-cards-container::-webkit-scrollbar {
        width: 8px;
    }

    #rack-cards-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #rack-cards-container::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
        border: 1px solid #f1f1f1;
    }

    #rack-cards-container::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    #location-table tbody td {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .card {
        overflow: visible !important;
        background-color: rgba(250, 250, 250, 0);

    }

    .card-body {
        background-color: rgba(250, 250, 250, 0);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(4px);
        border-radius: 5px;
    }
</style>

<section id="content">
    <main>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Location</h4>
                </div>
            </div>
        </div>

        <div class="page-title-box d-sm-flex align-items-center justify-content-start">
            <button class="btn btn-primary" id="openAddLineModal">
                <i class="fas fa-align-justify"></i> Add line
            </button>
        </div>

        <div id="line-container" class="row mb-5">
        </div>

        <!--rack info Modal -->
        <div class="modal fade" id="rackInfoModal" tabindex="-1" role="dialog" aria-labelledby="rackInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1500px; width: 100%;" role="document">

                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center flex-wrap gap-2">
                        <h5 class="modal-title me-3" id="rackInfoModalLabel">Rack Information</h5>
                        <p class="mb-0"><strong>Line </strong> <span id="modalLineId"></span></p>
                        <p class="mb-0 ms-3"><strong>Rack </strong> <span id="modalRackId"></span></p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div>
                            <button class="btn btn-primary btn-sm mb-2" id="openAddBayModal" style="margin-left:10px">
                                <span class="me-1" style="font-weight: bold;">||||</span> Add Bay
                            </button>
                        </div>

                        <div class="mb-3 d-flex flex-wrap gap-3" id="bayCheckboxContainer">
                            <!-- Dynamically generated checkboxes will be appended here -->
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-3 d-flex flex-column" style="overflow: visible; height: 100%;">
                                <div style="box-shadow: 0 5px 4px -2px rgba(0, 0, 0, 0.2);">
                                    <button class="btn btn-primary btn-sm mb-2" id="openAddLevelModal" style="margin-left:10px">
                                        <i class="fas fa-align-justify me-1"></i> Add Level
                                    </button>
                                </div>

                                <!-- Left Column for Cards -->
                                <div id="rack-cards-container" style="flex-grow: 1; overflow-y: auto; overflow-x: hidden; padding-right: 10px; padding-bottom: 10px;">
                                    <!-- Cards will be injected here -->
                                </div>
                            </div>

                            <div class="col-9" id="table-content-container">
                                <div class="row mb-3" id="table-header" style="border: 1px solid #808080; width: 100%; border-radius:5px; margin-left:1px">
                                    
                                    <div class="col-md-4">
                                        <div class="mb-2 mt-2">
                                            Document No : <span id="documentNo" style="font-weight: bold;">-</span>
                                        </div>
                                        <div class="mb-2 mt-2">
                                            Vendor Code : <span id="vendorCode" style="font-weight: bold;">-</span>
                                        </div>
                                        <div class="mb-2 mt-2">
                                            Vendor Name : <span id="vendorName" style="font-weight: bold;">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-2 mt-2">
                                            Posting Date : <span id="postingDate" style="font-weight: bold;">-</span>
                                        </div>
                                        <div class="mb-2 mt-2">
                                            Upload Date : <span id="uploadDate" style="font-weight: bold;">-</span>
                                        </div>
                                        <div class="mb-2 mt-2">
                                            PR Type : <span id="prType" style="font-weight: bold;">-</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="mb-2 mt-2">
                                            Receive Qty : <span id="receiveQty" style="font-weight: bold;">-</span>
                                        </div>
                                        <div class="mb-2 mt-2">
                                            Inbound by : <span id="username" style="font-weight: bold;">-</span>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-2">
                                        <div class="text-end mt-2 d-none" id="generateQrWrapper">
                                            <button type="submit" id="generateQr" class="btn btn-primary btn-sm">
                                                <i class="fas fa-qrcode"></i> Generate QR
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <table id="binData-table" class="table table-hover" style="width:100%;">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>ITEM CODE</th>
                                                <th>DESCRIPTION</th>
                                                <th>START STOCK</th>
                                                <th>REM STOCK</th>
                                                <th>UOM</th>
                                                <th>EXPIRY DATE</th>
                                                <th style="width: 80px;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--rack info Modal -->

        <!--Add Line Modal -->
        <div class="modal fade" id="addLineModal" tabindex="-1" role="dialog" aria-labelledby="addLineModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 500px;" role="document">
                <div class="modal-content" style="border:none;">
                    <div class="modal-header d-flex align-items-center flex-wrap">
                        <h5 class="modal-title me-2" id="rackInfoModalLabel">Add Line</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="levelForm">
                            <div class="row mb-3 align-items-end">
                                <div class="col-12 mb-2">
                                    <label for="new_line" class="form-label">New Line</label>
                                    <input type="number" class="form-control" id="new_line" name="new_line" placeholder="Enter new line (disables existing line)">
                                </div>

                                <div class="col-8">
                                    <label for="line" class="form-label">Existing Line</label>
                                    <input type="number" class="form-control" id="line" name="line" placeholder="Enter existing line (disables new line)">
                                </div>

                                <div class="col-4">
                                    <label for="rack" class="form-label">Number of Rack</label>
                                    <input type="number" class="form-control" id="rack" name="rack">
                                </div>

                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitLine">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--Add Line Modal -->

        <!--Add level Modal -->
        <div class="modal fade" id="addLevelModal" tabindex="-1" role="dialog" aria-labelledby="addLevelModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 500px;" role="document">
                <div class="modal-content" style="border-radius: 5px; box-shadow: 0 8px 22px rgba(0, 0, 0, 0.2);">
                    <div class="modal-header d-flex align-items-center flex-wrap">
                        <h5 class="modal-title me-2" id="rackInfoModalLabel">Add Level in</h5>
                        <h5 class="mb-0"><strong>[ Line </strong><span id="modalLineIdsLevel"></span> <strong>]</strong></h5>
                        <h5 class="mb-0 ms-1"><strong>[ Rack</strong> <span id="modalRackIdsLevel"></span> <strong>]</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="levelForm">
                            <div class="mb-3">
                                <label for="level" class="form-label">Number of Level</label>
                                <input type="number" class="form-control" id="level" name="level">
                                <input type="hidden" id="addLevelLineId" name="line_id">
                                <input type="hidden" id="addLevelRackId" name="rack_id">
                                <input type="hidden" id="addLevelBayId" name="level_bay_id">

                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitLvl"><i class="fas fa-plus"></i> Add</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Add level Modal -->

        <!--Add bay Modal -->
        <div class="modal fade" id="addBayModal" tabindex="-1" role="dialog" aria-labelledby="addBayModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 500px; width: 100%;" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center flex-wrap gap-2">
                    <h5 class="modal-title me-2" id="rackInfoModalLabel">Add Level in</h5>
                        <h5 class="mb-0"><strong>[ Line </strong><span id="modalLineIdsBay"></span> <strong>]</strong></h5>
                        <h5 class="mb-0 ms-1"><strong>[ Rack</strong> <span id="modalRackIdsBay"></span> <strong>]</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    <form id="bayForm">
                            <div class="mb-3">
                                <label for="bay" class="form-label">Number of Bay</label>
                                <input type="number" class="form-control" id="bay" name="bay">
                                <input type="hidden" id="addBayLineId" name="line_id">
                                <input type="hidden" id="addBayRackId" name="rack_id">
                                <input type="hidden" id="addBayLevelId" name="bay_level_id">

                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitBay"><i class="fas fa-plus"></i> Add</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--End of Add bay Modal -->

        <!--Add bin Modal -->
        <div class="modal fade" id="addBinModal" tabindex="-1" role="dialog" aria-labelledby="addBinModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 500px;" role="document">
                <div class="modal-content" style="border-radius: 5px; box-shadow: 0 8px 22px rgba(0, 0, 0, 0.2);">
                    <div class="modal-header d-flex align-items-center flex-wrap" style="border-top-left-radius:4px; border-top-right-radius:4px;">
                        <h5 class="modal-title me-3" id="rackInfoModalLabel">Add Bin in</h5>
                        <h5 class="mb-0"><strong>[ Line </strong><span id="binLineId"></span> <strong>]</strong></h5>
                        <h5 class="mb-0 ms-3"><strong>[ Rack </strong><span id="binRackId"></span> <strong>]</strong></h5>
                        <h5 class="mb-0 ms-3"><strong>[ Bay </strong><span id="binBayId"></span> <strong>]</strong></h5>
                        <h5 class="mb-0 ms-3"><strong>[ Level </strong><span id="binLevelId"></span> <strong>]</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="addLevelForm">
                            <div class="mb-3">
                                <label for="bayName" class="form-label">Number of Bin</label>
                                <input type="number" class="form-control" id="bin" name="bin">
                                <input type="hidden" id="addBinLineId" name="line_id">
                                <input type="hidden" id="addBinRackId" name="rack_id">
                                <input type="hidden" id="addBinLevelId" name="level_id">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitBin"><i class="fas fa-plus"></i> Add</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Add bin Modal -->
    </main>
</section>

<script>
    function toggleFields() {
        const $newLine = $('#new_line');
        const $existingLine = $('#line');

        if ($newLine.val()) {
            $existingLine.prop('disabled', true);
        } else {
            $existingLine.prop('disabled', false);
        }

        if ($existingLine.val()) {
            $newLine.prop('disabled', true);
        } else {
            $newLine.prop('disabled', false);
        }
    }

    $('#new_line').on('input', toggleFields);
    $('#line').on('input', toggleFields);

    toggleFields();

    let latest_bay = "";
    let latest_level = "";

    $(document).ready(function() {
        function loadLines() {
            $.ajax({
                url: '<?php echo site_url('Location_cont/lines') ?>',
                type: "GET",
                dataType: "json",
                success: function(response) {

                    let lineHtml = "";
                    let lines = response.data;

                    $.each(lines, function(index, item) {
                        let lineId = item.line_id;
                        let rackIds = item.rack_ids ? item.rack_ids.split(',') : [];

                        let lineCard = `
                              <div class="col-12 col-sm-6 line-card-wrapper">
                                <div class="card line-card w-100 shadow" data-line-id="${lineId}">
                                    <div class="card-body">
                                        <div class="line-container">
                                            <p class="card-title" style="font-size: 14px;">Line ${lineId}</p>
                                            <div class="rack-buttons-container d-flex flex-wrap gap-3 justify-content-center">`;
                                                $.each(rackIds, function(i, rackId) {
                                                    lineCard += `
                                                        <div style="text-align: center; cursor: pointer;" >
                                                            <img src="<?= base_url(); ?>assets/images/rack.png"
                                                                alt="Rack ${rackId}"
                                                                height="50"
                                                                class="rack-button-img mb-1"
                                                                data-rack-id="${rackId}"
                                                                data-line-id="${lineId}"
                                                                style="cursor: pointer;">
                                                            <div class="rack-button-img"
                                                                data-rack-id="${rackId}"
                                                                data-line-id="${lineId}"
                                                                style="font-size: 13px; cursor: pointer;">
                                                                Rack ${rackId}
                                                            </div>
                                                        </div>`;
                                                    if (i < rackIds.length - 1) {
                                                        lineCard += `<span style="margin: 30px 20px 20px; display: inline-block;"></span>`;
                                                    }
                                                });
                                                lineCard += `
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        lineHtml += lineCard;
                    });
                    $("#line-container").html(lineHtml);
                },
                error: function() {
                    alert("Failed to load locations.");
                }
            });
        }
        loadLines();

        
    });

    $(document).on('click', '.rack-button-img', function() {
        let lineId = $(this).data('line-id');
        let rackId = $(this).data('rack-id');

        $('#rack-cards-container').empty();
        $('#bayCheckboxContainer').empty();

        $('#modalLineId').text(lineId);
        $('#modalRackId').text(rackId);

        $('#openAddLevelModal')
            .data('line-id', lineId)
            .data('rack-id', rackId);

        $('#openAddBayModal')
            .data('line-id', lineId)
            .data('rack-id', rackId);

        $('#rackInfoModal').modal('show');

        loadRacks(lineId, rackId);
    });

    function loadRacks(lineId, rackId) {
        $.ajax({
            url: '<?php echo site_url('Location_cont/racks') ?>',
            type: 'POST',
            data: {
                line: lineId,
                rack: rackId
            },
            dataType: "json",
            success: function(response) {

                let racks = response.rack;
                let rack = response.rack[0];
                let bays = response.bay[0];
                let line = bays.line_id;
                let bayIds = bays.bay_ids ? bays.bay_ids.split(',') : [];
                let lastBayId = bayIds.length > 0 ? bayIds[bayIds.length - 1] : null;

                let levelIds = rack.level_ids ? rack.level_ids.split(',') : [];
                let lastLevelId = levelIds.length > 0 ? levelIds[levelIds.length - 1] : null;

                latest_bay = lastBayId;
                latest_level = lastLevelId;
                
                $.each(bayIds, function(index, bayId) {
                    let checkboxHtml = `
                    <div class="form-check">
                        <input class="form-check-input bay-checkbox" type="checkbox" value="${bayId}" id="bay${bayId}">
                        <label class="form-check-label" for="bay${bayId}">
                            Bay ${bayId}
                        </label>
                    </div>`;
                    $('#bayCheckboxContainer').append(checkboxHtml);
                });

                $.each(racks, function(index, item) {
                    let lineId = item.line_id;
                    let rackId = item.rack_id;
                    let levelIds = item.level_ids ? item.level_ids.split(',') : [];

                    $.each(levelIds, function(i, levelId) {
                        if (!levelId || parseInt(levelId) === 0) {
                            return;
                        }

                        let rackCard = `
                            <div class="rack-row mt-2" style=" margin-left:10px; height: 100px;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" data-rack-id="${rackId}" style="width: 100%; height: 100px; position: relative; overflow: hidden; border-radius: 5px;  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            <!-- Header appears above or under depending on z-index --> 
                                            <div class="card-header" style="z-index: 2; position: absolute; top: 0; left: 0; width: 100%; padding: 5px 10px; background-color: white;  border-radius: 10px; /*background-color: black*/">
                                                <h6 class="level-button mb-0" style="margin: 0;">Level ${levelId}</h6>
                                                <button class=" openAddBinModal btn btn-sm btn-primary" style=" font-size: 10px; cursor: pointer; position: absolute; top: 2px; right: -5px; z-index: 3;"data-lines-id="${line}" data-racks-id="${rackId}"  data-levels-id="${levelId}" >
                                                    <i class="fas fa-box me-1"></i> Add Bin
                                                </button>
                                            </div>

                                            <!-- Overlapping card body -->
                                            <div class="card-body" style="z-index: 1; position: absolute; top: 0; left: 0; right: 0; bottom: 0; ">
                                                <h6 class="level-button mb-0" style="cursor: pointer;" data-level-id="${levelId}" id="bin_val" data-rack-id="${rackId}">
                                                    <!-- Add content here -->
                                                </h6>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>`;

                        $('#rack-cards-container').append(rackCard);
                    });
                });
            },
            error: function() {
                alert("Failed to load locations.");
            }
        });
    }

    $(document).ready(function() {

        $('#rackInfoModal').on('shown.bs.modal', function() {
            $('#bayCheckboxContainer .bay-checkbox').first().prop('checked', true).trigger('change');
        });

        $('#bayCheckboxContainer').on('change', '.bay-checkbox', function() {

            $('.bay-checkbox').not(this).prop('checked', false);

            $('[data-level-id]').each(function() {
                $(this).removeAttr('data-bin-id'); 
                $(this).find('.bin-display').remove(); 
            });

            if ($(this).is(':checked')) {
                const bayId = $(this).val();
                const lineId = $('#modalLineId').text();
                const rackId = $('#modalRackId').text();

                $.ajax({
                    url: 'Location_cont/bin',
                    type: 'POST',
                    data: {
                        bay_id: bayId,
                        line_id: lineId,
                        rack_id: rackId
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        let data = response.data;

                        let levelBins = {};
                        $.each(data, function(index, item) {
                            if (!levelBins[item.level_id]) {
                                levelBins[item.level_id] = [];
                            }
                            levelBins[item.level_id].push({
                                bin_id: item.bin_id,
                                loc_id: item.loc_id
                            });
                        });

                        $.each(levelBins, function(levelId, binItems) {
                            const levelElement = $(`[data-level-id="${levelId}"]`);

                            if (levelElement.length) {
                                const binIds = binItems.map(item => item.bin_id);
                                levelElement.attr('data-bin-id', binIds.join(','));

                                let binButtons = binItems.map(function(binItem) {
                                    return `<div class="bin-unit d-flex flex-column align-items-center" style="height:20px;">
                                                <img 
                                                    src="<?= base_url(); ?>assets/images/box.png" 
                                                    alt="Bin ${binItem.bin_id}" 
                                                    height="50" 
                                                    style="margin: 0; padding: 0; cursor: pointer;"
                                                    class="bin-image"
                                                    data-bin-id="${binItem.bin_id}" 
                                                    data-loc-id="${binItem.loc_id}"
                                                >
                                                <h6 class="mt-1 mb-0 text-center bin-label" data-bin-id="${binItem.bin_id}">
                                                    Bin ${binItem.bin_id}
                                                </h6>
                                            </div>`;
                                }).join('<span class="text-muted align-self-center"></span>');

                                levelElement.append(`<div class="bin-display d-flex align-items-center flex-wrap justify-content-center gap-3 mt-1 mb-0 p-0"> ${binButtons} </div>`);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });
    });

    let global_locId = 0;

    $(document).on('click', '.bin-image', function () {
        const openSrc = '<?= base_url(); ?>assets/images/box_open.png';
        const closedSrc = '<?= base_url(); ?>assets/images/box.png';

        $('.bin-image').attr('src', closedSrc);

        $(this).attr('src', openSrc);

        global_locId = $(this).data('loc-id');
        $('#generateQrWrapper').removeClass('d-none');

        bin_table.ajax.reload();
    });


    var bin_table = $("#binData-table").DataTable({
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        autoWidth: false,
        ajax: {
            url: '<?php echo site_url('Location_cont/get_bin_details'); ?>',
            type: 'POST',
            data: function(d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.locId = global_locId
            },
            dataSrc: function(json) {

                $('#documentNo').text('-');
                $('#vendorName').text('-');
                $('#vendorCode').text('-');
                $('#postingDate').text('-');
                $('#uploadDate').text('-');
                $('#prType').text('-');
                $('#receiveQty').text('-');
                $('#username').text('-');

                return json.data;
            }
        },
        columns: [{
                data: 'item_code',
                width: '50px'
            },
            {
                data: 'item_desc'
            },
            {
                data: 'starting_stock',
                width: '100px'
            },
            {
                data: 'remaining_qty',
                width: '100px'
            },
            {
                data: 'item_uom',
                width: '100px'
            },
            {
                data: 'expiry_date',
                width: '100px'
            },
            {
                data: 'prln_id',
                width: '100px',
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-primary" onclick="getLineDetails('${row.doc_no}', '${row.vendor_name}', '${row.vendor_code}', '${row.posting_date}', '${row.upload_date}', '${row.pr_type}', '${row.remaining_qty}', '${row.fullname}')"><i class="fas fa-eye"></i>
                    View</button>`;
                }
            },
        ]
    });

    $(document).on('click', '#generateQr', function() {
 
        $.ajax({
            url: "<?php echo site_url('Location_cont/generate_qr'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                loc_id: global_locId
            },
            success: function(response) {
                // loadingSwal.close();

                if (response.data) {

                    let data = response.data;
                    let area_type = data[0].area_type;
                    let line_id = data[0].line_id;
                    let rack_id = data[0].rack_id;
                    let bay_id = data[0].bay_id;
                    let level_id = data[0].level_id;
                    let bin_id = data[0].bin_id;

                    $('#qrCodeContainer').empty();

                    let locCode = String(global_locId).padStart(4, '0');

                    const barcodeData = `WMS-URC-${locCode}:${area_type},${line_id},${rack_id},${level_id},${bay_id},${bin_id}`;

                    Swal.fire({
                        title: 'Generated QR Code',
                        html: `
                            <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: start; gap: 20px; margin-top: 10px;">
                                <div style="min-width: 200px;">
                                    <ul class="list-group text-start">
                                        <li class="list-group-item"><strong>Area Type:</strong> ${area_type}</li>
                                        <li class="list-group-item"><strong>Line ID:</strong> ${line_id}</li>
                                        <li class="list-group-item"><strong>Rack ID:</strong> ${rack_id}</li>
                                        <li class="list-group-item"><strong>Level ID:</strong> ${level_id}</li>
                                        <li class="list-group-item"><strong>Bay ID:</strong> ${bay_id}</li>
                                        <li class="list-group-item"><strong>Bin ID:</strong> ${bin_id}</li>
                                    </ul>
                                </div>
                                <div style="text-align: center;">
                                    <div id="qrSwalContainer" style="width: 220px; height: 220px;"></div>
                                    <div class="text-end mt-4">
                                        <button id="printQrBtn" class="btn btn-success me-2"><i class="fas fa-print"></i> Print</button>
                                        <button id="cancelBtn" class="btn btn-danger"><i class="fas fa-times"></i> Close</button>
                                    </div>
                                </div>
                            </div>
                        `,
                        width: 510,
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            new QRCode(document.getElementById("qrSwalContainer"), {
                                text: barcodeData,
                                width: 220,
                                height: 220
                            });

                            const printBtn = document.getElementById('printQrBtn');
                            if (printBtn) {
                                printBtn.addEventListener('click', () => {

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

                                    const form = document.createElement('form');
                                    form.action = "<?php echo site_url('Location_cont/generate_pdf_qrcode'); ?>";
                                    form.method = 'POST';
                                    form.target = '_blank';

                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'loc_id';
                                    input.value = global_locId;

                                    form.appendChild(input);
                                    document.body.appendChild(form);
                                    form.submit();
                                    document.body.removeChild(form);

                                    Swal.close();
                                });
                            }

                            const cancelBtn = document.getElementById('cancelBtn');
                            if (cancelBtn) {
                                cancelBtn.addEventListener('click', () => Swal.close());
                            }
                        }
                    });

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Location data not found.',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                loadingSwal.close();
                Swal.fire({
                    title: 'AJAX Error',
                    text: 'Something went wrong while retrieving data.',
                    icon: 'error'
                });
            }
        });
    });

    $(document).on('click', '#openAddLineModal', function() {
        $('#addLineModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#addLineModal').modal('show');
    });

    $(document).on('click', '#openAddLevelModal', function() {
        let lineId = $(this).data('line-id');
        let rackId = $(this).data('rack-id');

        $('#level').val('');
        $('#modalLineIdsLevel').text(lineId);
        $('#modalRackIdsLevel').text(rackId);

        $('#addLevelLineId').val(lineId);
        $('#addLevelRackId').val(rackId);
        $('#addLevelBayId').val(latest_bay);

        $('#addLevelModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#addLevelModal').modal('show');
    });

    $(document).on('click', '#openAddBayModal', function() {

        let lineId = $(this).data('line-id');
        let rackId = $(this).data('rack-id');

        $('#bay').val('');
        $('#modalLineIdsBay').text(lineId);
        $('#modalRackIdsBay').text(rackId);
        
        $('#addBayLineId').val(lineId);
        $('#addBayRackId').val(rackId);
        $('#addBayLevelId').val(latest_level);
        
        $('#addBayModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#addBayModal').modal('show');
    });

    $(document).on('click', '.openAddBinModal', function() {

        let selectedBay = $('#bayCheckboxContainer input.bay-checkbox:checked').val() || '';
        let lineId = $(this).data('lines-id');
        let rackId = $(this).data('racks-id');
        let levelId = $(this).data('levels-id');

        $('#bin').val('');
        $('#binLineId').text(lineId);
        $('#binRackId').text(rackId);
        $('#binLevelId').text(levelId);
        $('#binBayId').text(selectedBay);

        $('#addBinLineId').val(lineId);
        $('#addBinRackId').val(rackId);
        $('#addBinLevelId').val(levelId);

        $('#addBinModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#addBinModal').modal('show');
    });

    $(function() {
        $("#submitLvl").on('click', function(e) {
            e.preventDefault();

            var line = $("#modalLineIdsLevel").text();
            var rack = $("#modalRackIdsLevel").text();
            var bay = $("#addLevelBayId").val();
            var level = $("#level").val();

            if (!level || level <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Do not leave level empty'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to add this level?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Location_cont/add_level'); ?>",
                        data: {
                            line: line,
                            rack: rack,
                            level: level,
                            bay: bay
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                let line = response.data[0].line_id;
                                let rack = response.data[0].rack_id;
                                let level = response.data[0].level_id;

                                latest_level = level;

                                Swal.fire('Success', response.message, 'success');
                                $('#addLevelModal').modal('hide');
                                $('#rackInfoModal').modal('hide');

                                setTimeout(function() {
                                    $('#rack-cards-container').empty();
                                    $('#bayCheckboxContainer').empty();
                                    $('#level').val('');
                                    $('#rackInfoModal').modal('show');

                                    loadRacks(line, rack);
                                }, 200);
                            } else {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        }
                    });
                }
            });
        });
    });

    $(function() {
        $("#submitBay").on('click', function(e) {
            e.preventDefault();

            var line = $("#modalLineIdsBay").text();
            var rack = $("#modalRackIdsBay").text();
            var level = $("#addBayLevelId").val();
            var bay = $("#bay").val();
      
            if (!bay || bay <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Do not leave bay empty'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to add this bay?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Location_cont/add_bay'); ?>",
                        data: {
                            line: line,
                            rack: rack,
                            bay: bay,
                            level: level
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                let line = response.data[0].line_id;
                                let rack = response.data[0].rack_id;

                                Swal.fire('Success', response.message, 'success');
                                $('#addBayModal').modal('hide');
                                $('#rackInfoModal').modal('hide');

                                setTimeout(function() {
                                    $('#rack-cards-container').empty();
                                    $('#bayCheckboxContainer').empty();
                                    $('#bay').val('');
                                    $('#rackInfoModal').modal('show');

                                    loadRacks(line, rack);
                                }, 200);
                            } else {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        }
                    });
                }
            });
        });
    });

    $(function() {
        $("#submitLine").on('click', function(e) {
            e.preventDefault();

            var new_line = $("#new_line").val();
            var line = $("#line").val();
            var rack = $("#rack").val();

            function addRack(targetLine, url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to add this rack?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                line: targetLine,
                                rack: rack
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', response.message, 'success');
                                    setTimeout(() => location.reload(), 1000); 
                                } else {
                                    Swal.fire('Error', 'Something went wrong', 'error');
                                }
                            }
                        });
                    }
                });
            }

            if (new_line) {
                addRack(new_line, "<?= site_url('Location_cont/add_new_line'); ?>");
            } else if (line) {
                addRack(line, "<?= site_url('Location_cont/add_rack'); ?>");
            } else {
                Swal.fire('Error', 'Please enter either a new line or select an existing line', 'error');
            }

        });
    });

    $(function() {
        $("#submitBin").on('click', function(e) {
            e.preventDefault();

            var line = $("#binLineId").text();
            var rack = $("#binRackId").text();
            var level = $("#binLevelId").text();
            var bay = $("#binBayId").text();

            var bin = $("#bin").val();

            if (!bin || bin <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Do not leave bin empty'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to add this level?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('Location_cont/add_bin'); ?>",
                        data: {
                            line: line,
                            rack: rack,
                            level: level,
                            bin: bin,
                            bay: bay
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                let line = response.data[0].line_id;
                                let rack = response.data[0].rack_id;

                                Swal.fire('Success', response.message, 'success');
                                $('#addBinModal').modal('hide');
                                $('#rackInfoModal').modal('hide');

                                setTimeout(function() {
                                    $('#rack-cards-container').empty();
                                    $('#bayCheckboxContainer').empty();
                                    $('#level').val('');
                                    $('#rackInfoModal').modal('show');

                                    loadRacks(line, rack);
                                }, 200);
                            } else {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const lineContainer = document.getElementById('line-container');

        lineContainer.addEventListener('scroll', function() {
            if (lineContainer.scrollTop > 0) {
                lineContainer.classList.add('shadow-on-scroll');
            } else {
                lineContainer.classList.remove('shadow-on-scroll');
            }
        });
    });

    $(document).on('input', 'input[type="number"]', function() {
        let value = $(this).val();
        if (value < 0) {
            $(this).val(0);
        }
    });

    $(document).ready(function() {
        $('#rackInfoModal').on('hidden.bs.modal', function() {
            $('#generateQrWrapper').addClass('d-none');
            
            $('#documentNo, #vendorName, #vendorCode, #postingDate, #uploadDate, #prType, #receiveQty, #username').text('');

            global_locId = 0;
            bin_table.ajax.reload();
        });
    });

    function getLineDetails(doc_no, vendor_name, vendor_code, posting_date, upload_date, pr_type, remaining_qty, fullname) {

        $('#documentNo').text(doc_no);
        $('#vendorName').text(vendor_name);
        $('#vendorCode').text(vendor_code);
        $('#postingDate').text(posting_date);
        $('#uploadDate').text(upload_date);
        $('#prType').text(pr_type);
        $('#receiveQty').text(remaining_qty);
        $('#username').text(fullname);
   
    }
</script>