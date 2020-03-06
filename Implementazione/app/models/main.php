<?php

//main

function load_classphp($directory) {
    if(is_dir($directory)) {
        $scan = scandir($directory);
        unset($scan[0], $scan[1]); //unset . and ..
        foreach($scan as $file) {
            if(is_dir($directory."/".$file)) {
                load_classphp($directory."/".$file);
            } else {
                if(strpos($file, '.class.php') !== false) {
                    include_once($directory."/".$file);
                }
            }
        }
    }
}

load_classphp('./acquisto');
load_classphp('./cliente');
load_classphp('./prenotazione');
load_classphp('./servizi');
load_classphp('./volo');

$aereoportoP = new Aeroporto('Malpensa', 'EU', 'ITALY', 'milano', 'MXP');
\model\servizi\DBFacade::getIstance()->put($aereoportoP);

?>
