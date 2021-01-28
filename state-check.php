<!doctype html>
<html>
    <head>
        <title>Check</title>

        <meta charset="utf-8" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style type="text/css">
            body {
                background-color: #343a40 !important;
                color: #fff;
                margin: 0;
                padding: 0;
                font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        
            }
            div {
                width: 600px;
                margin: 15px auto;
                padding: 5px 30px 5px 30px;
                background-color: #2d3238;
                border-radius: 0.5em;
                box-shadow: 2px 3px 7px 2px rgba(0,0,0,0.02);
            }
            a:link, a:visited {
                color: #38488f;
                text-decoration: none;
            }
    
            .text-success {
                color: #32a852;
            }
    
            .text-danger {
                color: #a83e32;
            }
            .bg-success {
                background-color: #32a852;
            }
    
            .bg-danger {
                background-color: #a83e32;
            }
            @media (max-width: 700px) {
                div {
                    margin: 0 auto;
                    width: auto;
                }
            }
    
            table {
                width: 100%;
                border: 1px solid rgb(240,240,240);
                border-radius: 5px;
            }
            .text-center {
                text-align: center;
            }
            th, td {
                border: 1px solid rgb(201, 201, 201);
            }
        </style>    
    </head>

    <body>

        <h1 class="text-center">Tools, Installation & Status Checker</h1>
        <div>
            <h3>PHP Modules</h3>
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Required</th>
                        <th>Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PHP-cURL</td>
                        <td>Yes</td>
                        <td><?= ($phpmodulesok["PHP-CURL"] = function_exists("curl_init") ? '<strong class="text-success">OK</strong>' : '<strong class="text-danger">Not found</strong>')  ?></td>
                        <td>Download and installation link: <a href="https://www.php.net/manual/en/curl.installation.php">Click here</a></td>
                    </tr>
                    <tr>
                        <td>PHP-GD</td>
                        <td>Yes</td>
                        <td><?= ($phpmodulesok["PHP-CURL"] = function_exists("imagecreatetruecolor") ? '<strong class="text-success">OK</strong>' : '<strong class="text-danger">Not found</strong>')  ?></td>
                        <td>Download and installation link: <a href="https://www.php.net/manual/en/image.installation.php">Click here</a></td>
                    </tr>
                    <tr>
                        <td>PHP-SSH2</td>
                        <td>No</td>
                        <td><?= ($phpmodulesok["PHP-SSH2"] = function_exists("ssh2_exec") ? '<strong class="text-success">OK</strong>' : '<strong class="text-danger">Not found</strong>')  ?></td>
                        <td>Download and installation link: <a href="https://www.php.net/manual/en/ssh2.installation.php">Click here</a></td>
                    </tr>
                </tbody>
            </table>
            <p>If you need help to install PHP Modules, please contact the author/seller. <br/><small>Installation fees can be applied.</small></p>
        </div>
        <?php
            if(!file_exists(__DIR__."/@/sys/config.php")){
        ?>
        <div>
            <h2>Start Installation</h2>
            <h3>Step 1</h3>
            
            <hr/>
            <h3>Step 2</h3>
            <hr/>
            <p>If you need help to install PHP Modules, please contact the author/seller. <br/><small>Installation fees can be applied.</small></p>
        </div>
        <?php
            }else{
                $phpmodulesok = array();
        ?>
        <div class="bg-danger">Delete file <strong>"@/sys/config.php"</strong> to (re)install the source from this page</div>
        <?php
            }
        ?>
        <div class="text-center">Made with <span class="text-danger">&#10084;</span> by Etred971, Project continued by Nesko</div>
    </body>
</html>
