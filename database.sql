CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age TINYINT UNSIGNED NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional sample data:
-- INSERT INTO users (name, age, status) VALUES
-- ('John', 25, 0),
-- ('Sarah', 30, 1),
-- ('Michael', 22, 0);
