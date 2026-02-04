# The Wedding Company - Matrimony Platform

A premium matrimony platform offering smart matchmaking, comprehensive background verification, and horoscope compatibility analysis.

## 🎯 Features

### Core Services
- **Smart Matchmaking**: Advanced AI-powered algorithm for compatibility matching
- **Background Verification**: Comprehensive verification (identity, employment, education, family background)
- **Horoscope Compatibility**: Vedic astrology analysis and Kundli matching
- **Relationship Counseling**: Professional guidance from experienced advisors
- **Profile Management**: Professional profile creation and optimization
- **Privacy & Security**: 100% encrypted data protection

### Membership Plans
- **Basic**: ₹9,999 (3 months)
- **Standard**: ₹17,999 (6 months) - Most Popular
- **Premium**: ₹29,999 (12 months)
- **Elite**: ₹49,999 (12 months + Exclusive)

## 📁 Project Structure

```
The Wedding Company Website/
├── index.html              # Homepage with hero, features, and services
├── services.html           # Detailed matrimony services
├── pricing.html            # Membership plans and pricing
├── gallery.html            # Success stories showcase
├── blog.html              # Matrimony stories and articles
├── contact.html           # Contact and registration form
├── script.js              # Frontend JavaScript
├── admin/                 # Admin panel
│   ├── dashboard.html     # Admin dashboard
│   ├── blog-management.html
│   ├── gallery-management.html
│   ├── services-management.html
│   ├── contact-management.html
│   ├── login.html         # Admin login
│   ├── auth.js            # Authentication logic
│   ├── data-store.js      # Data management
│   ├── storage-utils.js   # Utility functions
│   └── backend/           # PHP backend
│       ├── db.php         # Database connection
│       ├── login.php      # Login API
│       ├── blog-api.php   # Blog management API
│       ├── gallery-api.php
│       ├── services-api.php
│       ├── contact-api.php
│       ├── database.sql   # Database schema
│       └── insert_admin.sql
├── README.md              # This file
└── .gitignore             # Git ignore rules
```

## 🚀 Getting Started

### Prerequisites
- Web server (Apache, Nginx)
- PHP 7.4+
- MySQL 5.7+
- Modern web browser

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/wedding-matrimony-platform.git
   cd wedding-matrimony-platform
   ```

2. **Set up the database**
   ```bash
   # Create database
   mysql -u root -p < admin/backend/database.sql
   
   # Insert admin user
   mysql -u root -p < admin/backend/insert_admin.sql
   ```

3. **Configure database connection**
   - Edit `admin/backend/db.php`
   - Update database credentials

4. **Deploy to web server**
   - Copy all files to your web server root directory
   - Access via `http://your-domain.com`

## 📝 Usage

### For Users
1. Visit the homepage at `index.html`
2. Browse services on `services.html`
3. Choose a membership plan from `pricing.html`
4. Register and create your profile
5. Get matched with compatible partners
6. Access horoscope compatibility reports

### For Admins
1. Navigate to `/admin/login.html`
2. Login with admin credentials
3. Access dashboard to manage:
   - Blog posts
   - Gallery
   - Services
   - Contacts
   - Site settings

## 🔧 Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Icons**: Font Awesome 6.0.0
- **Styling**: Custom CSS with gradient effects and animations

## 📱 Pages

- **index.html** - Main landing page with hero section, features, and call-to-action
- **services.html** - Complete list of 9 matrimony services
- **pricing.html** - Membership plans with FAQs
- **gallery.html** - Success stories and testimonials
- **blog.html** - Matrimony stories and articles
- **contact.html** - Contact form for inquiries
- **admin/dashboard.html** - Admin control panel

## 🎨 Design Features

- Responsive design (mobile-friendly)
- Smooth animations and transitions
- Gradient backgrounds
- Professional color scheme (red/gold theme)
- Accessible HTML structure
- SEO-optimized

## 📊 Key Metrics

- 50,000+ Happy Couples Matched
- 100% Profile Verification
- 98% Client Satisfaction
- 10+ Years Experience
- 24/7 Customer Support

## 🔒 Security

- Encrypted data storage
- Secure authentication
- Background verification system
- Privacy-first approach
- Data protection compliance

## 📧 Contact

- **Email**: info@theweddingcompany.com
- **Phone**: +91 (800) 123-4567
- **Address**: 123 Wedding Plaza, Event City, EC 12345

## 📄 License

This project is proprietary and confidential.

## 🤝 Contributing

For contributions, please contact the development team.

## 📆 Changelog

### Version 1.0.0 (Feb 2026)
- Initial launch
- Core matrimony features
- Admin panel
- Membership system
- Horoscope compatibility
- Background verification

---

**Made with ❤️ by The Wedding Company**
