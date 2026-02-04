# Wedding Company Admin Portal & CMS

A comprehensive Content Management System (CMS) for The Wedding Company website with full administrative capabilities.

## 🚀 Features

### Admin Dashboard
- **Modern & Responsive Design**: Clean, professional interface that works on all devices
- **Real-time Statistics**: View website metrics and activity at a glance
- **Quick Actions**: Fast access to common administrative tasks

### Content Management
- **Blog Management**: Create, edit, delete, and manage blog posts with rich text editor
- **Gallery Management**: Upload, organize, and manage wedding photos by categories
- **Services Management**: Add, edit, and organize wedding services with features and pricing
- **Contact Management**: View and respond to customer inquiries with status tracking

### System Features
- **User Authentication**: Secure login system with session management
- **Settings Panel**: Configure site settings, colors, contact info, and notifications
- **Backup System**: Automated and manual backup capabilities
- **Security**: Password policies, session timeouts, and activity logging

## 📁 File Structure

```
admin/
├── login.html              # Admin login page
├── dashboard.html          # Main admin dashboard
├── blog-management.html    # Blog post management
├── gallery-management.html # Image gallery management
├── services-management.html # Services CRUD operations
├── contact-management.html # Customer inquiry management
├── settings.html          # System settings and configuration
└── backend/
    ├── db.php             # Database connection and classes
    └── database.sql       # Database schema and sample data
```

## 🛠️ Installation

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4+ with PDO extension
- MySQL/MariaDB database
- Write permissions for upload directories

### Setup Steps

1. **Database Setup**
   ```sql
   -- Run the database.sql file to create tables and sample data
   mysql -u username -p < admin/backend/database.sql
   ```

2. **Configure Database Connection**
   ```php
   // Edit admin/backend/db.php
   $host = 'localhost';
   $dbname = 'wedding_company_cms';
   $username = 'your_db_username';
   $password = 'your_db_password';
   ```

3. **Set File Permissions**
   ```bash
   mkdir -p uploads/gallery uploads/blog uploads/backups
   chmod 755 uploads/gallery uploads/blog uploads/backups
   ```

4. **Access the Admin Panel**
   - Navigate to: `http://yoursite.com/admin/login.html`
   - Default credentials:
     - Username: `admin`
     - Password: `wedding2026`

## 🔐 Security Features

### Authentication
- Secure password hashing (bcrypt)
- Session-based authentication
- Login attempt monitoring
- Automatic session timeout

### Data Protection
- SQL injection prevention with prepared statements
- XSS protection for user inputs
- File upload validation
- Activity logging for audit trails

### Password Policy
- Minimum 8 characters required
- Strong password enforcement option
- Regular password change reminders
- Two-factor authentication support (configurable)

## 📊 Database Schema

### Core Tables
- **admin_users**: Administrator accounts and permissions
- **blog_posts**: Blog articles with categories and status
- **gallery_images**: Photo gallery with categorization
- **contact_inquiries**: Customer contact forms and inquiries
- **services**: Wedding services with pricing and features
- **settings**: System-wide configuration options

### Supporting Tables
- **activity_logs**: Audit trail of admin actions
- **backup_logs**: Backup history and status
- **email_templates**: Customizable email templates

## 🎨 Customization

### Theme Colors
- **Primary Color**: #c41e3a (Wedding Red)
- **Secondary Color**: #e8b4ba (Soft Pink)
- **Accent Color**: #d4a574 (Gold)

Colors can be customized through the Settings panel under Appearance.

### Content Categories
- **Blog**: Real Weddings, Tips, Trends, Planning Guide, Inspiration
- **Gallery**: Ceremonies, Receptions, Portraits, Details
- **Services**: Fully customizable with icons and features

## 📱 Mobile Responsive

The admin panel is fully responsive and optimized for:
- Desktop computers (1200px+)
- Tablets (768px - 1199px)
- Mobile phones (< 768px)

Features collapse-able sidebar navigation for smaller screens.

## ⚙️ Configuration Options

### Site Settings
- Site name, tagline, and description
- Contact information and address
- Social media links
- SEO meta information

### Notification Settings
- Email notifications for new inquiries
- Weekly activity reports
- System alerts and updates

### Backup Settings
- Automatic backup scheduling
- Manual backup creation
- Backup retention policies
- Restore from backup functionality

## 🔧 Advanced Features

### Rich Text Editor
- Quill.js-powered blog editor
- Image embedding support
- Formatting tools and styles
- HTML source editing

### Image Management
- Drag-and-drop uploads
- Multiple file support
- Image categorization
- Automatic thumbnail generation

### Contact Management
- Inquiry status tracking
- Priority assignment
- Email response system
- Export to CSV functionality

## 🚀 Future Enhancements

### Planned Features
- **Multi-user Support**: Role-based access control
- **API Integration**: RESTful API for mobile apps
- **Analytics Dashboard**: Google Analytics integration
- **Email Marketing**: Newsletter and campaign management
- **Appointment Booking**: Calendar integration for consultations
- **Client Portal**: Dedicated area for wedding couples

### Performance Optimizations
- **Image Compression**: Automatic image optimization
- **Content Caching**: Redis/Memcached support
- **CDN Integration**: Content delivery network support
- **Database Optimization**: Query optimization and indexing

## 🛡️ Backup & Recovery

### Automated Backups
- Daily, weekly, or monthly schedules
- Database and file backups
- Email notifications for backup status
- Retention policy management

### Manual Operations
- On-demand backup creation
- Selective backup options
- One-click restore functionality
- Backup validation and integrity checks

## 📞 Support & Maintenance

### Regular Tasks
- **Update passwords** every 90 days
- **Review backup logs** weekly
- **Monitor disk space** for uploads
- **Check security logs** regularly

### Troubleshooting
- Check PHP error logs for issues
- Verify database connections
- Ensure file permissions are correct
- Monitor server resources

## 🔒 Security Best Practices

1. **Regular Updates**: Keep PHP and database software updated
2. **Strong Passwords**: Use complex passwords for all accounts
3. **SSL Certificate**: Ensure HTTPS is enabled for admin areas
4. **File Permissions**: Restrict upload directory permissions
5. **Backup Strategy**: Maintain off-site backup copies
6. **Monitor Access**: Review login attempts and activity logs

---

**Note**: This CMS is designed specifically for wedding planning businesses but can be adapted for other service-based industries with minimal modifications.

For technical support or customization requests, please contact the development team.