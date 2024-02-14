-- Create table to store User login and other information
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL
);
-- Create table to store Notes created by Users
CREATE TABLE IF NOT EXISTS Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    title VARCHAR(255) NOT NULL,
    -- file_path VARCHAR(255) NOT NULL UNIQUE, 
    -- use this later
    content VARCHAR(255),
    FOREIGN KEY (username) REFERENCES Users(username)
);
-- Create table to store Deadlines created by Users
CREATE TABLE IF NOT EXISTS Deadlines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    course VARCHAR(255) NOT NULL,
    deadline_name VARCHAR(255) NOT NULL,
    due_date date NOT NULL,
    FOREIGN KEY (username) REFERENCES Users(username)
);