<?php
    require_once("@/sys/exec.php");
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include("@/inc/head.php"); ?>
    <body class="bg-dark">
        <div id="page-container" class="main-content-boxed bg-dark">
            <main id="main-container">
                <div class="bg-dark bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
                    <div class="row mx-0 justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-4">
                            <div class="content content-full overflow-hidden">
                                <div class="py-30 text-center">
                                    
                                    <h1 class="h4 font-w700 mt-30 mb-10">
                                        <a class="link-effect font-w700" href="index.html">
                                            <i class="fa fa-bolt text-primary"></i>
                                            <span class="font-size-xl"><?php echo $site["name"]; ?></span>
                                        </a>
                                    </h1>

                                    <h2 class="h5 font-w400 text-muted mb-0"><?php echo (rand(0, 3) == 1 ? "It's a bird ? It's a plane ? No it's YOU !" : (rand(0, 2) == 1 ? "Happy to see you join us today!" : (rand(0, 1) == 0 ? "The best have choosed the best!" : "You are looking great today!"))); ?></h2>
                                </div>
                                <div id="form-Register">
                                    <div class="block block-themed block-rounded block-shadow bg-mn-dark">
                                        <div class="block-header bg-primary-darker">
                                            <h3 class="block-title"><i class="fa fa-sign-in-alt"></i> Please Sign Up</h3>
                                            <div class="block-options">
                                                <a href="signin.php" class="btn-block-option">
                                                    <i class="si si-user"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <div id="response"></div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Username</label>
                                                    <input type="text" class="form-control bg-primary-darker text-white border-0" id="username" placeholder="Enter your username" name="login-username" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Email</label>
                                                    <input type="email" class="form-control bg-primary-darker text-white border-0" id="email" placeholder="Enter your email" name="login-email" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Password</label>
                                                    <input type="password" class="form-control bg-primary-darker text-white border-0" id="password" placeholder="Enter your password" name="login-password" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Repeat password</label>
                                                    <input type="password" class="form-control bg-primary-darker text-white border-0" id="cpassword" placeholder="Enter your password" name="login-password" required>
                                                </div>
                                            </div>
                                            <div class="form-group bg-dark pb-20 row">
                                                <div class="col-12">
                                                    <div class=" text-center">
                                                        <label for="login-password">Captcha</label>
                                                    </div>
                                                    <div id="captchaImage" class="text-center">
                                                        <h5 class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i><br>Loading</h5>
                                                    </div>
                                                    <input type="text" class="form-control bg-primary-darker text-white border-0 text-center" id="captchaCode" placeholder="Enter the image code" name="captcha" required>
                                                    <small>Enter the exact letters on the image</small>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-sm-6 d-sm-flex align-items-center push">
                                                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 text-sm-right push">
                                                    <button onclick="registerUser()" class="btn btn-block btn-alt-primary" id="doRegistration">
                                                        <i class="si si-login mr-10"></i> Sign Up
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-primary-darker">
                                            <div class="form-group text-center">
                                                <a class="link-effect mr-10 mb-5 d-inline-block" href="terms.php">
                                                    <i class="fa fa-book-open mr-5"></i> Read Terms
                                                </a>
                                                <a class="link-effect mr-10 mb-5 d-inline-block" href="signin.php">
                                                    <i class="fa fa-sign-in-alt mr-5"></i> Sign In
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <script>
            $("#form-Register").keydown(function (e) {
                if (e.keyCode == 13) {
                    registerUser();
                }
            });
        </script>
        <script>
            var PageLoaded = false;
            $(document).ready(function () {
                PageLoaded = true;
                DoCaptcha();
            });
            var gateway = 0;
            var token = 0;
            var btn = document.getElementById("doRegistration");
            var username = document.getElementById("username");
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var cpassword = document.getElementById("cpassword");
            var response = document.getElementById("response");
            var captchacode = document.getElementById("captchaCode");
            function registerUser() {
                if (PageLoaded == true) {
                    response.innerHTML = '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Creating your account...</div>';
                    A_Disabled(true);
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            A_Disabled(false);
                            if (this.status == 200) {
                                response.innerHTML = "";
                                var jsonResponse = this.response;
                                if (IsValidJson(jsonResponse)) {
                                    jsonResponse = JSON.parse(jsonResponse);
                                    if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg')) {
                                        response.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg);
                                    }
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    }
                                }
                                DoCaptcha();
                            } else {
                                response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>';
                            }
                            captchacode.value = "";
                        }
                    };
                    xmlhttp.open("POST", "@/inc/ajax/ask.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("to=register&username=" + username.value + "&email=" + email.value + "&password=" + password.value + "&cpassword=" + cpassword.value + "&captchacode=" + captchacode.value + "&gateway=" + gateway);
                }
            }

            function A_Disabled(state) {
                username.disabled = state;
                email.disabled = state;
                password.disabled = state;
                cpassword.disabled = state;
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
                                    } else { response.innerHTML = '<div class="alert alert-danger">Unexpected captcha image, please try-again or reload your page.</div>'; }
                                } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Please try agin.</div>'; }
                            } else { response.innerHTML = '<div class="alert alert-danger">Unexpected reply, please try-again or reload your page.</div>'; }
                        } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>'; }
                    }
                };
                xmlhttp.open("GET", "@/inc/gateway/key.php", true);
                xmlhttp.send();
            }
        </script>

    </body>
</html>