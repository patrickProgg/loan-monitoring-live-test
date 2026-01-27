<style>
    .flipclock {
        display: flex;
        align-items: flex-start;
    }

    .flip-segment {
        display: flex;
    }

    .colon {
        font-size: 80px;
        display: flex;
        align-items: center;
        padding-top: 5px;
        color: #333;
    }

    .ampm {
        font-size: 48px;
        margin: 40px 0 0 10px;
        display: inline-block;
    }

    ul.flip {
        position: relative;
        float: left;
        margin: 10px;
        padding: 0;
        width: 180px;
        height: 130px;
        font-size: 120px;
        font-weight: bold;
        line-height: 127px;
    }

    ul.flip li {
        float: left;
        margin: 0;
        padding: 0;
        width: 49%;
        height: 100%;
        perspective: 200px;
        list-style: none;
    }

    ul.flip li.d1 {
        float: right;
    }

    ul.flip li section {
        z-index: 1;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }

    ul.flip li section:first-child {
        z-index: 2;
    }

    ul.flip li div {
        z-index: 1;
        position: absolute;
        left: 0;
        width: 100%;
        height: 49%;
        overflow: hidden;
    }

    ul.flip li div .shadow {
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    ul.flip li div.up {
        transform-origin: 50% 100%;
        top: 0;
    }

    ul.flip li div.down {
        transform-origin: 50% 0%;
        bottom: 0;
    }

    ul.flip li div div.inn {
        position: absolute;
        left: 0;
        z-index: 1;
        width: 100%;
        height: 200%;
        color: #fff;
        text-shadow: 0 0 2px #fff;
        text-align: center;
        background-color: #F9F9F9;
        color: var(--bs-dark);
        border-radius: 6px;
    }

    ul.flip li div.up div.inn {
        top: 0;
    }

    ul.flip li div.down div.inn {
        bottom: 0;
    }

    /*---------------PLAY-----------------------*/
    body.play ul section.ready {
        z-index: 3;
    }

    body.play ul section.active {
        animation: index .5s .5s linear both;
        z-index: 2;
    }

    @keyframes index {
        0% {
            z-index: 2;
        }

        5% {
            z-index: 4;
        }

        100% {
            z-index: 4;
        }
    }

    body.play ul section.active .down {
        z-index: 2;
        animation: flipdown .5s .5s linear both;
    }

    @keyframes flipdown {
        0% {
            -webkit-transform: rotateX(90deg);
        }

        80% {
            -webkit-transform: rotateX(5deg);
        }

        90% {
            -webkit-transform: rotateX(15deg);
        }

        100% {
            -webkit-transform: rotateX(0deg);
        }
    }

    body.play ul section.ready .up {
        z-index: 2;
        animation: flipup .5s linear both;
    }

    @keyframes flipup {
        0% {
            -webkit-transform: rotateX(0deg);
        }

        90% {
            -webkit-transform: rotateX(0deg);
        }

        100% {
            -webkit-transform: rotateX(-90deg);
        }
    }

    /*----------------------SHADOW-------------------------*/
    @keyframes show {
        0% {
            opacity: 0;
        }

        90% {
            opacity: .10;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes hide {
        0% {
            opacity: 1;
        }

        80% {
            opacity: .20;
        }

        100% {
            opacity: 0;
        }
    }

    #container {
        transform: scale(0.3);
        transform-origin: right;
        padding: 0;
        margin-top: 5px;
        font-family: 'Digital-7', monospace;
    }

    .flip-clock-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
    }

    .page-title-box {
        height: 43px;
    }

    #chatBox .bg-light {
        background-color: #f1f1f1 !important;
    }

    #chatBox::-webkit-scrollbar {
        display: none;
    }

    #userListContent::-webkit-scrollbar {
        display: none;
    }

    #userListContent {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .box-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        grid-gap: 24px;
        padding-left: 0;
        padding-right: 0;
    }

    .box-info li {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        padding: 15px;
        padding-left: 22px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        grid-gap: 24px;
    }

    .box-info li:hover {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        transform: scale(1.05) translateY(-5px);
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .box-info li .bx {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        font-size: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box-info li .text h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--dark);
        margin-top: 5px;
    }

    .box-info li .text p {
        color: var(--dark);
    }

    .box-info .user-box {
        justify-self: start;
        width: 280px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
            <div id="container" class="ms-auto"></div>
        </div>
    </div>
</div>

<?php if (!empty($show_greeting)): ?>
    <div id="greeting-toast" class="alert alert-primary" style="transition: opacity 1s;">
        <h4><?= $greeting ?></h4>
    </div>
<?php endif; ?>

<div class="row mb-5">
    <ul class="box-info">

            <a href="<?= base_url(); ?>user" style="text-decoration: none; color: inherit;">
                <li style="border-bottom: 2px solid rgba(255, 99, 132, 1);">
                    <i class='bx bxs-group' style="background: rgba(255, 99, 132, 0.2); color: rgba(255, 99, 132, 1);"></i>
                    <span class="text">
                        <!-- <h3><?php echo $total_users; ?></h3> -->
                        <p>Users</p>
                    </span>
                </li>
            </a>

            <a href="<?= base_url(); ?>masterfile" style="text-decoration: none; color: inherit;">
                <li style="border-bottom: 2px solid rgba(255, 159, 64, 1);">
                    <i class='bx bx-barcode' style="background: rgba(255, 159, 64, 0.2); color: rgba(255, 159, 64, 1);"></i>
                    <span class="text">
                        <!-- <h3><?= $total_items ?></h3> -->
                        <p>Masterfile</p>
                    </span>
                </li>
            </a>

            <a href="<?= base_url(); ?>location" style="text-decoration: none; color: inherit;">
                <li style="border-bottom: 2px solid rgba(75, 192, 192, 1);">
                    <i class='bx bxs-map-pin' style="background: rgba(75, 192, 192, 0.2); color: rgba(75, 192, 192, 1);"></i>
                    <span class="text">
                        <!-- <h3><?= $total_txt_file ?></h3> -->
                        <p>Location</p>
                    </span>
                </li>
            </a>

            <a href="<?= base_url(); ?>receiving" style="text-decoration: none; color: inherit;">
                <li style="border-bottom: 2px solid rgba(153, 102, 255, 1);">
                    <i class='bx bxs-package' style="background: rgba(153, 102, 255, 0.2); color: rgba(153, 102, 255, 1);"></i>
                    <span class="text">
                        <!-- <h3><?= $total_uploadedTextFile ?></h3> -->
                        <p>Receiving</p>
                    </span>
                </li>
            </a>

            <a href="<?= base_url(); ?>releasing" style="text-decoration: none; color: inherit;">
                <li style="border-bottom: 2px solid rgba(54, 162, 235, 1);">
                    <i class='bx bxs-truck' style="background: rgba(54, 162, 235, 0.2); color: rgba(54, 162, 235, 1);"></i>
                    <span class="text">
                        <!-- <h3><?= $total_vendors ?></h3> -->
                        <p>Releasing</p>
                    </span>
                </li>
            </a>
    </ul>
</div>

<script>

</script>