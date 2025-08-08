<?php
include '../connection.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['post_id']) || !is_numeric($data['post_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing or invalid post_id in request"
    ]);
    exit;
}

$post_id = intval($data['post_id']);

$stmt_post = $mysqli->prepare("SELECT posts.id, posts.title, posts.content, users.name AS author_name
    FROM posts
    JOIN users ON posts.user_id = users.id
    WHERE posts.id = ?");

$stmt_post->bind_param("i", $post_id);
$stmt_post->execute();
$result_post = $stmt_post->get_result();

if ($result_post->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Post not found"
    ]);
    exit;
}

$post = $result_post->fetch_assoc();

$stmt_comments = $mysqli->prepare("SELECT comments.id, comments.content, users.name AS commenter_name
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = ?
    ORDER BY comments.id DESC
    LIMIT 15
");
$stmt_comments->bind_param("i", $post_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

$comments = $result_comments->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    "status" => "success",
    "data" => [
        "post" => $post,
        "comments" => $comments
    ]
]);
