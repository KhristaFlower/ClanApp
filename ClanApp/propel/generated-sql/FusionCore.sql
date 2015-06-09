
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255),
    `password` VARCHAR(60) NOT NULL,
    `remember_token` VARCHAR(60),
    `member_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `users_fi_5af046` (`member_id`),
    CONSTRAINT `users_fk_5af046`
        FOREIGN KEY (`member_id`)
        REFERENCES `members` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- members
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `joined_on` DATE,
    `left_on` DATE,
    `rank` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- permissions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tag` VARCHAR(30) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_roles_fi_69bd79` (`user_id`),
    INDEX `user_roles_fi_06a84f` (`role_id`),
    CONSTRAINT `user_roles_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `user_roles_fk_06a84f`
        FOREIGN KEY (`role_id`)
        REFERENCES `roles` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- role_permissions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `permission_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `role_permissions_fi_0429e3` (`permission_id`),
    INDEX `role_permissions_fi_06a84f` (`role_id`),
    CONSTRAINT `role_permissions_fk_0429e3`
        FOREIGN KEY (`permission_id`)
        REFERENCES `permissions` (`id`),
    CONSTRAINT `role_permissions_fk_06a84f`
        FOREIGN KEY (`role_id`)
        REFERENCES `roles` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
