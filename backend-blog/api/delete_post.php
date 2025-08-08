<?php
header("Content-Type: application/json");
include '../connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['post_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing post_id in request body"
    ]);
    exit;
}

$post_id = $data['post_id'];

try {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Post deleted successfully"
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "Post not found"
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
