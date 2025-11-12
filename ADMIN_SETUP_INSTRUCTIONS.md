# Admin Panel Setup Instructions

## Overview
This document provides instructions for setting up the admin panel for the AgroCraft E-commerce platform.

## Admin Credentials
- **Username:** admin
- **Password:** admin

## Setup Steps

### 1. Create Admin Table in Database

Execute the SQL commands from `admin_setup.sql` file in your phpMyAdmin or MySQL client:

```sql
-- Create admin table
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(255) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(50) NOT NULL UNIQUE,
  `admin_password` varchar(255) NOT NULL,
  `admin_email` varchar(100),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert admin credentials (username: admin, password: admin)
INSERT INTO `admin` (`admin_username`, `admin_password`, `admin_email`) VALUES 
('admin', 'yw==', 'admin@agrocraft.com');
```

### 2. Access Admin Login Page

Navigate to: `http://localhost/E-commerce/auth/AdminLogin.php`

### 3. Login with Admin Credentials

- Username: `admin`
- Password: `admin`

### 4. Admin Dashboard Features

Once logged in, you will have access to:

#### Dashboard
- View total farmers, buyers, products, and orders
- View total revenue
- See recent orders

#### Manage Farmers
- View all registered farmers
- View farmer details
- Delete farmer accounts

#### Manage Buyers
- View all registered buyers
- View buyer details
- Delete buyer accounts

#### Manage Products
- View all products
- View product details
- Delete products

#### Manage Orders
- View all orders
- View order details
- Delete orders

#### Admin Settings
- Change admin password
- View system information

## File Structure

```
Admin/
├── AdminDashboard.php      # Main dashboard
├── AdminLogout.php         # Logout functionality
├── ManageFarmers.php       # Manage farmers
├── ManageBuyers.php        # Manage buyers
├── ManageProducts.php      # Manage products
├── ManageOrders.php        # Manage orders
└── AdminSettings.php       # Admin settings

auth/
└── AdminLogin.php          # Admin login page

admin_setup.sql             # SQL setup file
```

## Security Notes

1. **Password Encryption:** All passwords are encrypted using AES-128-CTR encryption with:
   - Key: "DE"
   - IV: "2345678910111211"

2. **Session Management:** Admin sessions are managed using PHP sessions. Always logout when finished.

3. **Access Control:** All admin pages check for valid admin session before allowing access.

## Changing Admin Password

1. Go to Admin Settings
2. Enter your current password
3. Enter your new password
4. Confirm the new password
5. Click "Change Password"

## Troubleshooting

### Cannot Login
- Verify the admin table was created successfully
- Check that the admin credentials were inserted correctly
- Ensure the database connection is working

### Session Issues
- Clear browser cookies
- Check that PHP sessions are enabled on your server
- Verify the session.save_path is writable

### Database Connection Error
- Check the database credentials in `Includes/db.php`
- Ensure MySQL server is running
- Verify the database name is correct

## Default Admin Credentials

**Important:** Change the default admin password immediately after first login for security purposes.

To change password:
1. Login with default credentials
2. Go to Admin Settings
3. Change the password

## Additional Notes

- The admin panel uses Bootstrap 4 for responsive design
- Font Awesome icons are used throughout the interface
- The color scheme matches the existing AgroCraft design (goldenrod and dark gray)
- All pages are mobile-responsive

## Support

For issues or questions, please refer to the main project documentation or contact the development team.
