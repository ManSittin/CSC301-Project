-- Create table to store User login and other information
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL
);
-- Create table to store Courses added by Users
CREATE TABLE IF NOT EXISTS Courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    course_name VARCHAR(255),
    FOREIGN KEY (username) REFERENCES Users(username)
);

-- Create table to store Flashcards created by Users
CREATE TABLE IF NOT EXISTS Flashcards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    cue VARCHAR(50) NOT NULL,
    response VARCHAR(255) NOT NULL,
    review_date DATE NOT NULL,
    priority INT NOT NULL,

    is_public BIT,
    tag_id INT DEFAULT NULL,
    FOREIGN KEY (username) REFERENCES Users(username),
    FOREIGN KEY (tag_id) REFERENCES Courses(id)
);

-- Create table to store Notes created by Users
CREATE TABLE IF NOT EXISTS Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    title VARCHAR(255) NOT NULL,
    -- file_path VARCHAR(255) NOT NULL UNIQUE, 
    -- use this later
    content VARCHAR(255),
    is_public BIT,
    tag_id INT DEFAULT NULL,
    FOREIGN KEY (username) REFERENCES Users(username),
    FOREIGN KEY (tag_id) REFERENCES Courses(id)
);
-- Create table to store Deadlines created by Users
CREATE TABLE IF NOT EXISTS Deadlines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16),
    course VARCHAR(255) NOT NULL,
    deadline_name VARCHAR(255) NOT NULL,
    due_date date NOT NULL,
    tag_id INT DEFAULT NULL,
    FOREIGN KEY (username) REFERENCES Users(username),
    FOREIGN KEY (tag_id) REFERENCES Courses(id)
);

CREATE TABLE IF NOT EXISTS Course_Timeslots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255),
    username VARCHAR(16),
    day_of_week VARCHAR(10),
    num_hours INT,
    start_time TIME
);

-- Create table to store Preferences that Users have
CREATE TABLE IF NOT EXISTS Preferences (
    preference_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    flashcard_algorithm VARCHAR(16),
    FOREIGN KEY (username) REFERENCES Users(username)
);

-- Create table to store Review Sessions that Users have
CREATE TABLE IF NOT EXISTS Review_Sessions (
    username VARCHAR(16),
    start_time DATETIME,
    end_time DATETIME NOT NULL,
    num_correct INT NOT NULL,
    num_incorrect INT NOT NULL,
    PRIMARY KEY (username, start_time),
    FOREIGN KEY (username) REFERENCES Users(username)
);

-- Create table to store Metrics for a User's Review Sessions
CREATE TABLE IF NOT EXISTS Metrics (
    username VARCHAR(16),
    context VARCHAR(16),
    occurrences INT NOT NULL,
    avg_accuracy FLOAT DEFAULT NULL, -- % of flashcards correctly recalled
    avg_speed FLOAT DEFAULT NULL, -- flashcards reviewed / min
    avg_volume FLOAT DEFAULT NULL, -- number of flashcards reviewed
    PRIMARY KEY (username, context),
    FOREIGN KEY (username) REFERENCES Users(username)
);

-- assumptions:
-- review sessions will last one day
-- if they start late at night and end the next day, the previous day is used
-- overall, start_time is what is used 

DELIMITER //

