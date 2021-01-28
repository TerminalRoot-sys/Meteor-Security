<?php
    require_once("@/sys/area.php");
    if($site["settings"]["wallet"]["enabled"] != TRUE){
        die();
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
            <main id="main-container" style="min-height: 200px;">
                <div class="content">
                    <?php 
                        if(empty($_GET["add"]) or empty($_GET["method"]) or !filter_var($_GET["add"], FILTER_VALIDATE_FLOAT) or empty($pgateways[$_GET["method"]])){ ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white text-center">
                                        <i class="fa fa-wallet"></i> Wallet
                                    </h3>
                                </div>
                                <div class="block-content text-center text-white p-0">
                                    <h3 class="text-white">$<?php echo WalletFormat($userinfo["wallet"]); ?></h3>
                                </div>
                                
                                <div class="form-group text-center">
                                        <button class="btn btn-default" onclick="$('#modal-payment').modal({ backdrop: 'static', keyboard: false });">
                                            <i class="fa fa-plus-circle"></i> Deposit
                                        </button>
                                    <div class="py-1"></div>
                                </div>
                            </div>
                            <div class="block block-rounded bg-mn-dark">
                                <small><span class="text-danger">*</span> All payments are made in USD (United States Dollar)</small><br/>
                                <small><span class="text-danger">*</span> Your wallet funds can be used to order only on our website</small><br/>
                                <small><span class="text-danger">*</span> Except in case of closure, you cannot withdraw your wallet</small><br/>
                            </div>
                            
                        </div>
                        <div class="col-md-8">
                            <div class="block block-rounded bg-dark">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white"><i class="fa fa-archive"></i> History of operations</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th class="text-right">Value</th>
                                            <tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                                $operations = GetOperations();
                                                foreach($operations["data"] as $operation){
                                                    echo '
                                            <tr>
                                                <td>
                                                    OP.'.$operation["public_id"].'
                                                </td>
                                                <td>
                                                    <span class="badge badge-'.OperationStatus($operation["status"])["type"].'">'.OperationStatus($operation["status"])["name"].'</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    '.$operation["description"].'
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    '.date("M d, Y h:ia", $operation["date"]).'
                                                </td>
                                                <td class="text-right">
                                                    <span class="text-right '.($operation["amount"] < 0 ? "text-danger " : "text-success ").'font-w600">'.($operation["amount"] >= 0 ? "+ $".$operation["amount"] : "- $".(substr($operation["amount"], 1))).'</span>
                                                </td>
                                            </tr>
                                                    ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }else{ 
                           echo $pgateways[$_GET["method"]]["func"]["Client"]();
                        }
                    ?>
                </div>
            </main>
            <div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="modal-payment" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-popout modal-sm" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Load your wallet</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content bg-mn-dark text-white">
                                <form method="get">
                                    <div class="form-group">
                                        <label>Amount (USD$):</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text input-group-text-alt">
                                                    <i class="si si-wallet"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control form-control-alt text-center" id="payment_amount" name="add" placeholder="Montant désiré" step="0.01" value="5.00">
                                            <div class="input-group-append">
                                                <span class="input-group-text input-group-text-alt">
                                                    <i class="fa fa-hand-holding-usd"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Payment method:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text input-group-text-alt">
                                                    <i class="far fa-building"></i>
                                                </span>
                                            </div>
                                            <select class="form-control form-control-alt" style="text-align-last: center; text-align: center; -ms-text-align-last: center; -moz-text-align-last: center;" id="payment_method" name="method">
                                                <?php
                                                    foreach($pgateways as $pid=>$pgateway){
                                                        if(empty($firstgate)){ $firstgate = $pid; }
                                                        echo '<option value="'.$pid.'">'.$pgateway["name"].'</option>';
                                                    }
                                                ?>
                                            </select> 
                                            <div class="input-group-append">
                                                <span class="input-group-text input-group-text-alt">
                                                    <i class="fa fa-sign-in-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-block"><sup>+<i class="fa fa-dollar-sign"></i></sup> <i class="fa fa-wallet"></i> Continue <i class="fa fa-arrow-circle-right"></i></button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
    </body>
</html>