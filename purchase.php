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
                <div class="content">
                    <h1 class="text-center text-white">Our offers</h1>
                    <?php
                        $stocklimitexist = $db->query("SELECT COUNT(*) FROM `plans` WHERE `stock` <> -1")->fetchColumn(0);
                        $offers_categories = $db->query("SELECT * FROM `plans_categories` WHERE `onsale` > 0")->fetchAll();
                        foreach($offers_categories as $offers_categorie){
                            if(count($offers_categories) != 1) echo '<h2 class="content-heading p-0 text-white">'.ChatMessage($offers_categorie["name"]).'</h2>';
                            echo '<div class="row">';
                            $offers = $db->query("SELECT * FROM `plans` WHERE `onsale` > 0")->fetchAll();
                            foreach($offers as $offer){
                                if($offer["cid"] != $offers_categorie["id"]){ continue; }
                                $offer["expire"] = explode(" ", $offer["duration"]);
                                $offer["expire"][0] = (empty(intval($offer["expire"][0])) ? "?" : intval($offer["expire"][0]));
                                $offer["expire"][1] = (empty($offer["expire"][1]) ? "?" : 
                                (substr($offer["expire"][1], strlen($offer["expire"][1]) - 1) == "s" && intval($offer["expire"][0]) <2) ?
                                substr($offer["expire"][1],0, strlen($offer["expire"][1]) - 1) : $offer["expire"][1]
                                );
                                $methods = GetMethodsCountForLvl($offer["lvl"]);
                                if($offer["stock"] > -1){
                                    $nsns = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `membership` = :planid AND (`expire` > :time OR `expire` = -1)");
                                    $nsns ->execute(array(":planid" => $offer["id"], ":time" => time()));
                                    $instock = $nsns->fetchColumn(0);
                                    $instock = $offer["stock"]-$instock;
                                    $instock = ($instock < 0 ? 0 : $instock);
                                }
                    ?>
                        <div class="col-md-6 col-xl-3">
                            <a class="block block-rounded text-center" href="order.php?id=<?php echo $offer["id"]; ?>">
                                <div class="block-header bg-mn-dark tewt-white">
                                    <h3 class="block-title text-white"><?php echo ChatMessage($offer["name"]); ?></h3>
                                </div>
                                <div class="block-content bg-primary-or">
                                    <div class="h1 font-w700 mb-10 text-white-op">$<?= intval($offer["price"]); ?></div>
                                    <div class="h5 text-muted text-white-op <?php echo ($stocklimitexist > 0 ? 'mb-0' : '') ?>"><?php echo ($offer["duration"] == -1 ? 'One-time' : $offer["expire"][0].' '.$offer["expire"][1]); ?></div>
                                    <?php
                                        if($stocklimitexist > 0){
                                    ?>
                                    <span class="h7 text-muted"><?php echo ($offer["stock"] > -1 ? $instock : 'Unlimited') ?> in stock</span>   
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="block-content bg-primary-dark text-white-op">
                                    <p><strong><?php echo intval($methods); ?></strong> Methods</p>
                                    <p><strong><?php echo intval($offer["maxtime"]); ?></strong> Seconds</p>
                                    <p><strong><?php echo intval($offer["concurrents"]); ?></strong> Concurrents</p>
                                    <p><?php echo ChatMessage($offer["power"]); ?></p>
                                    <p>
                                        <strong><?php  if($offer["api"] > 0) { ?> <i class="fa fa-check text-success"></i><?php }else{ ?><i class="fa fa-times text-danger"></i><?php } ?></strong> API Developper
                                    </p>
                                    <?php
                                        if($site["settings"]["support"]["live"] || $site["settings"]["support"]["ticket"]){
                                    ?>
                                    <p><strong><?php echo ($site["settings"]["support"]["live"] == TRUE ? 'Live' : '').($site["settings"]["support"]["ticket"] == TRUE ? ($site["settings"]["support"]["live"] ? " & " : "").'Ticket' : ""); ?></strong> Support</p>
                                    <?php } ?>
                                </div>
                                <?php
                                    if($offer["stock"] > -1 && $instock <= 0){
                                ?>
                                <div class="block-content block-content-full bg-mn-dark">
                                    <span class="btn btn-hero btn-sm btn-rounded btn-noborder btn-danger"><i class="fa fa-times"></i> OUT OF STOCK</span>
                                </div>
                                <?php
                                    }else{
                                ?>
                                <div class="block-content block-content-full bg-mn-dark">
                                    <span class="btn btn-hero btn-sm btn-rounded btn-noborder btn-primary">Order Now</span>
                                </div>
                                <?php
                                    }
                                ?>
                            </a>
                        </div>
                    <?php
                            }
                            echo ' </div>';
                        }
                    ?>
                </div>
            </main>

            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
    </body>
</html>