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
            <main id="main-container">
                <div class="content">
                    <div class="row push">
                        <?php
                            $sql = $db->query("SELECT `name`, `osi`, `power`, `type`, `id`, `slots`, `network`,`active` FROM `servers`");
                            while($server=$sql->fetch()){
                                $total = $db->query("SELECT COUNT(*) FROM `servers_attacks` WHERE `serverid` = ".intval($server["id"]))->fetchColumn(0);
                                $running = $db->query("SELECT COUNT(*) FROM `servers_attacks` WHERE `serverid` = ".intval($server["id"])." AND `expire` > ".time())->fetchColumn(0);
                                $charts[$server["id"]] = array(
                                    "id" => $server["id"],
                                    "name" => $server["name"],
                                );
                        ?>
                        <div class="col-md-4">
                            <div class="block block-rounded text-center bg-mn-dark">
                                <div class="block-header block-header-default bg-dark border-b">
                                    <h3 class="block-title text-white m-0 p-0">
                                        <i class="fa fa-server"></i> <?php echo $server["name"]; ?>
                                    </h3>
                                </div>
                                <div class="block-content block-content-full bg-primary-dark">
                                    <div class="pull-all">
                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="attackchart<?php echo $server["id"]; ?>" style="height: 140px;"></canvas>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped bg-mn-dark">
                                        <tbody>
                                            <tr>
                                                <th style="width: 45%;" class="text-left"><i class="fa fa-satellite-dish"></i> Power:</th>
                                                <td class="text-left"><?php echo $server["power"]; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-left"><i class="fa fa-rocket"></i> Total Attacks:</th>
                                                <td class="text-left"><?php echo $total; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-left"><i class="fa fa-layer-group"></i> Slots:</th>
                                                <td class="text-left"><?php echo $running.'/'.$server["slots"]; ?> attacks</td>
                                            </tr>
                                            <?php
                                                if(!empty($userinfo["membership"])){
                                            ?>
                                            <tr>
                                                <th class="text-left"><i class="fa fa-wifi"></i> Connection:</th>
                                                <td class="text-left" id="ping-<?php echo $server["id"]; ?>"><i class="fa fa-spinner fa-spin"></i></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <?php
                            }
                        ?>

                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <?php
            if(!empty($userinfo["membership"])){
        ?>
        <script>
            $(document).ready(function () {
                <?php
                    foreach($charts as $chart){
                        echo 'PingServer('.$chart["id"].');';
                    }
                ?>
            });
        </script>
        <script>
            function PingServer(id) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg') && jsonResponse.hasOwnProperty('success')) {
                                    if (jsonResponse.success == true) {
                                        document.getElementById("ping-" + id).innerHTML = jsonResponse.msg + "ms";
                                    } else {
                                        Codebase.helpers('notify', {
                                            align: 'right',
                                            from: 'top',
                                            type: jsonResponse.msg_type,
                                            message: jsonResponse.msg
                                        });
                                        document.getElementById("ping-" + id).innerHTML = '<i class="fa fa-times"></i> Failed';
                                    }
                                }
                                if (jsonResponse.hasOwnProperty('go')) {
                                    window.location.href = jsonResponse.go;
                                }
                            }
                        }
                    }
                };
                xmlhttp.open("POST", "@/inc/ajax/server.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("action=ping&id=" + id);
            }
        </script>
        <?php
            }
        ?>
        <?php
            foreach($charts as $chart){
        ?>

        <script>
            <?php                    
                for( $i= 0 ; $i <= 6 ; $i++ ){ 
                    $dvalues[date("D, d", strtotime("-$i days"))] = 0; 
                }
                $dvalues = array_reverse($dvalues);
                $sql31 = $db->query("SELECT `date` FROM `servers_attacks` WHERE `date` > ".strtotime(date("d-m-Y", strtotime("-6 days")))." AND `serverid` = '".intval($chart["id"])."' ORDER BY `date` ASC");
                while($attack =$sql31->fetch()){
                    $dvalues[date("D, d", $attack["date"])] ++;
                }
                $count = 0;
                $mxc = count($dvalues);
                unset($days);
                $days = '';
                foreach($dvalues as $day=>$dvalue){
                    $count ++;
                    $days .= "'".$day."'".($mxc != $count ? "," : "");
                }
                echo "var days".$chart["id"]." = [$days];\n";
                echo "var dvalues".$chart["id"]." = [";
                $count = 0;
                $mxc = count($dvalues);
                foreach($dvalues as $day=>$dvalue){
                    $count ++;
                    echo "'".$dvalue."'".($mxc != $count ? "," : "");
                }
                echo "];\n";

                unset($days);
                unset($mxc);
                unset($dvalues);
                unset($dvalue);
            ?>
            var ctx = document.getElementById("attackchart<?php echo $chart["id"]; ?>");
            var schart<?php echo $chart["id"]; ?> = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: days<?php echo $chart["id"]; ?>,
                    datasets: [{
                        label: "Attacks from last 7 days",
                        fill: !0,
                        backgroundColor: "rgba(50, 69, 153, 0.90)",
                        borderColor: "transparent",
                        data: dvalues<?php echo $chart["id"]; ?>
                    }]
                    
                },
                options: {
                    legend: {
                        fontColor: "white"
                    },
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
                                return tooltipItems.yLabel  + " launched.";
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
        </script>
                <?php
            }
        ?>
    </body>
</html>