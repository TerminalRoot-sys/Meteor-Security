<?php
    require_once("@/sys/area.php");
    $plan = GetPlans($_GET["id"]);
    if(empty($plan)){ header("Location: purchase.php"); die(); }
    $plan["expire"] = explode(" ", $plan["duration"]);
    $plan["expire"][0] = (empty(intval($plan["expire"][0])) ? "?" : intval($plan["expire"][0]));
    $plan["expire"][1] = (empty($plan["expire"][1]) ? "?" : 
    (substr($plan["expire"][1], strlen($plan["expire"][1]) - 1) == "s" && intval($plan["expire"][0]) <2) ?
    substr($plan["expire"][1],0, strlen($plan["expire"][1]) - 1) : $plan["expire"][1]
    );
    if($plan["stock"] > -1){
        $nsns = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `membership` = :planid AND (`expire` > :time OR `expire` = -1)");
        $nsns ->execute(array(":planid" => $plan["id"], ":time" => time()));
        $instock = $nsns->fetchColumn(0);
        $instock = $plan["stock"]-$instock;
        $instock = ($instock < 0 ? 0 : $instock);
    }else{ $instock = 999; }
    $methods = GetMethodsCountForLvl($plan["lvl"]);
    if(isset($_GET["coupon"])){
        $couponerror = FALSE;
        $sql = $db->prepare("SELECT * FROM `coupon` WHERE `code` = ?");
        $sql->execute(array($_GET["coupon"]));
        $coupon = $sql->fetch();
        if(empty($coupon)){ $couponerror = "Unknown or deleted coupon"; }
        else{
            if(is_json($coupon["data"])){
                $data = json_decode($coupon["data"], TRUE);
                if(!empty($data["userid"]) && $data["userid"] != $userinfo["id"]){
                    $couponerror = "Unable to apply this coupon code on your account";
                }elseif(!empty($data["expire"]) && $data["expire"] < time()){
                    $couponerror = "This coupon code is expired";
                }elseif(!empty($data["usage"])){
                    $sql = $db->prepare("SELECT COUNT(*) FROM `orders` WHERE `coupondata`");
                    $couponerror = "This coupon code is not active yet";
                }
            }else{ $couponerror = "Unable to have information about this coupon."; }
            if($couponerror !== FALSE){ unset($coupon); }
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
                <div class="content">
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="block block-rounded text-center">
                                <div class="block-header bg-mn-dark tewt-white">
                                    <h3 class="block-title text-white"><?php echo ChatMessage($plan["name"]); ?></h3>
                                </div>
                                <div class="block-content bg-primary-or">
                                    <div class="h1 font-w700 mb-10 text-white-op">$<?php echo $plan["price"] ?></div>
                                    <div class="h5 text-muted text-white-op"><?php echo ($plan["duration"] == -1 ? 'One-time' : $plan["expire"][0].' '.$plan["expire"][1]); ?></div>
                                </div>
                                <div class="block-content bg-primary-dark text-white-op">
                                    <p><strong><?php echo intval($methods); ?></strong> Methods</p>
                                    <p><strong><?php  echo intval($plan["maxtime"]); ?></strong> Seconds</p>
                                    <p><strong><?php  echo intval($plan["concurrents"]); ?></strong> Concurrents</p>
                                    <p><?php  echo ChatMessage($plan["power"]); ?></p>
                                    <p>
                                        <strong><?php  echo (!$plan["api"] > 0 ? 'No' : ''); ?></strong> Developer API Access
                                    </p>
                                    <?php
                                        if($site["settings"]["support"]["live"] || $site["settings"]["support"]["ticket"]){
                                    ?>
                                    <p><strong><?php echo ($site["settings"]["support"]["live"] == TRUE ? 'Live' : '').($site["settings"]["support"]["ticket"] == TRUE ? ($site["settings"]["support"]["live"] ? " & " : "").'Ticket' : ""); ?></strong> Support</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="block block-rounded text-center">
                                <div class="block-header bg-mn-dark tewt-white">
                                    <h3 class="block-title text-white"><i class="fa fa-list-alt"></i> Features</h3>
                                </div>
                                <div class="block bg-primary-or">
                                <ul class="nav nav-tabs nav-tabs-block bg-primary-or justify-content-center align-items-center" data-toggle="tabs" role="tablist">
                                    <?php
                                        if(!empty($plan["description"])){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#btabs-animated-fade-description">Description</a>
                                    </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a class="nav-link<?= (empty($plan["description"]) ? ' active' : '') ?>" href="#btabs-animated-fade-methods">Methods</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#btabs-animated-fade-pym">Payments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#btabs-animated-fade-net">Network</a>
                                    </li>
                                </ul>
                                <div class="block-content tab-content overflow-hidden bg-primary-dark">
                                    <?php
                                        if(!empty($plan["description"])){
                                    ?>
                                    <div class="tab-pane fade show active" id="btabs-animated-fade-description" role="tabpanel">
                                        <h4 class="font-w400">Description</h4>
                                        <p><?php echo ChatMessage($plan["description"]); ?></p>
                                    </div>
                                    <?php } ?>
                                    <div class="tab-pane fade<?= (empty($plan["description"]) ? ' show active' : '') ?>" id="btabs-animated-fade-methods" role="tabpanel">
                                        <h4 class="font-w400 text-white">Methods included with your plan</h4>
                                        <div class="border-t border-l border-r">
                                            <div class="input-group">
                                                <input type="text" class="form-control border-0 border-b border-r bg-mn-dark" style="border-radius: 0;" onkeyup="SearchMethod()" id="searchInput" placeholder="Search...">
                                                <div class="input-group-append">
                                                    <select class="form-control border-0 border-b border-l bg-mn-dark text-white" id="searchBy" onchange="SearchMethod()" style="border-radius: 0;">
                                                        <option value="0">Search by Name</option>
                                                        <option value="1">Search by Categorie</option>
                                                    </select>
                                                </div>
                                            </div>
                            
                                            <div class="table-responsive">
                                                <table class="table table-striped bg-mn-dark table-vcenter table-hover" id="searchTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Categorie</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-primary-dark">
                                                        <?php
                                                            $methods = $db ->query("SELECT * FROM `methods` WHERE `lvl` <= ".intval($plan["lvl"]))->fetchAll();
                                                            if(!empty($methods)){
                                                                foreach($methods as $method){
                                                                   $categorie = $db->query("SELECT * FROM `methods_categories` WHERE `id` = ".intval($method["cid"]))->fetch();
                                                                    if(empty($categorie)) $categorie["name"] = "Unknown";
                                                                    echo '
                                                                    <tr>
                                                                        <td class="text-center">'.ChatMessage($method["name"]).'</td>
                                                                        <td class="text-center">'.ChatMessage($categorie["name"]).'</td>
                                                                        <td><a href="methods.php?searchname='.urlencode(ChatMessage($method["name"])).'" target="_blank"><i class="fa fa-eye"></i> Details</a></td>
                                                                    </tr>';
                                                                }
                                                                unset($categorie);
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="btabs-animated-fade-pym" role="tabpanel">
                                        <h4 class="font-w400 text-white">Payment Methods</h4>
                                        <table class="table table-borderless table-vcenter mb-30">
                                            <tbody>
                                                <tr class="bg-mn-dark">
                                                    <th style="width: 50px;"></th>
                                                    <th>Payment Method</th>
                                                </tr>
                                                <?php
                                                    foreach($pgateways as $pgateway){
                                                ?>
                                                <tr>
                                                    <td class="table-success text-center">
                                                        <i class="fa fa-fw fa-unlock text-success"></i>
                                                    </td>
                                                    
                                                    <td class="text-left">
                                                        <strong style="text-decoration-line: underline"><?php echo ChatMessage($pgateway["name"]); ?></strong>: <?php echo $pgateway["description"]; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="btabs-animated-fade-net" role="tabpanel">
                                        <h4 class="font-w400 text-white">Network</h4>
                                        <h6 class="text-white"><?= $db->query("SELECT `name` FROM `networks` WHERE `id` = ".intval($plan["netid"]))->fetchColumn(0); ?></h6>
                                        <div class="row">
                                            <div class="col-12 col-xl-6">
                                                <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                                    <div class="block-content block-content-full clearfix">
                                                        <div class="float-left mt-10 d-none d-sm-block">
                                                            <i class="fa fa-server fa-3x text-muted"></i>
                                                        </div>
                                                        <div class="font-size-h3 font-w600"><?= $db->query("SELECT COUNT(*) FROM `servers` WHERE `osi` = 4 AND `network` = ".intval($plan["netid"]))->fetchColumn(0); ?></div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Layer 4 Servers</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                                    <div class="block-content block-content-full clearfix">
                                                        <div class="float-left mt-10 d-none d-sm-block">
                                                            <i class="fa fa-globe fa-3x text-muted"></i>
                                                        </div>
                                                        <div class="font-size-h3 font-w600"><?= $db->query("SELECT COUNT(*) FROM `servers` WHERE `osi` = 7 AND `network` = ".intval($plan["netid"]))->fetchColumn(0); ?></div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Layer 7 Servers</div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <small>* Some servers can be added or removed</small>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="block block-rounded bg-primary-dark text-center">
                                <div class="block-header bg-primary-dark tewt-white">
                                    <h3 class="block-title text-white"><i class="fa fa-shopping-cart"></i> Checkout</h3>
                                </div>
                                <div class="block-content bg-mn-dark">
                                    <div class="h5 p-0 m-0 text-muted text-white-op">Total due today</div>
                                    <?php if(!empty($coupon)){ echo '<small class="text-white"><del>$'.$plan["price"].'</del> (<span class="text-success">-'.$coupon["off"].'% OFF</span>)</small>'; } ?>
                                    <div class="h1 p-0 m-0 font-w700 mb-10 text-white-op">$<?php echo (empty($coupon) ? WalletFormat($plan["price"]) : WalletFormat(round(($plan["price"] - $plan["price"] * $coupon["off"] / 100), 2)) ) ?></div>
                                    <?php if(empty($coupon)){ echo '<u><a href="javascript:void(0);"onclick="$(\'#modal-coupon\').modal({ backdrop: \'static\', keyboard: false });" class="text-primary">Do you have a coupon ?</a></u>'; } ?>
                                </div>
                                <div id="response"></div>
                                <div class="block-content bg-primary-dark text-white-op">
                                    <?php
                                        if($plan["stock"] > -1 && $instock <= 0){
                                    ?>
                                    <button class="btn btn-danger btn-block" disabled><i class="fa fa-times"></i> OUT OF STOCK</button>
                                    <?php
                                        }else{
                                    ?>
                                    <button class="btn btn-success btn-block" id="doOrder" onclick="$('#modal-popout').modal({ backdrop: 'static', keyboard: false });" disabled><i class="fa fa-check"></i> Checkout</button>
                                    <?php  
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <div class="modal fade" id="modal-coupon" tabindex="-1" role="dialog" aria-labelledby="modal-coupon" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popout" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Validate coupon </h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <form class="block-content bg-mn-dark text-white" method="get">
                                <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
                                <div class="form-group">
                                    <input type="text" name="coupon" class="form-control" placeholder="Coupon code" />
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-alt-danger" data-dismiss="modal">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" onclick="this.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Applying your coupon...';" class="btn btn-alt-success">
                                            Apply coupon <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popout" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Hey ! Just 1 more step before continue... </h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content bg-mn-dark text-white">
                                <p>Please, complete the following captcha.</p>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6 text-center">
                                        <div id="captchaImage"></div>
                                        <input type="text" class="form-control bg-mn-dark text-center" id="captchaCode" placeholder="Captcha code" autofocus="false" />
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                                <div class="py-1"></div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-alt-success" data-dismiss="modal" onclick="Order();">
                                            <i class="fa fa-check"></i> Checkout
                                        </button>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                                <hr/>
                                <div>
                                    <span class="h4 text-white">- Why this verification ?</span>
                                    <br/>
                                    <span>
                                        We are not trying to bother you with our captcha verification, the captcha is primarily used to verify that you are not a robot. This both for the security of our site, and your account.
                                    </span>
                                </div>
                                <div class="py-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <script>
            function SearchMethod(prx = '') {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById(prx + "searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById(prx + "searchTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[document.getElementById(prx + "searchBy").value];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
        <?php
            if($plan["stock"] < 0 || ($plan["stock"] > -1 && $instock > 0 )){
        ?>
        <script>var plan = '<?php echo $plan["id"]; ?>'; var coupon = '<?php echo (!empty($_GET["coupon"]) ? htmlentities($_GET["coupon"]) : ""); ?>';</script>
        <?php if(!empty($couponerror)){  ?>
        <script>
            $(document).ready(function () {
                Codebase.helpers('notify', {
                    align: 'right',
                    from: 'top', 
                    type: 'danger',
                    message: '<?php echo $couponerror ?>'
                });
            });
            
        </script>
        <?php } ?>
        <script>
            var PageLoaded = false;
            $(document).ready(function () {
                PageLoaded = true;
                DoCaptcha();
                A_Disabled(false);
            });
            
            var gateway = 0;
            var token = 0;
            var btn = document.getElementById("doOrder");
            var response = document.getElementById("response");
            var captchacode = document.getElementById("captchaCode");
            function Order() {
                if (PageLoaded == true) {
                    response.innerHTML = '<div class="alert alert-info m-0"><i class="fa fa-spinner fa-spin"></i> Creating your order...</div>';
                    A_Disabled(true);
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            A_Disabled(false);
                            if (this.status == 200) {
                                response.innerHTML = "";
                                var jsonResponse = this.responseText;
                                if (IsValidJson(jsonResponse)) {
                                    jsonResponse = JSON.parse(jsonResponse);
                                    if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg')) {
                                        response.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg, 'm-0');
                                    }
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    }
                                }
                                DoCaptcha();
                            } else {
                                response.innerHTML = '<div class="alert alert-danger m-0">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>';
                            }
                            captchacode.value = "";
                        }
                    };
                    xmlhttp.open("POST", "@/inc/ajax/ask.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("to=walletorder&type=1&plan=" + plan + "&token=" + token + "&captchacode=" + captchacode.value + "&gate=" + gateway + "&coupon=" + coupon);
                }
            }

            function A_Disabled(state) {
                btn.disabled = state;
                captchacode.disabled = state;
            }

            function DoCaptcha() {
                A_Disabled(true);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('gate') && jsonResponse.hasOwnProperty('dataimg')) {
                                    var imagedata = jsonResponse.dataimg;
                                    if (imagedata.startsWith("data:image/png;")) {
                                        A_Disabled(false);
                                        document.getElementById("captchaImage").innerHTML = '<img src="' + imagedata + '" alt="Captcha" />';
                                        gateway = jsonResponse.gate;
                                        token = jsonResponse.token;
                                    } else { response.innerHTML = '<div class="alert alert-danger m-0">Unexpected captcha image, please try-again or reload your page.</div>'; }
                                } else { response.innerHTML = '<div class="alert alert-danger m-0">An error has occured. Please try agin.</div>'; }
                            } else { response.innerHTML = '<div class="alert alert-danger m-0">Unexpected reply, please try-again or reload your page.</div>'; }
                        } else { response.innerHTML = '<div class="alert alert-danger m-0">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>'; }
                    }
                };
                xmlhttp.open("GET", "@/inc/gateway/key.php", true);
                xmlhttp.send();
            }
        </script>
        <?php
            }
        ?>
    </body>
</html>