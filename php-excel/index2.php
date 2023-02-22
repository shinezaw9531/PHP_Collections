<?php

    if(($open = fopen('sample.csv','r')) !== FALSE){
        while(($data = fgetcsv($open, 1000,",")) !== FALSE){
            $array[] = $data;
        }
        fclose($open);
    }

    echo "<pre>";
        print_r($array);
    echo "</pre>";

?>