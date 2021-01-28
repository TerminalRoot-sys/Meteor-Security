<?php
//Function definations
function MakeUrls($str){
    $find=array('`((?:https?|ftp)://\S+[[:alnum:]]/?)`si','`((?<!//)(www\.\S+[[:alnum:]]/?))`si');
    $replace=array('<a href="$1" target="_blank">$1</a>', '<a href="http://$1" target="_blank">$1</a>');
    return preg_replace($find,$replace,$str);
}
//Function testing
$str="fdgdgd www.cloudlibz.com";
$str=MakeUrls($str);
echo $str;
?>