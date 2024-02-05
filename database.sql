-- Create table to store User login and other information
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- FOR TESTING remove in prod
INSERT INTO Users (username, email, first_name, last_name, password)
VALUES
("userAA", "AA@email.com", "A", "A", "password"),
("userBB", "BB@email.com", "B", "B", "password"),
("userCC", "CC@email.com", "C", "C", "password"),
("userDD", "DD@email.com", "D", "D", "password"),
("userEE", "EE@email.com", "E", "E", "password");

-- LATER can add config files for themes and such
-- password should be hashed
