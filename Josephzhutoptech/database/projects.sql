DROP TABLE IF EXISTS `projects`;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `projects` (`title`, `description`, `start_date`, `end_date`, `github_url`, `demo_url`) VALUES
('Portfolio Website', 'A personal portfolio website built with PHP, MySQL, and Bootstrap to showcase my projects and skills.', '2024-01-01', NULL, 'https://github.com/username/portfolio', 'https://example.com/portfolio'),
('E-commerce Platform', 'An e-commerce website with user authentication, product management, and shopping cart functionality.', '2023-06-01', '2023-12-31', 'https://github.com/username/ecommerce', 'https://example.com/ecommerce'); 