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
        $status = $_GET['status'] ?? null;
        if ($status) {
            $stmt = $pdo->prepare("SELECT * FROM contact_inquiries WHERE status = ? ORDER BY created_at DESC");
            $stmt->execute([$status]);
        } else {
            $stmt = $pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC");
        }
        $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $inquiries]);
        
    } else if ($method === 'GET' && $action === 'get') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM contact_inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $inquiry = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$inquiry) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Inquiry not found']);
        } else {
            echo json_encode(['success' => true, 'data' => $inquiry]);
        }
        
    } else if ($method === 'PUT' && $action === 'update') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $pdo->prepare("
            UPDATE contact_inquiries 
            SET status=?, priority=?, notes=?, assigned_to=?, updated_at=NOW()
            WHERE id=?
        ");
        
        $result = $stmt->execute([
            $data['status'],
            $data['priority'],
            $data['notes'],
            $_SESSION['admin_user_id'],
            $data['id']
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Inquiry updated']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update inquiry']);
        }
        
    } else if ($method === 'DELETE' && $action === 'delete') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM contact_inquiries WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Inquiry deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete inquiry']);
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
