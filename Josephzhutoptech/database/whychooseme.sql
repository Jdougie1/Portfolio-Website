DROP TABLE IF EXISTS whychooseme;

CREATE TABLE whychooseme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO whychooseme (title, description) VALUES
('Technical Skills', 'Strong foundation in web development technologies including HTML, CSS, JavaScript, and PHP. Experience with modern frameworks and tools.'),
('Problem Solving', 'Demonstrated ability to analyze complex problems and develop efficient solutions. Experience in debugging and optimizing code.'),
('Team Collaboration', 'Excellent communication skills and experience working in team environments. Able to contribute effectively to group projects.'),
('Learning Agility', 'Quick to learn new technologies and adapt to changing requirements. Passionate about staying current with industry trends.'),
('Project Experience', 'Hands-on experience with real-world projects, demonstrating practical application of technical skills and problem-solving abilities.'); 