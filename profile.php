<?php
    require_once("@/sys/area.php");

    // CRSF sur page;
    // Generation dun num entre 0 et 99999 pour la page; 
    // Depuis @/sec/gtoken.php?key=[NUM]&token=[MD5] nouveau md5 pour num
    // Depuis @/sec/vtoken.php?key=[NUM]&token=[MD5] verifier si oui ou non c bon
    // .:!:. Num expirant après 10min même page .:!:. 
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
            <main id="main-container" style="min-height: 200px;">
                <div class="bg-image bg-image-bottom">
                    <div class="bg-primary-dark-op py-10">
                        <div class="content content-full text-center">
                            <div class="mb-10">
                                <a class="img-link" href="be_pages_generic_profile.html">
                                    <img class="img-avatar img-avatar-thumb" src="assets/media/avatars/avatar15.png" alt="">
                                </a>
                            </div>
                            <h1 class="h3 text-white font-w700 mb-10"><?php echo $userinfo["username"]; ?></h1>
                            <h2 class="h5 text-white-op">
                                Member since <?php echo time_elapsed_string(json_decode($userinfo["datareg"], TRUE)["unix_timestamp"]); ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="content">
                    
                    <div class="row">

                        <div class="col-md-4">
                            <?php if($site["settings"]["wallet"]["enabled"] == TRUE){ ?>
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white text-center">
                                        <i class="fa fa-wallet"></i> Wallet
                                    </h3>
                                </div>
                                <div class="block-content text-center text-white p-0">
                                    <h3 class="text-white">$<?php echo WalletFormat($userinfo["wallet"]); ?></h3>
                                </div>
                                <a href="wallet.php" class="btn btn-square btn-block btn-primary"><i class="fa fa-tasks"></i> Manage</a>
                            </div>
                            <?php } ?>
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-user-tie"></i> Your Membership
                                    </h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped bg-mn-dark">
                                        <tbody>
                                            <tr>
                                                <th>Name:</th>
                                                <td class="text-right">Alpha</td>
                                            </tr>
                                            <tr>
                                                <th>Concurrents:</th>
                                                <td class="text-right">1</td>
                                            </tr>
                                            <tr>
                                                <th>Max Time:</th>
                                                <td class="text-right">120sec</td>
                                            </tr>
                                            <tr>
                                                <th>Duration:</th>
                                                <td class="text-right">1 Month</td>
                                            </tr>
                                            <tr>
                                                <th>Expiration:</th>
                                                <td class="text-right">Jul 30, 2019 10:55pm</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="" class="btn btn-square btn-block btn-primary"><i class="fa fa-store-alt"></i> Purchase</a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-key"></i> Change your password
                                    </h3>
                                </div>
                                <div class="block-content block-content-full bg-primary-dark">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>New Password:</label>
                                            <input type="password" class="form-control text-center bg-mn-dark">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Current Password:</label>
                                            <input type="password" class="form-control text-center bg-mn-dark">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-exclamation-triangle"></i> Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="block block-rounded">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-envelope"></i> Change your email
                                    </h3>
                                </div>
                                <div class="block-content block-content-full bg-primary-dark">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>New Email:</label>
                                            <input type="email" class="form-control text-center bg-mn-dark">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Current Password:</label>
                                            <input type="password" class="form-control text-center bg-mn-dark">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-edit"></i> Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <section id="myorders">
                                <div class="block block-rounded bg-primary-dark">
                                    <div class="block-header block-header-default bg-mn-dark">
                                        <h3 class="block-title text-white">
                                            <i class="fa fa-tasks"></i> Your orders
                                        </h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped bg-mn-dark table-vcenter text-center">
                                            <thead>
                                                <tr>
                                                    <td>ID</td>
                                                    <td>Status</td><!-- Status: Payé, En cours, Annuler, Inmpayé -->
                                                    <td>Amount</td>
                                                    <td>Date</td>
                                                    <td></td><!-- Options: Payer/Supprimer, Supprimer -->
                                                </tr>
                                            </thead>
                                            <tbody class="bg-primary-dark">
                                                <?php
                                                    foreach(GetOrders() as $order){
                                                        $price = explode(".", WalletFormat($order["amount"]))[0];
                                                        $price.="<sup>.".explode(".", WalletFormat($order["amount"]))[1]."</sup>";
                                                        if(OrderStatus($order["status"])["name"] == "Expired" || OrderStatus($order["status"])["name"] == "Paid"){ $abtn = '<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>'; }
                                                        elseif(OrderStatus($order["status"])["name"] == "Unpaid" || OrderStatus($order["status"])["name"] == "Processing..."){ $abtn = '<a href="checkout.php?id='.$order["public_id"].'" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Open</a>'; }
                                                        echo '
                                                        <tr>
                                                            <td><a class="font-w600" href="checkout.php?id='.$order["public_id"].'">ORD.'.$order["public_id"].'</a></td>
                                                            <td><span class="badge badge-'.OrderStatus($order["status"])["type"].'">'.OrderStatus($order["status"])["name"].'</span></td>
                                                            <td><sup class="text-white">US</sup>$'.$price.'</td>
                                                            <td><small class="text-white">'.date("F d, Y", $order["date"]).'<br/>'.date("h:ia", $order["date"]).'</small></td>
                                                            <th>'.$abtn.'</th>
                                                        </tr>
                                                        ';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
    </body>
</html>