-- <!-- SQL Schema -->

-- Users table to store farmer registration details
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Hashed password
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name, phone_number, email, password) VALUES
('John Smith', '+1-555-123-4567', 'john.smith@email.com', 'john123'),
('Mary Johnson', '+1-555-987-6543', 'mary.johnson@email.com', 'mary123' ),
('David Williams', '+1-555-654-7890', 'david.williams@email.com', 'david123' );


-- Admin table for platform administrators
CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Hashed password
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    last_login TIMESTAMP,
);

INSERT INTO admins (username, password, email, full_name) VALUES
('admin1', 'admin', 'admin1@farminsurance.com', 'Admin User One' ),
('admin2', 'admin2', 'admin2@farminsurance.com', 'Admin User Two' );



-----------------------------------
-- farmerdashboard
CREATE TABLE IF NOT EXISTS incidents (
    incident_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    aadhaar VARCHAR(12) NOT NULL,
    pan VARCHAR(10) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'processing') DEFAULT 'pending',
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--incident files
CREATE TABLE IF NOT EXISTS incident_files (
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    incident_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type ENUM('image', 'video') NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incident_id) REFERENCES incidents(incident_id) ON DELETE CASCADE
);

-- contact form
CREATE TABLE IF NOT EXISTS contact_submissions (
    submission_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--fetching the filed from farmer deshboard
SELECT COUNT(*) AS total_reports, 
               SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_reports, 
               SUM(CASE WHEN status = 'processed' THEN 1 ELSE 0 END) AS processed_claims, 
               COUNT(DISTINCT farmer_id) AS total_farmers 
        FROM reports;