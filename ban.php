<?php
    require_once("@/sys/exec.php");
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include("@/inc/head.php"); ?>
    <body>
        <div id="page-container" class="main-content-boxed bg-dark">
            <main id="main-container">
                <div class="bg-dark bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
                    <div class="row mx-0 justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-5">
                            <div class="content content-full overflow-hidden">
                                <div class="py-30 text-center">
                                    
                                    <h1 class="h4 font-w700 mt-30 mb-10">
                                        <a class="link-effect font-w700" href="index.php">
                                            <i class="fa fa-ban text-danger"></i>
                                            <span class="font-size-xl">You got banned</span>
                                        </a>
                                    </h1>

                                    <h2 class="h5 font-w400 text-muted mb-0">That's bad !</h2>
                                </div>
                                <form class="js-validation-signin" method="post">
                                    <div class="block block-themed block-rounded block-shadow bg-mn-dark">
                                        <div class="block-header bg-primary-darker">
                                            <h3 class="block-title text-center"><i class="fa fa-user-secret"></i> Account Error</h3>
                                        </div>
                                        <div class="block-content">
                                            <div id="response"></div>
                                            <div>
                                                <span><b>Your account has been suspended.:</b></span>
                                                <ul>
                                                    <li>No respect of the terms and conditions of use</li>
                                                    <li>This account is associed to suspecious activities</li>
                                                    <li>You already hold a banned account</li>
                                                    <li>And moreover...</li>
                                                </ul>
                                                <div class="text-center">
                                                    <a class="btn btn-danger" href="signout.php"><i class="fa fa-sign-out-alt fa-rotate-180"></i> Signout</a>
                                                </div><br/>
                                                <span><b>It is not advisable to try to create new account from our website.</b> Our algorithm may track your activity to ban your future activities.</span><br/>
                                                <br><br/>
                                                <small>In case of error, appeal to unban:</small>
                                                <ul>
                                                    <li><small>Contact us by Email</small></li>
                                                    <li><small>Contact us by Discord</small></li>
                                                </ul>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
        <?php include("@/inc/scripts.php"); ?>

    </body>
</html>