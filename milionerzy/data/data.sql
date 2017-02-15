USE milionerzy;

DROP TABLE IF EXISTS `answers`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `prizes`;

CREATE TABLE `prizes`(
  `id` INT(10) UNSIGNED AUTO_INCREMENT,
  `value` INT(10) NOT NULL,
  `guarantee` ENUM ('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC;


CREATE TABLE `questions`(
  `id` INT(10) UNSIGNED AUTO_INCREMENT,
  `prizes_id` INT(10) UNSIGNED NOT NULL,
  `question` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`prizes_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`prizes_id`) REFERENCES `prizes` (`id`)
    ON DELETE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARSET = utf8
ROW_FORMAT = DYNAMIC;

CREATE TABLE `answers`(
  `id` INT(10) UNSIGNED AUTO_INCREMENT,
  `questions_id` INT(10) UNSIGNED NOT NULL,
  `answer` VARCHAR(255) NOT NULL,
  `correct` ENUM ('true','false') NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`questions_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC;