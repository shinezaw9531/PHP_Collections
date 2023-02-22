<?php

$data = array(
    array("Name", "Email", "Phone"),
    array("John Doe ကောင်", "johndoe@example.com", "555-555-5555"),
    array("Jane Doe", "janedoe@example.com", "555-555-5556"),
);

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=contacts.csv");

$output = fopen("php://output", "w");
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

foreach ($data as $row) {
    fputcsv($output, $row, ",", '"');
}

fclose($output);

?>