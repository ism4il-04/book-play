# Book&Play - Sports Venue Management System

A comprehensive web application for managing sports venues, bookings, tournaments, and user interactions.

## 🏆 Features

### User Features
- **Dashboard**: Personal dashboard with booking history and statistics
- **Venue Booking**: Browse and book sports venues
- **Tournament Participation**: Join and participate in tournaments
- **Profile Management**: User profile and settings
- **Notifications**: Real-time notifications for bookings and updates

### Manager Features (Gestionnaire)
- **Dashboard**: Management overview with key metrics
- **Terrain Management**: Add, edit, and manage sports venues
- **Reservation Management**: Handle booking requests and confirmations
- **Tournament Management**: Create and manage tournaments
- **Communication**: Mail system for user communication

### Admin Features
- **System Overview**: Complete system administration
- **User Management**: Manage users and permissions
- **Analytics**: Detailed reports and analytics
- **System Settings**: Configure application settings

## 🚀 Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5.3.3
- **Backend**: PHP 8.0+
- **Database**: MySQL
- **Icons**: Bootstrap Icons
- **Server**: XAMPP (Apache, MySQL, PHP)

## 📁 Project Structure

```
book-play/
├── admin/                          # Admin dashboard pages
│   └── dashboard.php
├── assets/                         # Static assets
│   └── images/
├── gestionnaire/                   # Manager dashboard pages
│   └── dashboard.php
├── includes/                       # Shared components
│   ├── admin/                      # Admin components
│   │   ├── admin_header.php
│   │   ├── admin_footer.php
│   │   ├── admin_navbar.php
│   │   └── admin_style.css
│   ├── gestionnaire/               # Manager components
│   │   ├── gestionnaire_header.php
│   │   ├── gestionnaire_footer.php
│   │   ├── gestionnaire_navbar.php
│   │   └── gestionnaire_style.css
│   ├── user/                       # User components
│   │   ├── user_header.php
│   │   ├── user_footer.php
│   │   ├── user_navbar.php
│   │   └── user_style.css
│   ├── landing/                    # Landing page components
│   │   └── landing_style.css
│   └── db.php                      # Database connection
├── user/                           # User dashboard pages
│   └── dashboard.php
├── index.php                       # Main entry point
├── landing.php                     # Landing page
└── README.md
```

## 🛠️ Installation & Setup

### Prerequisites
- XAMPP (Apache, MySQL, PHP 8.0+)
- Git
- Web browser

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/book-play.git
   cd book-play
   ```

2. **Setup XAMPP**
   - Start Apache and MySQL services
   - Create a new database named `book_play`

3. **Configure Database**
   - Import the database schema (if available)
   - Update database credentials in `includes/db.php`

4. **Access the Application**
   - Navigate to `http://localhost/book-play`
   - The application should be ready to use

## 🎨 Design System

### Color Palette
- **Primary Green**: `#28a745` (Bootstrap Success)
- **Secondary Green**: `#2ecc71` (Modern Green)
- **Background**: `#f9fdf9` (Light Green Tint)
- **Text**: `#495057` (Dark Gray)

### Typography
- **Font Family**: Poppins (Google Fonts)
- **Weights**: 400, 500, 600, 700

### Components
- **Navbars**: Horizontal for users, vertical for managers/admins
- **Cards**: Glassmorphism design with backdrop blur
- **Buttons**: Gradient backgrounds with hover effects
- **Forms**: Modern styling with focus states

## 👥 User Roles

### 1. Regular Users
- Browse and book venues
- Participate in tournaments
- Manage personal profile
- View booking history

### 2. Managers (Gestionnaire)
- Manage venues and bookings
- Create and manage tournaments
- Handle user communications
- View management analytics

### 3. Administrators
- Full system access
- User and role management
- System configuration
- Advanced analytics

## 🔧 Development

### Adding New Features
1. Create feature branch: `git checkout -b feature/feature-name`
2. Implement changes
3. Test thoroughly
4. Commit changes: `git commit -m "Add feature-name"`
5. Push to branch: `git push origin feature/feature-name`
6. Create pull request

### Code Style
- Use consistent indentation (2 spaces)
- Comment complex logic
- Follow PHP PSR standards
- Use meaningful variable names

## 📱 Responsive Design

The application is fully responsive with:
- **Desktop**: Full sidebar navigation
- **Tablet**: Collapsible navigation
- **Mobile**: Hamburger menu with slide-out navigation

## 🚀 Deployment

### Production Checklist
- [ ] Update database credentials
- [ ] Configure proper file permissions
- [ ] Enable error logging
- [ ] Setup SSL certificate
- [ ] Configure backup strategy

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test your changes
5. Submit a pull request

See [CONTRIBUTING.md](CONTRIBUTING.md) for detailed guidelines.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Team

- **Project Lead**: [Your Name]
- **Backend Developer**: [Team Member]
- **Frontend Developer**: [Team Member]
- **UI/UX Designer**: [Team Member]

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Contact the development team
- Check the documentation

## 🔄 Version History

- **v1.0.0** - Initial release with basic functionality
- **v1.1.0** - Added manager dashboard
- **v1.2.0** - Added admin panel
- **v1.3.0** - Enhanced UI/UX design

---

**Book&Play** - Making sports venue management simple and efficient! 🏆
