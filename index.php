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
            <main id="main-container" style="min-height: 260px;">
                <div class="content">
                    <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                        <div class="col-6 col-xl-3">
                            <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-users fa-3x text-muted"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600"><?php echo $site["stats"]["users"]["total"]; ?></div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Total Users</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-xl-3">
                            <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-archive fa-3x text-muted"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600"><?php echo $site["stats"]["attacks"]["total"]; ?></div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Total Attacks</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-xl-3">
                            <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-spinner fa-spin fa-3x text-muted"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600"><?php echo $site["stats"]["attacks"]["alive"]; ?></div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Running Attacks</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-xl-3">
                            <a class="block block-rounded block-transparent bg-mn-dark text-body-color-light text-right" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-server fa-3x text-muted"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600"><?php echo $site["stats"]["servers"]["total"]; ?></div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Servers</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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
                                                <td class="text-right"><?php echo (empty($userinfo["membership"]["name"]) ? 'None' : ChatMessage($userinfo["membership"]["name"])) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Concurrents:</th>
                                                <td class="text-right"><?php echo (empty($userinfo["membership"]["concurrents"]) ? '0' : intval($userinfo["membership"]["concurrents"])) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Max Time:</th>
                                                <td class="text-right"><?php echo (empty($userinfo["membership"]["maxtime"]) ? '0' : intval($userinfo["membership"]["maxtime"])) ?>sec</td>
                                            </tr>
                                            <tr>
                                                <th>Duration:</th>
                                                <td class="text-right"><?php echo (empty($userinfo["membership"]["duration"]) ? '0' : ChatMessage($userinfo["membership"]["duration"])) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Expiration:</th>
                                                <td class="text-right"><?php echo (empty($userinfo["expire"]) ? 'N/A' : ($userinfo["expire"] == -1) ? 'LIFETIME': date("d F, Y - h:ia", $userinfo["expire"])) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="" class="btn btn-square btn-block btn-primary"><i class="fa fa-store-alt"></i> Purchase</a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="block block-rounded bg-primary-dark text-white">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white"><i class="fa fa-newspaper"></i> News, updates and announcements</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-wrap-break-word overflow-y-auto" style="height: 260px;">
                                    <ul class="list list-timeline list-timeline-modern pull-t">
                                        <?php
                                            $news= $db->query("SELECT * FROM `news` ORDER BY `date` DESC");
                                            while($new = $news->fetch()){
                                                echo '
                                        <li>
                                            <div class="list-timeline-time">'.time_elapsed_string($new["date"]).'</div>
                                            <i class="list-timeline-icon '.$new["icon"].' bg-gray-darker"></i>
                                            <div class="list-timeline-content">
                                                <p class="font-w600">'.ChatMessage($new["title"], FALSE).'</p>
                                                <p>'.ChatMessage($new["message"], TRUE).'</p>
                                            </div>
                                        </li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-md-8">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default bg-mn-dark">
                                    <h3 class="block-title text-white">
                                        <i class="fa fa-chart-area"></i> Total Attacks Graph <small>from last 7 days</small>
                                    </h3>
                                </div>
                                <div class="block-content block-content-full bg-primary-dark">
                                    <div class="pull-all">
                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="attackchart" style="height: 240px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <script>
        <?php
            $selectiondate = strtotime(date("d-m-Y", strtotime("-6 days")));
            $days = '';                
            for( $i= 0 ; $i <= 6 ; $i++ ){ 
                $dvalues[date("D, d", strtotime("-$i days"))] = 0; 
            }
            $dvalues = array_reverse($dvalues);
            $sql31 = $db->query("SELECT `date` FROM `attacks` WHERE `date` > $selectiondate ORDER BY `date` ASC");
            while($attack =$sql31->fetch()){
                $dvalues[date("D, d", $attack["date"])] ++;
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
                        label: "Total Attacks",
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