<?php
    require_once("@/sys/area.php");
    if(empty($_GET["id"])){
        header("Location: profile.php#myorders");
        die();
    }else{
        $order = $db->query("SELECT * FROM `orders` WHERE `public_id` = ".intval($_GET["id"]))->fetch(PDO::FETCH_ASSOC);
        if(empty($order)){
            header("Location: purchase.php");
            die();
        }else{
            if(!IsValidPaymentGateway($order["payment"])){
                header("Location: profile.php#myorders");
                die();
            }
        }
    }

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
                <div class="bg-image" style="background-image: url('assets/media/photos/stcheckout.png');">
                    <div class="bg-black-op-75">
                        <div class="content content-full text-center">
                            <div class="">
                                <h1 class="h2 font-w700 text-white mb-10">ORD.<?php echo $order["public_id"]; ?></h1>
                                <h2 class="h4 font-w400 text-white-op mb-0"><i class="fa fa-<?php echo OrderStatus($order["status"])["fa-icon"]; ?>"></i> <?php echo OrderStatus($order["status"])["name"]; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <?php
                        echo $pgateways[$order["payment"]]["func"]["Html"]($order);
                    ?>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <script>
            <?php
                if(function_exists($pgateways[$order["payment"]]["func"]["Scripts"])){
                     echo $pgateways[$order["payment"]]["func"]["Scripts"]();
                 } ?>
        </script>
    </body>
</html>