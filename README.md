Brunch Restaurant Management System

Overview                                                                                                                                                                                                                                      

Brunch is a web-based restaurant management system designed to streamline operations for a brunch-focused restaurant. It provides a user-friendly interface for customers to explore the menu, make table reservations, and read blog posts, while offering administrators tools to manage menus, tables, reservations, and user activities. Built with PHP, MySQL, HTML, CSS, and JavaScript, the system is ideal for small to medium-sized restaurants looking to enhance their online presence and operational efficiency.

Features





User Features:





Browse daily menus with image or PDF support.



Reserve tables with ambiance selection (indoor, outdoor, rooftop).



Cancel reservations via a dropdown interface.



Read blog posts about brunch recipes and restaurant updates.



User authentication (login/signup) with session management.



Admin Features:





Dashboard with statistics (menu items, logins, available tables, reservations).



Menu management: Upload, view, and delete daily menus.



Table management: View table statuses (booked/available).



Reservation management: Monitor all bookings.



User activity tracking: View registered users and their roles.



System settings management (e.g., restaurant details).



Responsive Design: Optimized for both desktop and mobile devices.



Dynamic Content: Real-time updates for reservations and menu displays.



Secure Authentication: Password hashing and session-based access control.

Project Structure

Brunch/
├── css/
│   ├── admin.css
│   ├── blog.css
│   ├── Booking.css
│   ├── food.css
│   ├── login.css
│   ├── menu.css
│   ├── readmore.css
│   ├── Signup.css
├── html/
│   ├── admin.php
│   ├── Blog.php
│   ├── Booking.php
│   ├── cancel_reservation.php
│   ├── indexhome.php
│   ├── Login.php
│   ├── logout.php
│   ├── menu.php
│   ├── Readmore.php
│   ├── Signup.php
├── js/
│   ├── admin.js
│   ├── Booking.js
│   ├── dropdown.js
│   ├── menu.js
│   ├── node.js
│   ├── slider.js
├── images/
│   ├── (menu files, logos, and other assets)
└── README.md

Technologies Used





Frontend: HTML, CSS, JavaScript, Font Awesome (for icons)



Backend: PHP



Database: MySQL



External Libraries:





Font Awesome (v6.4.0) for icons



Google Fonts (Lora, Poppins) for typography



Server: Local development with XAMPP/WAMP (Apache, MySQL)

Prerequisites

To run this project locally, ensure you have the following installed:





XAMPP/WAMP or any server environment with PHP and MySQL support



PHP (version 7.4 or higher recommended)



MySQL (version 5.7 or higher)



Web Browser (Chrome, Firefox, or any modern browser)



Git (for cloning the repository)

Setup Instructions





Clone the Repository

git clone https://github.com/your-username/Brunch.git



Set Up the Web Server





Move the Brunch folder to your server's root directory (e.g., htdocs for XAMPP).



Ensure Apache and MySQL services are running in XAMPP/WAMP.



Configure the Database





Create a MySQL database named food_chain.



Import the following SQL schema to create the necessary tables:

CREATE DATABASE food_chain;

USE food_chain;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tables (
    table_id INT AUTO_INCREMENT PRIMARY KEY,
    capacity INT NOT NULL,
    location ENUM('indoor', 'outdoor', 'rooftop') NOT NULL
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL,
    table_id INT NOT NULL,
    ambiance ENUM('indoor', 'al-fresco', 'rooftop') NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (table_id) REFERENCES tables(table_id)
);

-- Insert sample admin user
INSERT INTO users (user, password, role) VALUES ('taha@brunch.com', '$2y$10$YOUR_HASHED_PASSWORD', 'admin');

Replace $YOUR_HASHED_PASSWORD with a hashed password generated using PHP's password_hash() function.



Update Database Configuration





Ensure the database connection settings in admin.php, Booking.php, cancel_reservation.php, Login.php, menu.php, and Signup.php match your MySQL credentials:

$conn = new mysqli("localhost", "root", "", "food_chain");



Set Up File Permissions





Ensure the images/ directory is writable (e.g., chmod 777 images on Linux) for menu uploads.



Access the Application





Open your browser and navigate to http://localhost/Brunch/html/indexhome.php.



Use the admin credentials (taha@brunch.com) to access the admin dashboard (admin.php).

Usage





For Customers:





Visit the homepage (indexhome.php) to explore the restaurant, read blogs, or view the menu.



Sign up or log in to book a table (Booking.php).



Cancel reservations via the dropdown in the booking page.



For Admins:





Log in with admin credentials to access the dashboard (admin.php).



Manage daily menus, view table statuses, monitor reservations, and update settings.

Contributing

Contributions are welcome! To contribute:





Fork the repository.



Create a new branch (git checkout -b feature/your-feature).



Make your changes and commit (git commit -m "Add your feature").



Push to the branch (git push origin feature/your-feature).



Create a pull request on GitHub.

Please ensure your code follows the project's coding style and includes appropriate comments.

License

This project is licensed under the MIT License. See the LICENSE file for details.

Acknowledgments _





Font Awesome for icons.



Google Fonts for typography.



Freepik for placeholder images.

Contact

For questions or support, contact the project maintainer at mt981708@gmail.com.
