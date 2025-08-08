<?php
header("Content-Type: application/json");
include '../connection.php';

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['comment_id']) || !isset($data['content'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing comment_id or content in request"
    ]);
    exit;
}

$comment_id = $data['comment_id'];
$content = $data['content'];

$stmt = $mysqli->prepare("UPDATE comments SET content = ? WHERE id = ?");
$stmt->bind_param("si", $content, $comment_id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Comment updated successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update comment"
    ]);
}
?>