CREATE TRIGGER update_metrics 
AFTER INSERT ON Review_Sessions
FOR EACH ROW 
BEGIN
    DECLARE day_of_week_number INT; -- 0 = Mon, 1 = Tues, 2 = Wed, 3 = Thurs, 4 = Fri, 5 = Sat, 6 = Sun
    DECLARE day_of_week VARCHAR(16); 
    DECLARE time_of_day VARCHAR(16);
    DECLARE seconds_taken INT;
    DECLARE total_flashcards INT;
    DECLARE accuracy DECIMAL(5, 4); -- % of flashcards correctly recalled
    DECLARE speed FLOAT; -- flashcards / min
    DECLARE volume INT; -- number of flashcards reviewed
    DECLARE avg_accuracy_day DECIMAL(5,4);
    DECLARE avg_speed_day FLOAT;
    DECLARE avg_volume_day FLOAT;
    DECLARE avg_accuracy_time DECIMAL(5,4);
    DECLARE avg_speed_time FLOAT;
    DECLARE avg_volume_time FLOAT;
    DECLARE occurrences_day INT;
    DECLARE occurrences_time INT;
    
    -- get the day of the week of the review session
    SET day_of_week_number = WEEKDAY(DATE(NEW.start_time));
    SET day_of_week = CASE day_of_week_number
        WHEN 0 THEN 'Monday'
        WHEN 1 THEN 'Tuesday'
        WHEN 2 THEN 'Wednesday'
        WHEN 3 THEN 'Thursday'
        WHEN 4 THEN 'Friday'
        WHEN 5 THEN 'Saturday'
        WHEN 6 THEN 'Sunday'
        ELSE 'Invalid Day of Week'
    END;
    
    -- get the time of day of the review session
    IF TIME(NEW.start_time) BETWEEN '06:00:00' AND '12:00:00' THEN
        SET time_of_day = 'Morning';
    ELSEIF TIME(NEW.start_time) BETWEEN '12:00:01' AND '18:00:00' THEN
        SET time_of_day = 'Afternoon';
    ELSE
        SET time_of_day = 'Evening';
    END IF;

    -- compute quantities used for metrics
    SET seconds_taken = SECOND(TIMEDIFF(NEW.end_time, NEW.start_time));
    SET total_flashcards = NEW.num_correct + NEW.num_incorrect;

    -- compute metrics
    SET accuracy = NEW.num_correct / total_flashcards;
    SET speed = total_flashcards * 60 / (seconds_taken);
    SET volume = total_flashcards;

    -- get current metrics
    SET avg_accuracy_day = (
        SELECT avg_accuracy 
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = day_of_week
        );

    SET avg_speed_day = (
        SELECT avg_speed 
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = day_of_week
        );
    
    SET avg_volume_day = (
        SELECT avg_volume
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = day_of_week
        );
    
    SET occurrences_day = (
        SELECT occurrences
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = day_of_week
    );

    SET avg_accuracy_time = (
        SELECT avg_accuracy 
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = time_of_day
        );

    SET avg_speed_time = (
        SELECT avg_speed 
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = time_of_day
        );
    
    SET avg_volume_time = (
        SELECT avg_volume
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = time_of_day
        );
    
    SET occurrences_time = (
        SELECT occurrences
        FROM Metrics
        WHERE NEW.username = Metrics.username AND context = time_of_day
    );

    -- update day of week attributes
    IF avg_accuracy_day IS NULL THEN -- not recorded yet
        UPDATE Metrics 
        SET avg_accuracy = accuracy, avg_speed = speed, avg_volume = volume, occurrences = 1
        WHERE NEW.username = Metrics.username AND context = day_of_week;
    ELSE -- has been recorded
        UPDATE Metrics
        SET avg_accuracy = (avg_accuracy_day * occurrences_day + accuracy)/(occurrences_day + 1),
        avg_speed = (avg_speed_day * occurrences_day + speed)/(occurrences_day + 1),
        avg_volume = (avg_volume_day * occurrences_day + volume)/(occurrences_day + 1),
        occurrences = occurrences + 1
        WHERE NEW.username = Metrics.username AND context = day_of_week;
    END IF;

    -- update time of day attributes
     IF avg_accuracy_time IS NULL THEN -- not recorded yet
        UPDATE Metrics 
        SET avg_accuracy = accuracy, avg_speed = speed, avg_volume = volume, occurrences = 1
        WHERE NEW.username = Metrics.username AND context = time_of_day;
    ELSE -- has been recorded
        UPDATE Metrics
        SET avg_accuracy = (avg_accuracy_time * occurrences_time + accuracy)/(occurrences_time + 1),
        avg_speed = (avg_speed_time * occurrences_time + speed)/(occurrences_time + 1),
        avg_volume = (avg_volume_time * occurrences_time + volume)/(occurrences_time + 1),
        occurrences = occurrences + 1
        WHERE NEW.username = Metrics.username AND context = time_of_day;
    END IF;
END;
//

DELIMITER ;