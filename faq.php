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
            <main id="main-container" style="min-height: 260px;">
                <div class="content">
                    <h2 class="content-heading p-0 text-white">FAQ: Frequently Asked Questions</h2>
                    <?php
                        $categories = $db->query("SELECT * FROM `faq_categories` WHERE `visible` > 0 ORDER BY `order` ASC");
                        while($categorie = $categories->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <div class="block block-rounded bg-primary-dark">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white">
                                        '.ChatMessage($categorie["name"]).'
                                    </h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option">
                                            <i class="si si-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <div id="faq'.$categorie["id"].'" role="tablist" aria-multiselectable="true">
                                    <div class="block block-bordered block-rounded mb-5 border-0 text-white bg-primary-dark-op">
                            ';
                            $faqs = $db->query("SELECT * FROM `faq` WHERE `cid` = ".intval($categorie["id"]));
                            while($faq=$faqs->fetch()){
                                echo '
                                    <div class="block-header bg-mn-dark" role="tab" id="faq'.$categorie["id"].'_h'.$faq["id"].'">
                                        <a class="font-w600 collapsed" data-toggle="collapse" href="#faq'.$categorie["id"].'_q'.$faq["id"].'" aria-expanded="false" aria-controls="faq'.$categorie["id"].'_q'.$faq["id"].'">'.ChatMessage($faq["question"]).'</a>
                                    </div>
                                    <div id="faq'.$categorie["id"].'_q'.$faq["id"].'" class="collapse" role="tabpanel" aria-labelledby="faq'.$categorie["id"].'_h'.$faq["id"].'" data-parent="#faq'.$categorie["id"].'" style="">
                                        <div class="block-content border-t border-l border-r border-b">
                                            <p>'.ChatMessage($faq["answer"], TRUE).'</p>
                                        </div>
                                    </div>
                                    ';
                            }
                            echo '</div>
                                    </div>
                                    </div>
                                        </div>';
                        }
                    ?>
                </div>
                <div class="bg-mn-dark">
                    <div class="content">
                        <div class="py-50 nice-copy text-center">
                            <h3 class="font-w700 mb-10 text-white">Did you find an answer to your question?</h3>
                            <p>If no, don't worry, you can open a new support ticket right now to got an answer from our support ASAP !</p>
                            <a class="btn btn-hero btn-noborder btn-lg btn-rounded btn-primary" href="support.php"><i class="fa fa-ticket-alt"></i> Open Ticket</a>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
    </body>
</html>