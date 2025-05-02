DROP TABLE IF EXISTS `skills`;

CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `skills` (`name`, `category`, `description`) VALUES
('PHP', 'Programming Languages', 'Advanced PHP development with modern frameworks'),
('JavaScript', 'Programming Languages', 'Frontend development with modern frameworks'),
('Laravel', 'Frameworks', 'Full-stack development with Laravel'),
('React', 'Frameworks', 'Frontend development with React'),
('MySQL', 'Databases', 'Database design and optimization'),
('Git', 'Tools', 'Version control and collaboration'); 