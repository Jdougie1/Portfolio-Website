SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `whychooseme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about` VALUES (1,'Joseph Zhu','Student','-Rising Junior at the University of Central Florida\r\n-3.7 GPA \r\nCoursework: Computer Science 1, Object Oriented Programming, Calculus, Physics, Discrete Structures, Systems Software, Computer Organization and Logic.','assets/images/1746162089_headshotphoto.jpg','2025-05-02 03:14:29','2025-05-02 05:01:29');

INSERT INTO `experiences` VALUES (5,'Hackabull','USF','Tampa','2025-05-12',NULL,'','2025-05-02 04:46:07');

INSERT INTO `projects` VALUES (4,'Figurine Marketplace','Created an interactive Figurine Selling Website using PHP, SQL, mySQL, JavaScript, React, all run on a Vite server.','https://github.com/Jdougie1/Figurine-Marketplace','','2025-04-26','2025-05-01','2025-05-02 04:15:50'),(5,'Portfolio Website ','A reactive portfolio website created with SQL, mySQL, CSS, HTML, PHP, and JavaScript.','https://github.com/Jdougie1/Portfolio-Website','','2025-05-01','2025-05-04','2025-05-02 04:19:05'),(6,'DialedIn','-uses mongodb','https://github.com/Jdougie1/DialedIn','','2025-04-14','2025-04-15','2025-05-02 04:20:55');

INSERT INTO `skills` VALUES (1,'PHP','Programming Languages','Advanced PHP development with modern frameworks','2025-05-02 04:15:07','2025-05-02 04:15:07'),(2,'JavaScript','Programming Languages','Frontend development with modern frameworks','2025-05-02 04:15:07','2025-05-02 04:15:07'),(5,'MySQL','Databases','Database design and optimization','2025-05-02 04:15:07','2025-05-02 04:15:07'),(6,'Git','Tools','Version control and collaboration','2025-05-02 04:15:07','2025-05-02 04:15:07'),(11,'Node.js, React.js, Express.js','Frameworks','','2025-05-02 05:14:20','2025-05-02 05:14:20');

INSERT INTO `whychooseme` VALUES (1,'Technical Skills','Strong foundation in web development technologies including HTML, CSS, JavaScript, and PHP. Experience with modern frameworks and tools.','2025-05-02 04:15:07'),(2,'Problem Solving','Demonstrated ability to analyze complex problems and develop efficient solutions. Experience in debugging and optimizing code.','2025-05-02 04:15:07'),(3,'Team Collaboration','Excellent communication skills and experience working in team environments. Able to contribute effectively to group projects.','2025-05-02 04:15:07'),(4,'Learning Agility','Quick to learn new technologies and adapt to changing requirements. Passionate about staying current with industry trends.','2025-05-02 04:15:07'),(5,'Project Experience','Hands-on experience with real-world projects, demonstrating practical application of technical skills and problem-solving abilities.','2025-05-02 04:15:07');

SET FOREIGN_KEY_CHECKS = 1; 