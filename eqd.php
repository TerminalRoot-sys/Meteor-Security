<?php
    function GetCurrentUrl($without_file_name = FALSE) {
        return "http".(!empty($_SERVER["HTTPS"]) ? 's' : '')."://" . $_SERVER['HTTP_HOST'] 
        .($without_file_name == TRUE ? 
            substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/")+1) 
        : $_SERVER['REQUEST_URI'] ) ;
        
        $validURL = str_replace("&", "&amp", $url);
        return $validURL;
    }
    echo GetCurrentUrl(true);
?>