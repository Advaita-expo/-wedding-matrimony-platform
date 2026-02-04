<?php
session_start();
header('Content-Type: application/json');

// Include database configuration
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Username and password required']);
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND active = 1");
        $stmt->execute([$data['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            
            // Update last login
            $updateStmt = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
            $updateStmt->execute([$user['id']]);
            
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
