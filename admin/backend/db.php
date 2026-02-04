<?php
// Database configuration
$host = 'localhost';
$dbname = 'wedding_company_cms';
$username = 'root';
$password = '123456789';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Admin user class
class AdminAuth {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            return true;
        }
        return false;
    }
    
    public function logout() {
        session_start();
        session_destroy();
    }
    
    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
}

// Blog post management
class BlogManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function createPost($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO blog_posts (title, slug, content, excerpt, category, status, featured_image, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        return $stmt->execute([
            $data['title'], $data['slug'], $data['content'], 
            $data['excerpt'], $data['category'], $data['status'], 
            $data['featured_image']
        ]);
    }
    
    public function updatePost($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE blog_posts 
            SET title=?, slug=?, content=?, excerpt=?, category=?, status=?, featured_image=?, updated_at=NOW()
            WHERE id=?
        ");
        return $stmt->execute([
            $data['title'], $data['slug'], $data['content'], 
            $data['excerpt'], $data['category'], $data['status'], 
            $data['featured_image'], $id
        ]);
    }
    
    public function deletePost($id) {
        $stmt = $this->pdo->prepare("DELETE FROM blog_posts WHERE id=?");
        return $stmt->execute([$id]);
    }
}

// Gallery management
class GalleryManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllImages() {
        $stmt = $this->pdo->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function uploadImage($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO gallery_images (title, filename, alt_text, category, description, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([
            $data['title'], $data['filename'], $data['alt_text'], 
            $data['category'], $data['description']
        ]);
    }
    
    public function deleteImage($id) {
        // Get filename first to delete physical file
        $stmt = $this->pdo->prepare("SELECT filename FROM gallery_images WHERE id=?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        
        if ($image) {
            // Delete physical file
            $filePath = '../uploads/gallery/' . $image['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete from database
            $stmt = $this->pdo->prepare("DELETE FROM gallery_images WHERE id=?");
            return $stmt->execute([$id]);
        }
        return false;
    }
}

// Contact management
class ContactManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllContacts() {
        $stmt = $this->pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function updateContactStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE contact_inquiries SET status=?, updated_at=NOW() WHERE id=?");
        return $stmt->execute([$status, $id]);
    }
    
    public function deleteContact($id) {
        $stmt = $this->pdo->prepare("DELETE FROM contact_inquiries WHERE id=?");
        return $stmt->execute([$id]);
    }
}

// Services management
class ServicesManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllServices() {
        $stmt = $this->pdo->query("SELECT * FROM services ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
    
    public function createService($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO services (name, description, price, icon, features, status, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, 'active', NOW(), NOW())
        ");
        return $stmt->execute([
            $data['name'], $data['description'], $data['price'], 
            $data['icon'], json_encode($data['features'])
        ]);
    }
    
    public function updateService($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE services 
            SET name=?, description=?, price=?, icon=?, features=?, updated_at=NOW()
            WHERE id=?
        ");
        return $stmt->execute([
            $data['name'], $data['description'], $data['price'], 
            $data['icon'], json_encode($data['features']), $id
        ]);
    }
    
    public function deleteService($id) {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id=?");
        return $stmt->execute([$id]);
    }
}

// Settings management
class SettingsManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getSetting($key) {
        $stmt = $this->pdo->prepare("SELECT value FROM settings WHERE setting_key=?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['value'] : null;
    }
    
    public function setSetting($key, $value) {
        $stmt = $this->pdo->prepare("
            INSERT INTO settings (setting_key, value, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE value=?, updated_at=NOW()
        ");
        return $stmt->execute([$key, $value, $value]);
    }
    
    public function getAllSettings() {
        $stmt = $this->pdo->query("SELECT * FROM settings");
        $result = $stmt->fetchAll();
        
        $settings = [];
        foreach ($result as $row) {
            $settings[$row['setting_key']] = $row['value'];
        }
        return $settings;
    }
}

// Initialize managers
$auth = new AdminAuth($pdo);
$blog = new BlogManager($pdo);
$gallery = new GalleryManager($pdo);
$contacts = new ContactManager($pdo);
$services = new ServicesManager($pdo);
$settings = new SettingsManager($pdo);

// API endpoints would be handled in separate files
?>