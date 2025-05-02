DROP TABLE IF EXISTS experiences;

CREATE TABLE experiences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    start_date DATE NOT NULL,
    end_date DATE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO experiences (title, company, location, start_date, end_date, description) VALUES
('Software Developer', 'Tech Company', 'New York, NY', '2022-01-01', NULL, 'Developing web applications using modern technologies.'),
('Junior Developer', 'Startup Inc', 'San Francisco, CA', '2020-06-01', '2021-12-31', 'Worked on frontend development and UI/UX improvements.'); 