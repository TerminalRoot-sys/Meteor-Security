<?php
    require_once("@/sys/area.php");
    if($site["settings"]["hub"]["layer7"] != TRUE && !$userinfo["rank"] > 0){
        header("Location: index.php");
        die("Web Stresser under maintenance");
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
            <?php if(!empty($userinfo["membership"])){ ?>
            <main id="main-container" style="min-height: 260px;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-mn-dark border-b">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-rocket"></i> Start Attack
                                    </h3>
                                </div>
                                <div class="block-content">
                                    <div id="response"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>URL Address:</label>
                                                <input type="text" class="form-control bg-primary-darker text-white border-0" id="host" placeholder="Ex: http://localhost.com/" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Time (sec):</label>
                                                <input type="text" class="form-control bg-primary-darker text-white border-0" id="time" placeholder="Ex: 120" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Method:</label>
                                                <select class="form-control bg-primary-darker text-white border-0" id="method">
                                                    <?php
                                                        $cmethods = GetMethods(7);
                                                        if(!empty($cmethods) || $cmethods !== FALSE){
                                                            foreach($cmethods as $cmethod){
                                                                echo '<optgroup label="'.$cmethod["name"].'">';
                                                                foreach($cmethod["methods"] as $method){
                                                                    echo '<option value="'.$method["id"].'">'.$method["name"].'</option>';
                                                                }
                                                                echo '</optgroup>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="" id="token" />
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" id="doAttack" onclick="startAttack()"><i class="fa fa-rocket"></i> Start Attack</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="block block-rounded bg-primary-dark">
                                <div class="block-header block-header-default bg-mn-dark border-b">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-spinner fa-spin"></i> Running Attacks
                                    </h3>
                                </div>
                                <div id="result2"></div>
                                <div class="table-responsive">
                                     <table class="table table-stripped table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col" style="width: 25%;">IP</th>
                                                <th scope="col" style="width: 20%;">Time</th>
                                                <th scope="col" style="width: 30%;">Method</th>
                                                <th scope="col" style="width: 10%;"></th>
                                            </tr>
                                        </thead>
                                         <tbody class="text-center" id="attacksbox">
                                         </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php }else{ include("@/inc/subscribe.php"); } ?>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <script>
            $("#form-Attack").keydown(function (e) {
                if (e.keyCode == 13) {
                    startAttack();
                }
            });

            var PageLoaded = false;
            $(document).ready(function () {
                PageLoaded = true;
                DoToken();
            });
            var gateway = 0;
            var btn = document.getElementById("doAttack");
            var host = document.getElementById("host");
            var time = document.getElementById("time");
            var method = document.getElementById("method");
            var response = document.getElementById("response");
            var token = document.getElementById("token");
            function startAttack() {
                if (PageLoaded == true) {
                    response.innerHTML = '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Starting your attack...</div>';
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
                                        Codebase.helpers('notify', {
                                            align: 'right',             // 'right', 'left', 'center'
                                            from: 'top',                // 'top', 'bottom'
                                            type: jsonResponse.msg_type,               // 'info', 'success', 'warning', 'danger'
                                            message: jsonResponse.msg
                                        });
                                    }
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    }
                                }
                                DoToken();
                            } else {
                                response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>';
                            }
                        }
                    };
                    xmlhttp.open("POST", "@/inc/ajax/attack.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("action=layer7&host=" + host.value + "&time=" + time.value + "&method=" + method.value);
                }
            }

            function A_Disabled(state) {
                host.disabled = state;
                time.disabled = state;
                method.disabled = state;
                btn.disabled = state;
            }

            function DoToken() {
                A_Disabled(true);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('gate') && jsonResponse.hasOwnProperty('token')) {
                                    A_Disabled(false);
                                    token.value = jsonResponse.token;
                                    gateway = jsonResponse.gate;
                                } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Please try agin.</div>'; }
                            } else { response.innerHTML = '<div class="alert alert-danger">Unexpected reply, please try-again or reload your page.</div>'; }
                        } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>'; }
                    }
                };
                xmlhttp.open("GET", "@/inc/gateway/key.php", true);
                xmlhttp.send();
            }

            $(document).ready(function () {
                GetRunningAttacks();
            });
            function GetRunningAttacks() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.responseText;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('go')) {
                                    window.location.href = jsonResponse.go;
                                } else if (jsonResponse.hasOwnProperty('attacks')) {
                                    for (i in jsonResponse.attacks) {
                                        UpdateAttacks(jsonResponse.attacks[i].id);
                                    }
                                }
                            }
                        }
                    }
                };
                xmlhttp.open("GET", "@/inc/ajax/attack.php?action=running&layer=7&ids", true);
                xmlhttp.send();
                setTimeout(GetRunningAttacks, 2000);
            }
            function UpdateAttacks(id) {
                if (id == 0 || id == null) { return false; }
                if (InitRow(id) === true) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                var jsonResponse = this.responseText;
                                if (IsValidJson(jsonResponse)) {
                                    jsonResponse = JSON.parse(jsonResponse);
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    } else if (jsonResponse.hasOwnProperty('attack')) {
                                        document.getElementById("ipfor" + id).innerHTML = jsonResponse.attack[id].host;
                                        document.getElementById("timefor" + id).innerHTML = jsonResponse.attack[id].time + "sec";
                                        document.getElementById("methodfor" + id).innerHTML = jsonResponse.attack[id].method;
                                        setTimeout(UpdateTimeSec, 1000, id);
                                    }
                                }
                            }
                        }
                    };
                    xmlhttp.open("GET", "@/inc/ajax/attack.php?action=running&layer=7&info&id=" + id, true);
                    xmlhttp.send();
                }
            }
            function removeElement(elementId) {
                var element = document.getElementById(elementId);
                element.parentNode.removeChild(element);
            }
            function InitRow(id) {
                if (document.getElementById("attackid" + id)) {
                    return false;
                } else {
                    document.getElementById("attacksbox").innerHTML += '<tr id="attackid' + id + '"><td id="ipfor' + id + '"></td><td id="timefor' + id + '"></td><td id="methodfor' + id + '"></td><td><button class="btn btn-sm btn-danger" onclick="StopAttack(' + id + ');" id="attbtn' + id + '">Stop</button></td></tr>';
                    return true;
                }
            }
            function UpdateTimeSec(id) {
                var time = document.getElementById("timefor" + id).innerHTML;
                time = time.split("sec")[0] - 1;
                if (time < 2) {
                    removeElement("attackid" + id);
                } else {
                    document.getElementById("timefor" + id).innerHTML = time + "sec";
                    setTimeout(UpdateTimeSec, 1000, id);
                }
            }
            function StopAttack(id) {
                var btn = document.getElementById("attbtn" + id);
                var stopresponse = document.getElementById("result2");
                btn.disabled = true;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        A_Disabled(false);
                        if (this.status == 200) {
                            stopresponse.innerHTML = "";
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg') && jsonResponse.hasOwnProperty('success')) {
                                    stopresponse.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg, "border-0 m-0");
                                    if (jsonResponse.success == true) { document.getElementById("timefor" + id).innerHTML = "0sec"; }
                                    Codebase.helpers('notify', {
                                        align: 'right',             // 'right', 'left', 'center'
                                        from: 'top',                // 'top', 'bottom'
                                        type: jsonResponse.msg_type,               // 'info', 'success', 'warning', 'danger'
                                        message: jsonResponse.msg
                                    });
                                }
                                if (jsonResponse.hasOwnProperty('go')) {
                                    window.location.href = jsonResponse.go;
                                }
                            }
                        } else {
                            stopresponse.innerHTML = HtmlAlert("danger", "An error has occured. Reload your page and try again. If the problem persist, contact an admin.", "border-0 m-0");
                        }
                    }
                };
                xmlhttp.open("POST", "@/inc/ajax/attack.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("action=stop&id=" + id);
            }

        </script>
    </body>
</html>