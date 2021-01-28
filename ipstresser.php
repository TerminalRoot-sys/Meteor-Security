<?php
    require_once("@/sys/area.php");
    if($site["settings"]["hub"]["layer4"] != TRUE && !$userinfo["rank"] > 0){
        header("Location: index.php");
        die("IP Stresser under maintenance");
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
                        <div class="col-md-12">
                            <div class="alert alert-dark bg-dark">
                                <i class="fa fa-info-circle"></i> If you are expecting for an IP Logger, just click on <u><a href="" class="text-primary">this link</a></u> to get one. If you want to have more information about a method, click on <u><a href="methods.php" class="text-primary">this link</a></u>.</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="block block-rounded bg-mn-dark">
                                <div class="block-header block-header-default bg-mn-dark border-b">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-rocket"></i> Start Attack
                                    </h3>
                                    <div class="block-options">
                                        <button class="btn btn-sm btn-dark" onclick="$('#modal-addressbook').modal({ backdrop: 'static', keyboard: false });"><i class="fa fa-book-dead"></i> Address Book</button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div id="response"></div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>IP Address:</label>
                                                <input type="text" class="form-control bg-primary-darker text-white border-0" maxlength="15" id="host" placeholder="Ex: 127.0.0.1" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Port:</label>
                                                <input type="text" class="form-control bg-primary-darker text-white border-0" maxlength="5" id="port" placeholder="Ex: 80" />
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
                                                        $cmethods = GetMethods(4);
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
                                                <th scope="col" style="width: 10%;">Port</th>
                                                <th scope="col" style="width: 20%;">Time</th>
                                                <th scope="col" style="width: 30%;">Method</th>
                                                <th scope="col" style="width: 10%;"></th>
                                            </tr>
                                        </thead>
                                         <tbody class="text-center" id="attacksbox">
                                             <tr class="text-center" id="emptyattacksmessage"><td colspan="5">Looking for running attacks...</td></tr>
                                         </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <div class="modal fade" id="modal-addressbook" tabindex="-1" role="dialog" aria-labelledby="modal-addressbook" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0 bg-dark">
                            <div class="block-header bg-primary-dark border-b">
                                <h3 class="block-title"><i class="fa fa-book-dead"></i> My Address Book</h3>
                                <div class="block-options">
                                    <a data-toggle="collapse" href="#addaddress" class="advcollapse btn btn-sm btn-primary" role="button" aria-expanded="false" aria-controls="collapseaddaddress">
                                        <span class="collapsed"><i class="fa fa-plus"></i> New address</span>
                                        <span class="uncollapsed"><i class="fa fa-minus"></i> Minus</span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i> Close</button>
                                </div>
                            </div>
                            <div class="collapse" id="addaddress">
                                <div class="block-content bg-dark text-white">
                                    <div id="result3"></div>
                                    <div class="form-group">
                                        <label for="address">IP/URL:</label>
                                        <input type="text" id="address" class="form-control bg-primary-darker text-white border-0" placeholder="Address" value="" />
                                    </div>
                                    <div class="form-group">
                                        <label for="note">Note/Description:</label>
                                        <textarea id="note" class="form-control bg-primary-darker text-white border-0" placeholder="Note"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" id="NewAddressBtn" onclick="AddAddressOnBook()"><i class="fa fa-plus"></i> Add this address</button>
                                    </div>
                                </div>
                                <div class="py-3"></div>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control border-0 border-b border-r border-t bg-mn-dark" style="border-radius: 0;" onkeyup="SearchMethod()" id="searchInput" placeholder="Search...">
                                <div class="input-group-append">
                                    <select class="form-control border-0 border-b border-l border-t bg-mn-dark text-white" id="searchBy" onchange="SearchMethod()" style="border-radius: 0;">
                                        <option value="0">Search by IP/URL</option>
                                        <option value="1">Search by Note</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-stripped bg-mn-dark table-vcenter" id="searchTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 2%;"></th>
                                            <th>IP/URL</th>
                                            <th style="width: 65%;">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-primary-dark" id="addresseslist">
                                        <?php
                                            unset($entries);
                                            $entries = $db->query("SELECT * FROM `addressbook` WHERE `userid` = '".intval($userinfo["id"])."'")->fetchAll();
                                            foreach($entries as $entry){
                                                echo '<tr id="address'.$entry["id"].'">
                                                        <td class="text-center"><a href="javascript:void(0);" id="addrdel'.$entry["id"].'" onclick="DeleteAddressId('.$entry["id"].');"><i class="fa fa-times text-danger"></i></a></td>
                                                        <td>'.$entry["address"].'</td>
                                                        <td>'.$entry["note"].'</td>
                                                    </tr>';
                                            }
                                            if(empty($entries)){
                                                echo '<tr class="text-center" id="emptybookmessage"><td colspan="3">No address available</td></tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            var port = document.getElementById("port");
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
                    xmlhttp.send("action=layer4&host=" + host.value + "&port=" + port.value + "&time=" + time.value + "&method=" + method.value);
                }
            }

            function A_Disabled(state) {
                host.disabled = state;
                port.disabled = state;
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
                xmlhttp.open("GET", "@/inc/ajax/attack.php?action=running&layer=4&ids", true);
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
                                        document.getElementById("portfor" + id).innerHTML = jsonResponse.attack[id].port;
                                        document.getElementById("timefor" + id).innerHTML = jsonResponse.attack[id].time + "sec";
                                        document.getElementById("methodfor" + id).innerHTML = jsonResponse.attack[id].method;
                                        setTimeout(UpdateTimeSec, 1000, id);
                                    }
                                }
                            }
                        }
                    };
                    xmlhttp.open("GET", "@/inc/ajax/attack.php?action=running&layer=4&info&id=" + id, true);
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
                    var emptyattackselement = document.getElementById('emptyattacksmessage');
                    if (typeof (emptyattackselement) != 'undefined' && emptyattackselement != null) { removeElement("emptyattacksmessage"); }
                    document.getElementById("attacksbox").innerHTML += '<tr id="attackid' + id + '"><td id="ipfor' + id + '"></td><td id="portfor' + id + '"></td><td id="timefor' + id + '"></td><td id="methodfor' + id + '"></td><td><button class="btn btn-sm btn-danger" onclick="StopAttack(' + id + ');" id="attbtn' + id + '">Stop</button></td></tr>';
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
                if (document.getElementById("attacksbox").innerHTML.trim() == "") {
                    document.getElementById("attacksbox").innerHTML = '<tr class="text-center" id="emptyattacksmessage"><td colspan="5">No running attacks</td></tr>';
                }else{
                    var emptyattackselement = document.getElementById('emptyattacksmessage');
                    if (typeof (emptyattackselement) != 'undefined' && emptyattackselement != null) { removeElement("emptyattacksmessage"); }
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
                                        align: 'right',
                                        from: 'top',
                                        type: jsonResponse.msg_type,
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
            function DeleteAddressId(id) {
                var btn = document.getElementById("addrdel" + id);
                var deladdrresponse = document.getElementById("result3");
                var tmp = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin text-primary"></i>';
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        btn.innerHTML = tmp;
                        if (this.status == 200) {
                            deladdrresponse.innerHTML = "";
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg') && jsonResponse.hasOwnProperty('success')) {
                                    deladdrresponse.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg, "border-0 m-0");
                                    if (jsonResponse.success == true) { removeElement("address" + jsonResponse.data.id); }
                                    if (document.getElementById("addresseslist").innerHTML.trim() == "") {
                                        document.getElementById("addresseslist").innerHTML = '<tr class="text-center" id="emptybookmessage"><td colspan="3">No address available</td></tr>';
                                    }
                                }
                                if (jsonResponse.hasOwnProperty('go')) {
                                    window.location.href = jsonResponse.go;
                                }
                            }
                        } else {
                            deladdrresponse.innerHTML = HtmlAlert("danger", "An error has occured. Reload your page and try again. If the problem persist, contact an admin.", "border-0 m-0");
                        }
                    }
                };
                xmlhttp.open("POST", "@/inc/ajax/attack.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("action=deladdress&id=" + id);
            }
            function AddAddressOnBook() {
                var btn = document.getElementById("NewAddressBtn");
                var addressresponse = document.getElementById("result3");
                var addressinput = document.getElementById("address");
                var noteinput = document.getElementById("note");
                btn.disabled = true;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            btn.disabled = false;
                            addressresponse.innerHTML = "";
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg') && jsonResponse.hasOwnProperty('success')) {
                                    addressresponse.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg, "border-0 m-0");
                                    if (jsonResponse.success == true) {
                                        if (jsonResponse.hasOwnProperty('data')) {
                                            var emptybookelement = document.getElementById('emptybookmessage');
                                            if (typeof (emptybookelement) != 'undefined' && emptybookelement != null) { removeElement("emptybookmessage"); }
                                            document.getElementById("addresseslist").innerHTML += '<tr id="address' + jsonResponse.data.id + '"><td class="text-center"><a href="javascript:void(0);" id="addrdel' + jsonResponse.data.id + '" onclick="DeleteAddressId(' + jsonResponse.data.id + ');"><i class="fa fa-times text-danger"></i></a></td><td>' + jsonResponse.data.address + '</td><td>' + jsonResponse.data.note + '</td></tr>';
                                        }
                                    }
                                }
                                if (jsonResponse.hasOwnProperty('go')) {
                                    window.location.href = jsonResponse.go;
                                }
                            } else {
                                addressresponse.innerHTML = HtmlAlert("danger", "An error has occured", "border-0 m-0");
                            }
                        } else {
                            addressresponse.innerHTML = HtmlAlert("danger", "An error has occured. Reload your page and try again. If the problem persist, contact an admin.", "border-0 m-0");
                        }
                    }
                };
                xmlhttp.open("POST", "@/inc/ajax/attack.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("action=newaddress&address=" + addressinput.value + "&note=" + noteinput.value);
            }
        </script>
    </body>
</html>