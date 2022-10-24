<?php


error_reporting(E_ALL);
ini_set('display_error', 1);


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');


include_once '../../config/Database.php';
include_once '../../models/Post.php';


// Instantiate Database.


$database = new Database;
$db = $database->connect();


$post = new Post($db);
$data = json_decode(file_get_contents("php://input"));

if(isset($data)){
    
    $params = [
        'id' => $data->id,
        'title' => $data->title,
        'description' => $data->description,
        'category_id' => $data->category_id,
    ];
    
    if($post->update_new_record($params))
    {
        echo json_encode(array('message' => 'Post updated'));
    }
}