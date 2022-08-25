<?php 

function draw($filename) {
    \ob_start();
    require($filename);
    $html = \ob_get_contents();
    \ob_end_clean();
    return $html;
    
}