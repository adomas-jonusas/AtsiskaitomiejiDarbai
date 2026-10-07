DROP DATABASE IF EXISTS darbai_db;
CREATE DATABASE darbai_db CHARACTER SET utf8mb4;
USE darbai_db;

CREATE TABLE darbai (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    darbas VARCHAR(255) NOT NULL,
    laikas DATETIME NULL,
    atliktas BOOLEAN DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO darbai (darbas, laikas, atliktas) VALUES
('Paruošti ataskaitą', DATE_ADD(NOW(), INTERVAL 2 DAY), 0),
('Pakartoti PHP pamoką', DATE_ADD(NOW(), INTERVAL 1 DAY), 0),
('Pateikti namų darbą', DATE_SUB(NOW(), INTERVAL 1 DAY), 0),
('Sutvarkyti užrašus', NULL, 0),
('Perskaityti užduotį', DATE_SUB(NOW(), INTERVAL 2 DAY), 1);
