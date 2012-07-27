CREATE TABLE IF NOT EXISTS `user` (
`email` VARCHAR(255) UNIQUE NOT NULL,
`password` VARCHAR(32) NOT NULL,
PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `contact` (
`id` INT NOT NULL AUTO_INCREMENT,
`owner` VARCHAR(255) NOT NULL,
`first_name` VARCHAR(30) binary NOT NULL,
`last_name` VARCHAR(30) binary NOT NULL,
`email` VARCHAR(255) binary NOT NULL,
`phone` VARCHAR(64) NOT NULL,
`city` VARCHAR(30) binary NOT NULL,
`state` CHAR(2) NOT NULL,
`zip` VARCHAR(12) NOT NULL,
`web_addr` VARCHAR(255) DEFAULT NULL,
`second_phone` VARCHAR(255) DEFAULT NULL,
`street_addr` VARCHAR(255) binary DEFAULT NULL,
PRIMARY KEY (`id`),
FULLTEXT (`first_name`, `last_name`, `email`),
INDEX idx_user(`owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- some sample data
INSERT INTO `user` (`email`, `password`) VALUES
('flowerguy@gmail.com', MD5('guest'))
;

INSERT INTO `contact` (`owner`, `first_name`, `last_name`, `email`, `phone`, `city`, `state`, `zip`) VALUES
('flowerguy@gmail.com', 'Taehoon', 'Kang', 'flowerguy@gmail.com', '415-320-7881', 'Hayward', 'CA', '94541')
,('flowerguy@gmail.com', 'Jeongeun', 'Kim', 'jeongeun@gmail.com', '4153207882', 'San Francisco', 'CA', '94108')
,('flowerguy@gmail.com', 'Mungsil', 'Kang', 'mungsil@gmail.com', '+1 (415) 320-7883 ext.2013', 'Yuba City', 'CA', '91098')
;