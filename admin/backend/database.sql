-- Wedding Company CMS Database Schema

CREATE DATABASE IF NOT EXISTS wedding_company_cms;
USE wedding_company_cms;

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT,
    excerpt TEXT,
    category ENUM('real-weddings', 'wedding-tips', 'trends', 'planning-guide', 'inspiration') DEFAULT 'real-weddings',
    status ENUM('draft', 'published', 'scheduled') DEFAULT 'draft',
    featured_image VARCHAR(255),
    meta_title VARCHAR(255),
    meta_description TEXT,
    views INT DEFAULT 0,
    author_id INT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_published_at (published_at)
);

-- Gallery images table
CREATE TABLE gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    category ENUM('ceremonies', 'receptions', 'portraits', 'details') DEFAULT 'ceremonies',
    description TEXT,
    file_size INT,
    width INT,
    height INT,
    sort_order INT DEFAULT 0,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_featured (featured),
    INDEX idx_sort_order (sort_order)
);

-- Contact inquiries table
CREATE TABLE contact_inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    wedding_date DATE,
    guest_count INT,
    venue_type VARCHAR(100),
    budget_range VARCHAR(50),
    services_interest TEXT,
    message TEXT,
    status ENUM('new', 'contacted', 'closed') DEFAULT 'new',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    source VARCHAR(50) DEFAULT 'website',
    notes TEXT,
    assigned_to INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_wedding_date (wedding_date)
);

-- Services table
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price VARCHAR(100),
    icon VARCHAR(100) DEFAULT 'fas fa-heart',
    features JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_sort_order (sort_order)
);

-- Pricing packages table
CREATE TABLE pricing_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    features JSON,
    popular BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_popular (popular)
);

-- Settings table
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    value LONGTEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
);

-- Email templates table
CREATE TABLE email_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body LONGTEXT NOT NULL,
    variables TEXT,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Activity logs table
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
);

-- Backup logs table
CREATE TABLE backup_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    file_size INT,
    backup_type ENUM('manual', 'automatic') DEFAULT 'manual',
    status ENUM('success', 'failed', 'in_progress') DEFAULT 'in_progress',
    error_message TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL
);

-- Insert default admin user (password: 'wedding2026')
INSERT INTO admin_users (username, email, password, role) 
VALUES ('admin', 'admin@theweddingcompany.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert default settings
INSERT INTO settings (setting_key, value, description) VALUES
('site_name', 'The Wedding Company', 'Website name'),
('site_tagline', 'Professional Wedding Planning Services', 'Website tagline'),
('site_description', 'Creating magical wedding experiences with attention to every detail. Your dream wedding awaits.', 'Website description'),
('contact_email', 'info@theweddingcompany.com', 'Primary contact email'),
('contact_phone', '+1 (555) 123-4567', 'Primary contact phone'),
('contact_address', '123 Wedding Lane, Suite 100, City, State 12345', 'Business address'),
('facebook_url', 'https://facebook.com/theweddingcompany', 'Facebook page URL'),
('instagram_url', 'https://instagram.com/theweddingcompany', 'Instagram page URL'),
('primary_color', '#c41e3a', 'Primary brand color'),
('secondary_color', '#e8b4ba', 'Secondary brand color'),
('accent_color', '#d4a574', 'Accent brand color'),
('auto_backup', '1', 'Enable automatic backups'),
('backup_frequency', 'daily', 'Backup frequency'),
('notification_email', 'admin@theweddingcompany.com', 'Notification email address'),
('new_contact_notifications', '1', 'Send notifications for new contacts'),
('weekly_report_notifications', '1', 'Send weekly reports');

-- Insert sample services
INSERT INTO services (name, description, price, icon, features, sort_order) VALUES
('Full Wedding Planning', 'Complete wedding planning from start to finish with our expert team.', 'Starting from $5,000', 'fas fa-heart', 
'["Initial consultation", "Vendor coordination", "Timeline management", "Day-of coordination"]', 1),
('Photography & Videography', 'Professional wedding photography and videography services.', 'Starting from $2,500', 'fas fa-camera',
'["Engagement shoot", "Wedding day coverage", "Edited photos & videos", "Online gallery"]', 2),
('Floral Design', 'Beautiful floral arrangements for your special day.', 'Starting from $800', 'fas fa-seedling',
'["Bridal bouquet", "Ceremony decorations", "Reception centerpieces", "Boutonnieres"]', 3);

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, category, status, published_at) VALUES
('Sarah & John\'s Romantic Garden Wedding', 'sarah-john-romantic-garden-wedding', 
'<p>A beautiful outdoor ceremony surrounded by blooming flowers and fairy lights created the perfect romantic atmosphere for Sarah and John\'s special day.</p>', 
'A beautiful outdoor ceremony surrounded by blooming flowers and fairy lights...', 
'real-weddings', 'published', '2026-01-15 10:00:00'),
('Top 10 Wedding Planning Tips for 2026', 'top-10-wedding-planning-tips-2026',
'<p>Essential tips to make your wedding planning journey smooth and stress-free. From choosing vendors to managing timelines.</p>',
'Essential tips to make your wedding planning journey smooth and stress-free...',
'wedding-tips', 'published', '2026-01-10 14:00:00');

-- Insert sample contact inquiries
INSERT INTO contact_inquiries (name, email, phone, wedding_date, guest_count, venue_type, budget_range, services_interest, message, status, priority) VALUES
('Sarah Johnson', 'sarah.j@email.com', '+1 (555) 123-4567', '2026-06-15', 120, 'Garden Wedding', '$15,000 - $20,000', 'Full Planning, Photography', 'Hi! I\'m getting married next June and would love to discuss your full planning package.', 'new', 'high'),
('Michael & Emily Chen', 'emily.chen@email.com', '+1 (555) 987-6543', '2026-08-20', 200, 'Ballroom', '$25,000 - $30,000', 'Planning, Catering, Flowers', 'We\'re planning our dream wedding and would love to meet with you.', 'contacted', 'medium'),
('Jessica Williams', 'jessica.w@email.com', '+1 (555) 456-7890', '2026-09-10', 80, 'Beach Wedding', '$10,000 - $15,000', 'Photography, Flowers', 'Looking for photography services for our intimate beach wedding.', 'closed', 'low');

-- Create upload directories (this would need to be done manually)
-- mkdir -p uploads/gallery
-- mkdir -p uploads/blog
-- mkdir -p uploads/backups
-- chmod 755 uploads/gallery uploads/blog uploads/backups