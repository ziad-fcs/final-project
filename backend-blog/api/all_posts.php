<?php
include "../connection.php";
header("Content-Type: application/json");

$result =$mysqli->query(
    "SELECT posts.id, posts.title, posts.content, users.name, COUNT(comments.id) as Count from posts join users on posts.user_id = users.id
    left join comments on comments.post_id = posts.id group by posts.id order by posts.id desc"
);

if (!$result) {
    http_response_code(400);
    echo json_encode([
        "status"=>"error",
        "message"=>"Query failed" .$mysqli->error
    ]);
    exit;
}
$posts = [];
while ($row = $result->fetch_assoc()){
    $posts[] = $row;
}
echo json_encode($posts);