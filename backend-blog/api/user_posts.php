<?php
include '../connection.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing user_id in request"
    ]);
    exit;
}

$user_id = intval($data['user_id']);

$stmt = $mysqli->prepare("SELECT posts.id, posts.title, posts.content
    FROM posts
    WHERE posts.user_id = ?
    ORDER BY posts.id DESC
    LIMIT 10");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $posts
]);
