-- Insert default admin user
-- Username: admin
-- Password: admin123
INSERT INTO admin_users (username, email, password, role, active) 
VALUES ('admin', 'admin@weddingcompany.com', '$2y$10$eImiTXuWVxfM37uY4JANjeyQyMHVUwV0KfFqI5FqI5FqI5FqI5Fq', 'admin', 1);
