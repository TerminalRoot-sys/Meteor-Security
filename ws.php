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
                                            <i class="fa fa-warning text-warning"></i>
                                            <span class="font-size-xl">Security Warning</span>
                                        </a>
                                    </h1>

                                    <h2 class="h5 font-w400 text-muted mb-0">That's bad !</h2>
                                </div>
                                <form class="js-validation-signin" method="post">
                                    <div class="block block-themed block-rounded block-shadow bg-mn-dark">
                                        <div class="block-header bg-primary-darker">
                                            <h3 class="block-title text-center"><i class="fa fa-user-secret"></i> Session Error</h3>
                                        </div>
                                        <div class="block-content">
                                            <div id="response"></div>
                                            <div>
                                                <span><b>Something went wrong with your session. This error can come for several reasons:</b></span>
                                                <ul>
                                                    <li>You started a new session from another device</li>
                                                    <li>One or more data of your session have changed</li>
                                                    <li>You are currently hijacking this session</li>
                                                    <li>And moreover...</li>
                                                </ul>
                                                <div class="text-center">
                                                    <b><code>NEW SESSION HAS ESTABLISHED FROM THIS ACCOUNT</code></b><br/>
                                                    <a class="btn btn-danger" href="signout.php"><i class="fa fa-sign-out-alt fa-rotate-180"></i> Signout</a>
                                                </div><br/>
                                                <span><b>Please, fill free to contact the support to report this abnormal activity.</b> Your account is not banned, you can sign in again now.</span><br/>
                                                <br><br/>
                                                <small>Some security advices:</small>
                                                <ul>
                                                    <li><small>Change regularly your account password</small></li>
                                                    <li><small>Never share any account information</small></li>
                                                    <li><small>Contact the support if you have doubts about your account security</small></li>
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