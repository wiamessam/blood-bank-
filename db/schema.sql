-- Blood Donation upgraded schema
CREATE DATABASE IF NOT EXISTS blood_upgrade;
USE blood_upgrade;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','superadmin') DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (username, password, role) VALUES ('admin', MD5('admin'), 'superadmin');

CREATE TABLE hospitals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200),
  address TEXT,
  phone VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE schedules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hospital_id INT,
  tanggal DATE,
  slot_total INT,
  slot_available INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (hospital_id) REFERENCES hospitals(id) ON DELETE CASCADE
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  schedule_id INT,
  name VARCHAR(200),
  phone VARCHAR(50),
  blood_type VARCHAR(5),
  queue_no INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (schedule_id) REFERENCES schedules(id) ON DELETE CASCADE
);

-- sample data
INSERT INTO hospitals (name,address,phone) VALUES
('RSU Ananda','Jl. Contoh No.1','081234567890'),
('Puskesmas Barat','Jl. Barat No.5','081298765432');

INSERT INTO schedules (hospital_id, tanggal, slot_total, slot_available) VALUES
(1, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 20, 20),
(1, DATE_ADD(CURDATE(), INTERVAL 7 DAY), 15, 15),
(2, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 10, 10);
