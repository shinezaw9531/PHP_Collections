<?php

error_reporting(E_ALL);
ini_set('display_error', 1);

// Headers

Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

// Including required files.
include_once('../../config/Database.php');
include_once('../../models/Post.php');

// Connecting with database.

$database = new Database;
$db =  $database->connect();

$post = new Post($db);
$data = json_decode(file_get_contents("php://input"));

if(count($_POST)){
    

    // Creating new post from user input.

    $params = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'category_id' => $_POST['category_id'],
    ];

    if($post->create_new_post($params))
    {
        echo json_encode(['message' => 'Post added successfully']);
    }
}
else if(isset($data))
{
     // Creating new post from user input.

     $params = [
        'title' => $data->title,
        'description' => $data->description,
        'category_id' => $data->category_id,
    ];

    if($post->create_new_post($params))
    {
        echo json_encode(['message' => 'Post added successfully']);
    }
}