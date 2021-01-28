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
                    <div class="col-md-12">
                        <?php
                            if($site["settings"]["hub"]["layer4"] == TRUE){
                        ?>
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
                                        <option value="0">Search by Name</option>
                                        <option value="1">Search by Categorie</option>
                                        <option value="2">Search by Description</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-stripped bg-mn-dark table-vcenter" id="searchTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Categorie</th>
                                            <th style="width:  75%;">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-primary-dark">
                                        <?php
                                            unset($cmethods);
                                            $cmethods = $db->query("SELECT * FROM `methods_categories` WHERE `osi` = 4 AND `active` > 0")->fetchAll();
                                            foreach($cmethods as $cmethod){
                                                $methods = $db->query("SELECT * FROM `methods` WHERE `active` > 0 AND `cid` = '".intval($cmethod["id"])."'")->fetchAll();
                                                foreach($methods as $method){
                                                    echo '<tr>
                                                            <td class="text-center">'.$method["name"].'</td>
                                                            <td class="text-center">'.$cmethod["name"].'</td>
                                                            <td>'.(empty($method["description"]) ? 'No description' : $method["description"]).'</td>
                                                        </tr>';
                                                }
                                            }
                                            if(empty($cmethods)){
                                                echo '<tr class="text-center"><td colspan="3">There is no available methods on Layer 4</td></tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <?php
                            if($site["settings"]["hub"]["layer7"] == TRUE){
                        ?>
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
                                        <option value="0">Search by Name</option>
                                        <option value="1">Search by Categorie</option>
                                        <option value="2">Search by Description</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-stripped bg-mn-dark table-vcenter" id="7searchTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Categorie</th>
                                            <th style="width:  75%;">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-primary-dark">
                                        <?php
                                            unset($cmethods);
                                            $cmethods = $db->query("SELECT * FROM `methods_categories` WHERE `osi` = 7 AND `active` > 0")->fetchAll();
                                            foreach($cmethods as $cmethod){
                                                $methods = $db->query("SELECT * FROM `methods` WHERE `active` > 0 AND `cid` = '".intval($cmethod["id"])."'")->fetchAll();
                                                foreach($methods as $method){
                                                    echo '<tr>
                                                            <td class="text-center">'.$method["name"].'</td>
                                                            <td class="text-center">'.$cmethod["name"].'</td>
                                                            <td>'.(empty($method["description"]) ? 'No description' : $method["description"]).'</td>
                                                        </tr>';
                                                }
                                            }
                                            if(empty($cmethods)){
                                                echo '<tr class="text-center"><td colspan="3">There is no available methods on Layer 7</td></tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
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

    </body>
</html>