<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketBanner extends Model
{
  use SoftDeletes;
}


/*
CREATE TABLE `market_banners` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL DEFAULT NULL COMMENT '베너위치값' COLLATE 'utf8mb4_unicode_ci',
	`image` VARCHAR(255) NULL DEFAULT NULL COMMENT '이미지' COLLATE 'utf8mb4_unicode_ci',
	`title` VARCHAR(50) NULL DEFAULT NULL COMMENT '베너타이틀' COLLATE 'utf8mb4_unicode_ci',
	`description` VARCHAR(255) NULL DEFAULT NULL COMMENT '베너설명' COLLATE 'utf8mb4_unicode_ci',
	`url` VARCHAR(255) NULL DEFAULT NULL COMMENT '베너 링크' COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;

*/