<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : null;

try {
    if ($method === 'GET' && $action === 'list') {
        $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY sort_order ASC");
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $images]);
        
    } else if ($method === 'POST' && $action === 'create') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $pdo->prepare("
            INSERT INTO gallery_images (title, filename, alt_text, category, description, file_size, width, height, sort_order, featured) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $data['title'],
            $data['filename'],
            $data['alt_text'],
            $data['category'],
            $data['description'] ?? null,
            $data['file_size'] ?? null,
            $data['width'] ?? null,
            $data['height'] ?? null,
            $data['sort_order'] ?? 0,
            $data['featured'] ?? 0
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Image added', 'id' => $pdo->lastInsertId()]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add image']);
        }
        
    } else if ($method === 'PUT' && $action === 'update') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $pdo->prepare("
            UPDATE gallery_images 
            SET title=?, alt_text=?, category=?, description=?, sort_order=?, featured=?
            WHERE id=?
        ");
        
        $result = $stmt->execute([
            $data['title'],
            $data['alt_text'],
            $data['category'],
            $data['description'],
            $data['sort_order'],
            $data['featured'],
            $data['id']
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Image updated']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update image']);
        }
        
    } else if ($method === 'DELETE' && $action === 'delete') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Image deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete image']);
        }
        
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
