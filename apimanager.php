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
            <?php if(!empty($userinfo["membership"]) && $userinfo["membership"]["api"] > 0){ ?>
            <main id="main-container" style="min-height: 260px;">
                <div class="content">
                    <h3 class="text-center text-white"><i class="fa fa-server"></i> API Manager</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="block bg-dark">
                                <div class="block-content border-bottom">
                                    <ul class="nav nav-pills push" data-toggle="tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#api-overview">
                                                <i class="fa fa-fw fa-tachometer-alt mr-5"></i>Overview
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#api-logs">
                                                <i class="fa fa-fw fa-archive mr-5"></i>Attacks Logs
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#api-methods">
                                                <i class="fa fa-fw fa-book mr-5"></i>Methods
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#api-documentation">
                                                <i class="fa fa-fw fa-code mr-5"></i>Documentation
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="block-content tab-content overflow-hidden">
                                    <div class="tab-pane fade show active" id="api-overview" role="tabpanel">
                                        <h4 class="font-w400 text-white">Overview</h4>
                                        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                                            <div class="col-4 col-xl-4">
                                                <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                                    <div class="block-content block-content-full clearfix">
                                                        <div class="float-left mt-10 d-none d-sm-block">
                                                            <i class="fa fa-archive fa-3x text-muted"></i>
                                                        </div>
                                                        <div class="font-size-h3 font-w600"><?= intval($db->query("SELECT COUNT(*) FROM `attacks` WHERE `userid` = '".intval($userinfo["id"])."' AND `startedfrom` = 'api'")->fetchColumn(0)); ?></div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Attacks</div>
                                                    </div>
                                                </a>
                                                <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                                    <div class="block-content block-content-full clearfix">
                                                        <div class="float-left mt-10 d-none d-sm-block">
                                                            <i class="fa fa-spinner fa-spin fa-3x text-muted"></i>
                                                        </div>
                                                        <div class="font-size-h3 font-w600"><?= intval($db->query("SELECT COUNT(*) FROM `attacks` WHERE `userid` = '".intval($userinfo["id"])."' AND `startedfrom` = 'api' AND `date` + time > ".time())->fetchColumn(0)); ?></div>
                                                        <div class="font-size-sm font-w600 text-uppercase text-muted">Running Attacks</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-8 col-xl-8 bg-mn-dark">
                                                <div class="pull-all">
                                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                                    <canvas id="attackchart" style="height: 260px;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear"></div>
                                    </div>
                                    <div class="tab-pane fade" id="api-logs" role="tabpanel">
                                        <h4 class="font-w400 text-white">Attacks Logs</h4>
                                        <div class="table-responsive">
                                            <table class="table table-dark table-vcenter table-bordered dataTableDisplay">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th style="width: 10%;">ID</th>
                                                        <th style="width: 20%;">OSI</th>
                                                        <th style="width: 20%;">Target</th>
                                                        <th style="width: 10%;">Date</th>
                                                        <th style="width: 20%;">Time</th>
                                                        <th style="width: 20%;">Method</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                        $alogs = $db->prepare("SELECT * FROM `attacks` WHERE `userid` = ? AND `startedfrom` = 'api'");
                                                        $alogs->execute(array($userinfo["id"]));
                                                        while($alog = $alogs->fetch(PDO::FETCH_ASSOC)){
                                                            echo '<tr>
                                                            <td>'.$alog["id"].'</td>
                                                            <td>Layer '.$alog["layer"].'</td>
                                                            <td>'.$alog["host"].($alog["layer"] == 4 ? ':'.$alog["port"] : '').'</td>
                                                            <td>'.date("M d, Y h:ia").'</td>
                                                            <td>'.$alog["time"].'</td>
                                                            <td>'.GetMethod($alog["method"])["name"].'</td>
                                                            </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="api-blacklist" role="tabpanel">
                                    </div>
                                    <div class="tab-pane fade" id="api-methods" role="tabpanel">
                                        <h4 class="font-w400 text-white">Methods</h4>
                                        <div class="block block-rounded bg-primary-dark">
                                            <div class="block-header block-header-default bg-mn-dark border-b">
                                                <h3 class="block-title text-white">
                                                    <i class="fa fa-server"></i> Layer 4
                                                </h3>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-0 border-b bg-mn-dark" style="border-radius: 0;" onkeyup="SearchMethod()" id="searchInput" placeholder="Search...">
                                                <div class="input-group-append">
                                                    <select class="form-control border-0 border-b border-l bg-mn-dark text-white" id="searchBy" onchange="SearchMethod()" style="border-radius: 0;">
                                                        <option value="1">Search by Name</option>
                                                        <option value="2">Search by Categorie</option>
                                                        <option value="3">Search by Description</option>
                                                    </select>
                                                </div>
                                            </div>
                            
                                            <div class="table-responsive">
                                                <table class="table table-stripped bg-mn-dark table-vcenter" id="searchTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Categorie</th>
                                                            <th style="width:  65%;">Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-primary-dark">
                                                        <?php
                                                            unset($cmethods);
                                                            $cmethods = $db->query("SELECT * FROM `methods_categories` WHERE `osi` = 4 AND `active` > 0")->fetchAll();
                                                            foreach($cmethods as $cmethod){
                                                                $methods = $db->query("SELECT * FROM `methods` WHERE `active` > 0 AND `cid` = '".intval($cmethod["id"])."' AND `lvl` < ".intval($userinfo["membership"]["lvl"]+1))->fetchAll();
                                                                foreach($methods as $method){
                                                                    echo '<tr>
                                                                            <td class="text-center">'.$method["id"].'</td>
                                                                            <td class="text-center">'.$method["name"].'</td>
                                                                            <td class="text-center">'.$cmethod["name"].'</td>
                                                                            <td>'.(empty($method["description"]) ? 'No description' : $method["description"]).'</td>
                                                                        </tr>';
                                                                }
                                                            }
                                                            if(empty($cmethods)){
                                                                echo '<tr class="text-center"><td colspan="4">There is no available methods on Layer 4</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>

                                        <div class="block block-rounded bg-primary-dark">
                                            <div class="block-header block-header-default bg-mn-dark border-b">
                                                <h3 class="block-title text-white">
                                                    <i class="fa fa-globe"></i> Layer 7
                                                </h3>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-0 border-b bg-mn-dark" style="border-radius: 0;" onkeyup="SearchMethod(7)" id="7searchInput" placeholder="Search...">
                                                <div class="input-group-append">
                                                    <select class="form-control border-0 border-b border-l bg-mn-dark text-white" id="7searchBy" onchange="SearchMethod(7)" style="border-radius: 0;">
                                                        <option value="1">Search by Name</option>
                                                        <option value="2">Search by Categorie</option>
                                                        <option value="3">Search by Description</option>
                                                    </select>
                                                </div>
                                            </div>
                            
                                            <div class="table-responsive">
                                                <table class="table table-stripped bg-mn-dark table-vcenter" id="7searchTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Categorie</th>
                                                            <th style="width:  65%;">Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-primary-dark">
                                                        <?php
                                                            unset($cmethods);
                                                            $cmethods = $db->query("SELECT * FROM `methods_categories` WHERE `osi` = 7 AND `active` > 0")->fetchAll();
                                                            foreach($cmethods as $cmethod){
                                                                $methods = $db->query("SELECT * FROM `methods` WHERE `active` > 0 AND `cid` = '".intval($cmethod["id"])."' AND `lvl` < ".intval($userinfo["membership"]["lvl"]+1))->fetchAll();
                                                                foreach($methods as $method){
                                                                    echo '<tr>
                                                                            <td class="text-center">'.$method["id"].'</td>
                                                                            <td class="text-center">'.$method["name"].'</td>
                                                                            <td class="text-center">'.$cmethod["name"].'</td>
                                                                            <td>'.(empty($method["description"]) ? 'No description' : $method["description"]).'</td>
                                                                        </tr>';
                                                                }
                                                            }
                                                            if(empty($cmethods)){
                                                                echo '<tr class="text-center"><td colspan="4">There is no available methods on Layer 7</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="api-settings" role="tabpanel">
                                        <h4 class="font-w400">Settings</h4>
                                        <p>Content fades in..</p>
                                    </div>
                                    <div class="tab-pane fade" id="api-documentation" role="tabpanel">
                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="block block-bordered block-rounded mb-2 bg-dark">
                                                <div class="block-header" role="tab" id="accordion_h1">
                                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_q1" aria-expanded="false" aria-controls="accordion_q1"><span class="badge badge-primary">[GET] /api/startattack/</span> - Start an attack</a>
                                                </div>
                                                <div id="accordion_q1" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion">
                                                    <div class="block-content">
                                                        <h4 class="font-w400 text-success">Parameters <small><span class="badge badge-primary">/api/startattack/</span></small></h4>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <td style="width: 5%;">Method</td>
                                                                        <td style="width: 10%;">Parameter</td>
                                                                        <td style="width: 10%;">Format</td>
                                                                        <td style="width: 10%;">Required</td>
                                                                        <td>Description</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>user</th>
                                                                        <td>Alphanum</td>
                                                                        <td>Yes</td>
                                                                        <td>Your account username: <?php echo $userinfo["username"]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>key</th>
                                                                        <td>String</td>
                                                                        <td>Yes</td>
                                                                        <td>Your API key: <?php echo $userinfo["apikey"]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>host</th>
                                                                        <td>IPv4 or URL</td>
                                                                        <td>Yes</td>
                                                                        <td>IP or URL Address of the target</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>port</th>
                                                                        <td>Integer</td>
                                                                        <td>Yes/no</td>
                                                                        <td>Port of the target, not required if host type URL</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>time</th>
                                                                        <td>Integer</td>
                                                                        <td>Yes</td>
                                                                        <td>Time (in seconds) of duration of the attack</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>method</th>
                                                                        <td>Integer</td>
                                                                        <td>Yes/No</td>
                                                                        <td>ID of the method to start attack, Not required if replaced by parameter "methodname"</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>methodname</th>
                                                                        <td>String</td>
                                                                        <td>No/Yes</td>
                                                                        <td>Name of the method to start attack, Not required if replaced by parameter "method"</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="py-4"></div>
                                                        <h4 class="font-w400 text-primary my-1">Demo Urls</h4>
                                                        <ul class="small">
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/starttack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&host=127.0.0.1&port=80&method=1&time=120</a>
                                                                <ul>
                                                                    <li><small class="text-success">Start "120" seconds attack on "127.0.0.1" using port "80" and method id "1"</small></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/starttack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&host=192.168.0.1&port=9098&methodname=Basic%20UDP&time=300</a>
                                                                <ul>
                                                                    <li><small class="text-success">Start "300" seconds attack on "192.168.0.1" using port "9098" and method name "Basic UDP"</small></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/starttack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&host=172.16.0.3&port=7777&method=5&time=3600</a>
                                                                <ul>
                                                                    <li><small class="text-success">Start "3600" seconds attack on "172.16.0.3" using port "7777" and method id "5"</small></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                        <div class="py-4"></div>
                                                        <h4 class="font-w400 text-danger my-1">Return Json</h4>
                                                        In case of successfuly request
<pre class="text-primary bg-dark m-5 bordered">
{
    "success": true,
    "message": "attack successfuly started",
    "data": { ..your GET data.. },
    "attackid": (int)1,
    "type": "success"
}
</pre>
In case of failed request
<pre class="text-danger  bg-dark">
{
    "success": false,
    "message": "error message",
    "data": { ..your GET data.. },
    "type": "danger"
}
</pre>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block block-bordered block-rounded mb-2 bg-dark">
                                                <div class="block-header" role="tab" id="accordion_h2">
                                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_q2" aria-expanded="false" aria-controls="accordion_q1"><span class="badge badge-primary">[GET] /api/stopattack/</span> - Stop an attack</a>
                                                </div>
                                                <div id="accordion_q2" role="tabpanel" aria-labelledby="accordion_h2" data-parent="#accordion">
                                                    <div class="block-content">
                                                        <h4 class="font-w400 text-success">Parameters <small><span class="badge badge-primary">/api/stopattack/</span></small></h4>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <td style="width: 5%;">Method</td>
                                                                        <td style="width: 10%;">Parameter</td>
                                                                        <td style="width: 10%;">Format</td>
                                                                        <td style="width: 10%;">Required</td>
                                                                        <td>Description</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>user</th>
                                                                        <td>Alphanum</td>
                                                                        <td>Yes</td>
                                                                        <td>Your account username: <?php echo $userinfo["username"]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>key</th>
                                                                        <td>String</td>
                                                                        <td>Yes</td>
                                                                        <td>Your API key: <?php echo $userinfo["apikey"]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>host</th>
                                                                        <td>IPv4 or URL</td>
                                                                        <td>No/Yes</td>
                                                                        <td>IP or URL Address of the target <small>All attacks start on this IP will be stopped</small></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="badge badge-primary">GET</span></td>
                                                                        <th>attackid</th>
                                                                        <td>Integer</td>
                                                                        <td>Yes/no</td>
                                                                        <td>Port of the target, not required if host type URL</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="py-4"></div>
                                                        <h4 class="font-w400 text-primary my-1">Demo Urls</h4>
                                                        <ul class="small">
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/stopattack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&host=127.0.0.1</a>
                                                                <ul>
                                                                    <li><small class="text-success">Stop all attacks on IP "127.0.0.1"</small></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/stopattack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&attackid=2</a>
                                                                <ul>
                                                                    <li><small class="text-success">Stop attack ID "2"</small></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href=""><?= $site["url"]; ?>/api/stopattack/?user=<?php echo $userinfo["username"]; ?>&key=<?php echo $userinfo["apikey"]; ?>&host=172.16.0.3</a>
                                                                <ul>
                                                                    <li><small class="text-success">Stop all attacks on IP "172.16.0.3"</small></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                        <div class="py-4"></div>
                                                        <h4 class="font-w400 text-danger my-1">Return Json</h4>
                                                        In case of successfuly request
<pre class="text-primary bg-dark m-5 bordered">
{
    "success": true,
    "message": "attack successfuly started",
    "data": { ..your GET data.. },
    "attackid": (int)1,
    "type": "success"
}
</pre>
In case of failed request
<pre class="text-danger  bg-dark">
{
    "success": false,
    "message": "error message",
    "data": { ..your GET data.. },
    "type": "danger"
}
</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
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
            $(document).ready(function() {
                $('table.dataTableDisplay').DataTable({
                    "order": [[ 1, 'asc' ]]
                });
            });
        </script>
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
        <script>
        <?php
            $selectiondate = strtotime(date("d-m-Y", strtotime("-30 days")));
            $days = '';                
            for( $i= 0 ; $i <= 30 ; $i++ ){ 
                $dvalues[date("F d, Y", strtotime("-$i days"))] = 0; 
            }
            $dvalues = array_reverse($dvalues);
            $sql31 = $db->query("SELECT `date` FROM `attacks` WHERE `userid` = '".intval($userinfo["id"])."' AND `startedfrom` = 'api' AND `date` > $selectiondate ORDER BY `date` ASC");
            while($attack =$sql31->fetch()){
                $dvalues[date("F d, Y", $attack["date"])] ++;
            }
            $count = 0;
            $mxc = count($dvalues);
            foreach($dvalues as $day=>$dvalue){
                $count ++;
                
                if(date("D, d", time()) == $day){ $days .= "'Today'".($mxc != $count ? "," : ""); }
                elseif(date("D, d", strtotime(date("d-m-Y", strtotime("-1 day")))) == $day){ $days .= "'Yesterday'".($mxc != $count ? "," : ""); }
                else{ $days .= "'".$day."'".($mxc != $count ? "," : ""); }
            }
            echo "var days = [$days];";
            echo "var dvalues = [";
            $count = 0;
            $mxc = count($dvalues);
            foreach($dvalues as $day=>$dvalue){
                $count ++;
                echo "'".$dvalue."'".($mxc != $count ? "," : "");
            }
            echo "];";

            
            
        ?></script>
        <script>
            var ctx = document.getElementById("attackchart");
            var attacksChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: days,
                    datasets: [{
                        label: "Last 30 Days attacks",
                        fill: !0,
                        backgroundColor: "rgba(50, 69, 153, 0.90)",
                        borderColor: "transparent",
                        data: dvalues
                    }]
                    
                },
                options: {
                    elements: {
                        point:{
                            radius: 0
                        }
                    },
                    tooltips: {
                        mode: 'nearest',
                        position: 'nearest',
                        intersect: false,
                        callbacks: {
                            label: function(tooltipItems, data) { 
                                return tooltipItems.yLabel  + " attacks launched.";
                            }
                        }
                    },
                    maintainAspectRatio: !1,
                    scales: {
                        maintainAspectRatio: !1,
                        xAxes: [{
                            display: false,
                            gridLines: {
                                drawBorder: true,
                                drawOnChartArea: false
                            },
                            ticks: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: {
                                drawBorder: true,
                                drawOnChartArea: false
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    }
                }
            });
            attacksChart.defaults.global.defaultFontColor = "#495057";
            attacksChart.defaults.scale.gridLines.color = "transparent";
            attacksChart.defaults.scale.gridLines.zeroLineColor = "transparent";
            attacksChart.defaults.scale.display = !1;
            attacksChart.defaults.scale.ticks.beginAtZero = !0;
            attacksChart.defaults.global.elements.line.borderWidth = 0;
            attacksChart.defaults.global.elements.point.radius = 0;
            attacksChart.defaults.global.elements.point.hoverRadius = 0;
            attacksChart.defaults.global.tooltips.cornerRadius = 3;
            attacksChart.defaults.global.legend.labels.boxWidth = 12;
        </script>
    </body>
</html>