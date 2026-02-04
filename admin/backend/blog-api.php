<?php
session_start();
header('Content-Type: application/json');

// Check if admin is logged in
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
        // Get all blog posts
        $stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $posts]);
        
    } else if ($method === 'GET' && $action === 'get') {
        // Get single blog post
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$post) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Post not found']);
        } else {
            echo json_encode(['success' => true, 'data' => $post]);
        }
        
    } else if ($method === 'POST' && $action === 'create') {
        // Create blog post
        $data = json_decode(file_get_contents('php://input'), true);
        
        $required = ['title', 'slug', 'content', 'excerpt', 'category', 'status'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "$field is required"]);
                exit;
            }
        }
        
        $stmt = $pdo->prepare("
            INSERT INTO blog_posts (title, slug, content, excerpt, category, status, featured_image, author_id, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        $result = $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['category'],
            $data['status'],
            $data['featured_image'] ?? null,
            $_SESSION['admin_user_id']
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post created', 'id' => $pdo->lastInsertId()]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to create post']);
        }
        
    } else if ($method === 'PUT' && $action === 'update') {
        // Update blog post
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("
            UPDATE blog_posts 
            SET title=?, slug=?, content=?, excerpt=?, category=?, status=?, featured_image=?, updated_at=NOW()
            WHERE id=?
        ");
        
        $result = $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['category'],
            $data['status'],
            $data['featured_image'] ?? null,
            $id
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post updated']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update post']);
        }
        
    } else if ($method === 'DELETE' && $action === 'delete') {
        // Delete blog post
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete post']);
        }
        
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
