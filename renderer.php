<?php 

function draw($filename, $connectionn) {
    \ob_start();
    $connection = $connectionn;
    require($filename);
    $html = \ob_get_contents();
    \ob_end_clean();
    return $html;
    
}