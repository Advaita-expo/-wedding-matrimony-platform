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
        $stmt = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $services]);
        
    } else if ($method === 'POST' && $action === 'create') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $pdo->prepare("
            INSERT INTO services (name, description, price, duration, category, availability, sort_order) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['duration'],
            $data['category'],
            $data['availability'] ?? 1,
            $data['sort_order'] ?? 0
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Service created', 'id' => $pdo->lastInsertId()]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to create service']);
        }
        
    } else if ($method === 'PUT' && $action === 'update') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $pdo->prepare("
            UPDATE services 
            SET name=?, description=?, price=?, duration=?, category=?, availability=?, sort_order=?
            WHERE id=?
        ");
        
        $result = $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['duration'],
            $data['category'],
            $data['availability'],
            $data['sort_order'],
            $data['id']
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Service updated']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update service']);
        }
        
    } else if ($method === 'DELETE' && $action === 'delete') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Service deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete service']);
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
