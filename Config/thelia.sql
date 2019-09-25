
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- priceobservatorycr_feed
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `priceobservatorycr_feed`;

CREATE TABLE `priceobservatorycr_feed`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(255),
    `lang_id` INTEGER NOT NULL,
    `currency_id` INTEGER NOT NULL,
    `country_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_priceobservatorycr_feed_lang_id` (`lang_id`),
    INDEX `FI_priceobservatorycr_feed_currency_id` (`currency_id`),
    INDEX `FI_priceobservatorycr_feed_country_id` (`country_id`),
    CONSTRAINT `fk_priceobservatorycr_feed_lang_id`
        FOREIGN KEY (`lang_id`)
        REFERENCES `lang` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_priceobservatorycr_feed_currency_id`
        FOREIGN KEY (`currency_id`)
        REFERENCES `currency` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_priceobservatorycr_feed_country_id`
        FOREIGN KEY (`country_id`)
        REFERENCES `country` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- priceobservatorycr_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `priceobservatorycr_log`;

CREATE TABLE `priceobservatorycr_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `feed_id` INTEGER NOT NULL,
    `separation` TINYINT(1) NOT NULL,
    `level` INTEGER NOT NULL,
    `pse_id` INTEGER,
    `message` TEXT NOT NULL,
    `help` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_priceobservatorycr_log_feed_id` (`feed_id`),
    INDEX `FI_priceobservatorycr_log_pse_id` (`pse_id`),
    CONSTRAINT `fk_priceobservatorycr_log_feed_id`
        FOREIGN KEY (`feed_id`)
        REFERENCES `priceobservatorycr_feed` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_priceobservatorycr_log_pse_id`
        FOREIGN KEY (`pse_id`)
        REFERENCES `product_sale_elements` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
