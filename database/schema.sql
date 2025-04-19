CREATE DATABASE IF NOT EXISTS db_blackcinema;
USE db_blackcinema;

-- Tabel Film
CREATE TABLE Movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    duration INT, -- dalam menit
    rating VARCHAR(10) -- contoh: PG-13, R, dll
);

-- Tabel Jadwal
CREATE TABLE Schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    date DATE,
    time TIME,
    FOREIGN KEY (movie_id) REFERENCES Movies(id) ON DELETE CASCADE
);

-- Tabel Tiket
CREATE TABLE Tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    schedule_id INT,
    name VARCHAR(100), -- nama pembeli tiket
    seat_number VARCHAR(10),
    FOREIGN KEY (schedule_id) REFERENCES Schedules(id) ON DELETE CASCADE
);
-- Insert film
INSERT INTO Movies (title, genre, duration, rating) VALUES
('Inception', 'Sci-Fi', 148, 'PG-13'),
('The Batman', 'Action', 176, 'R'),
('Toy Story', 'Animation', 81, 'G');

-- Insert jadwal
INSERT INTO Schedules (movie_id, date, time) VALUES
(1, '2025-04-20', '13:00:00'),
(1, '2025-04-20', '19:00:00'),
(2, '2025-04-21', '17:30:00'),
(3, '2025-04-22', '10:00:00');

-- Insert tiket
INSERT INTO Tickets (schedule_id, name, seat_number) VALUES
(1, 'Yattaqi Faza', 'A5'),
(1, 'Dian Permana', 'A6'),
(3, 'Rizky Maulana', 'B2');
