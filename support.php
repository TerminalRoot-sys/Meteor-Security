<?php
    require_once("@/sys/area.php");
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include("@/inc/head.php"); ?>
    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-fixed page-header-fixed page-header-glass main-content-boxed bg-primary-darker text-body-color-light">
            <?php
                include("@/inc/nav.php");
                include("@/inc/header.php");
            ?>
            <main id="main-container">
                <div class="bg-primary">
                    <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content content-top text-center">
                            <div class="py-10">
                                <h1 class="font-w700 text-white mb-10">Get In Touch</h1>
                                <h2 class="h4 font-w400 text-white-op">Do you have any questions?</h2>
                                <h3 class="h5 font-w400 text-white-op">Email us: contact@takedown.pw or open support ticket</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="ticket.php" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> New ticket</a>
                            <div class="py-1"></div>
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-dark">
                                    <h3 class="block-title text-white">
                                        Your support ticket
                                    </h3>
                                </div>
                                <div class="block-content">
                                    <!-- If you put a checkbox in thead section, it will automatically toggle all tbody section checkboxes -->
                                    <table class="js-table-checkable table table-hover table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Categorie</th>
                                                <th class="d-none d-sm-table-cell" style="width: 15%;">Status</th>
                                                <th class="d-none d-sm-table-cell" style="width: 20%;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $tickets = GetTickets();
                                                if(!empty($tickets)){
                                                    foreach($tickets as $ticket){
                                                        echo '
                                                        <tr class="">
                                                            <td>
                                                                <a href="ticket.php?id='.$ticket["publicid"].'">
                                                                    <p class="font-w600 mb-10">'.$ticket["subject"].'</p>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <p class="font-w600 mb-10">'.GetTicketCategories($ticket["categorie"])["name"].'</p>
                                                            </td>
                                                            <td class="d-none d-sm-table-cell">
                                                                <span class="badge badge-'.TicketStatus($ticket["status"])["type"].'">
                                                                <i class="fa fa-'.TicketStatus($ticket["status"])["fa-icon"].'"></i>
                                                                '.TicketStatus($ticket["status"])["name"].'
                                                                </span>
                                                            </td>
                                                            <td class="d-none d-sm-table-cell">
                                                                <em class="text-muted">'.date("F m, Y - h:ia", $ticket["date"]).'</em>
                                                            </td>
                                                        </tr>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
    </body>
</html>