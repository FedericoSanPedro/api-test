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

if(isset($_GET['id'])){
    $data = $post->read_single_post($_GET['id']);
    
if($data->rowCount()){
    $posts =[];
    while($row = $data->fetch(PDO::FETCH_OBJ)){
        $posts[$row->id] = [
            'id' => $row->id,
            'categoryName' => $row->category,
            'description' => $row->description,
            'title' => $row->title
        ];
    }
    echo json_encode($posts);
}
else{
    
    echo json_encode(array('message' => 'No posts found'));
}
} 
