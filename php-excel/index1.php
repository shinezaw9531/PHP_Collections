<?php

    header('Content-Type: text/csv;charset=utf-8;');
    header('Content-Disposition: attachment; filename=sample.csv');

    $users = [
        ["id"=>1,"name"=>"Shine ရှိုင်း","email"=>"shine@gmail.com"],
        ["id"=>2,"name"=>"ရှိုင်း","email"=>"shine@gmail.com"],
    ];

    $file_path = fopen('php://output','w');
    
    foreach($users as $value){

        fputcsv($file_path,$value);
    }
    fclose($file_path);

?>